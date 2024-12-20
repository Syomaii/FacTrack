<?php

namespace App\Http\Controllers;

use App\Events\AcceptEquipmentReservationEvent;
use App\Events\AcceptFacilityReservationEvent;
use App\Events\DeclineEquipmentReservationEvent;
use App\Events\DeclineFacilityReservationEvent;
use App\Events\FacilityReservationEvent;
use App\Events\ReserveEquipmentEvent;
use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentReservation;
use App\Models\Facility;
use App\Models\FacilityReservation;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function showReservationForm($code)
    {
        $equipment = Equipment::where('code', $code)->firstOrFail();

        $equipmentReservations = EquipmentReservation::with('equipment')->where('equipment_id', $equipment->id)->get();

        return view('reservations.reserve_equipment', compact('equipment', 'equipmentReservations'))->with('title', 'Reserve Equipment');
    }

    public function storeReservation(Request $request, $code) {
        $request->validate([
            'purpose' => 'required|string|max:255',
            'reservation_date' => 'required|date|after_or_equal:' . now()->startOfMinute()->toDateTimeString(),
            'expected_return_date' => 'required|date|after:reservation_date',
        ]);
    
        $equipment = Equipment::where('code', $code)->firstOrFail();
        
        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'Equipment not found.']);
        }
    
        $office = $equipment->facility->office->id; 
        $reserver = Auth::user();
        
        if ($reserver->type === 'student') {
            $reservers_id_no = $reserver->student_id;
        } else if ($reserver->type === 'faculty') {
            $reservers_id_no = $reserver->faculty_id;
        }
    
        // Check if the equipment is already reserved in the given time range
        $existingReservation = EquipmentReservation::where('equipment_id', $equipment->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('reservation_date', [$request->reservation_date, $request->expected_return_date])
                    ->orWhereBetween('expected_return_date', [$request->reservation_date, $request->expected_return_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('reservation_date', '<=', $request->reservation_date)
                              ->where('expected_return_date', '>=', $request->expected_return_date);
                    });
            })
            ->where('status', 'approved') // Only check approved reservations
            ->exists();
    
        if ($existingReservation) {
            return redirect()->back()->withErrors(['error' => 'The selected equipment is already reserved for the chosen date range.']);
        }
    
        // Check if the equipment is available
        if ($equipment->status !== 'Available') {
            return redirect()->back()->withErrors(['error' => 'The selected equipment is not available for reservation.']);
        }
    
        // Save the reservation
        $reservation = EquipmentReservation::create([
            'reservers_id_no' => $reservers_id_no,
            'equipment_id' => $equipment->id,
            'office_id' => $office,
            'reservation_date' => $request->reservation_date,
            'expected_return_date' => $request->expected_return_date,
            'status' => 'pending',
            'purpose' => $request->purpose,
        ]);
    
        event(new ReserveEquipmentEvent($reservation, $reserver, $office, $equipment));
    
        // Redirect to the facility equipment page with a success message
        return redirect()->route('facility_equipment', ['id' => $equipment->facility_id])
            ->with('success', 'Equipment reserved successfully.');
    }
    

    public function searchEquipment(Request $request)
    {
        $query = $request->input('query');
        $page = $request->input('page', 1); // Default to page 1
        $perPage = 1; // Number of items per page

        $equipmentsQuery = Equipment::where('name', 'LIKE', "%{$query}%")
        ->orWhere('brand', 'LIKE', "%{$query}%")
        ->orWhere('serial_no', 'LIKE', "%{$query}%")
        ->with('facility');

        $totalEquipments = $equipmentsQuery->count();
        $equipments = $equipmentsQuery->skip(($page - 1) * $perPage)
                                    ->take($perPage)
                                    ->get();

        return response()->json([
            'equipments' => $equipments->map(function ($equipment) {
                return [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'brand' => $equipment->brand,
                    'status' => $equipment->status,
                    'serial_no' => $equipment->serial_no,
                    'description' => $equipment->description,
                    'facility' => $equipment->facility->name,
                    'office' => $equipment->facility->office->name,
                    'image' => asset($equipment->image),
                ];
            }),
            'prevPage' => $page > 1,
            'nextPage' => ($page * $perPage) < $totalEquipments,
        ]);
    }

    public function equipmentReservationLog()
    {
        // Get the authenticated user
        $user = Auth::user();
    
        if ($user && $user->office) {
            $reservations = EquipmentReservation::with(['student', 'faculty', 'equipment', 'offices'])
                ->whereHas('offices', function ($query) use ($user) {
                    $query->where('id', $user->office->id); 
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $reservations = collect(); 
        }
    
        return view('logs.equipment_reservations', compact('reservations'))->with('title', 'Reservation Logs');
    }

    
    
    public function reservationDetails($id){
        $reservation = EquipmentReservation::with(['student', 'faculty', 'equipment', 'offices'])->where('id', $id)->first();
        $title = "Reservation Details";
        $data = [
            'reservation' => $reservation,
            'title' => $title
        ];

        return view('reservations.reservation_details')->with($data);
    }
    
    public function accept($id)
{
    $reservation = EquipmentReservation::where('id', $id)->firstOrFail();
    $reserver = User::where('student_id', $reservation->reservers_id_no)
                ->orWhere('faculty_id', $reservation->reservers_id_no) // Assuming you have a faculty_id field
                ->first();

    $equipment = Equipment::where('id', $reservation->equipment_id)->firstOrFail();

    if ($reservation->status == 'pending') { // Only approve if pending
        $reservation->status = 'approved';
        $reservation->save();

        event(new AcceptEquipmentReservationEvent($reservation, $reserver, $equipment));
        return redirect()->back()->with('success', 'Reservation approved successfully.');
    }

    return redirect()->back()->with('error', 'Invalid status value.');
}

    public function acceptFacility($id)
    {
        // Retrieve the facility reservation by ID
        $reservation = FacilityReservation::where('id', $id)->firstOrFail();
        $facility = Facility::where('id', $reservation->facility_id)->firstOrFail();
        // Attempt to find the reserver as a student first
        $reserver = User::where('student_id', $reservation->reservers_id_no)->first();
        // $avr = User::where('office_id', 2)->first();
        // If not found as a student, try to find as a faculty member
        if (!$reserver) {
            $reserver = User::where('faculty_id', $reservation->reservers_id_no)->first();
        }
        // Check if the reserver was found
        if (!$reserver) {
            return redirect()->back()->with('error', 'Reserver not found.')->with('title', 'Facility Reservation');
        }
        // Check if the reservation status is 'pending'
        if ($reservation->status == 'pending') { 
            // Update the reservation status to 'approved'
            $reservation->status = 'approved';
            $reservation->save();
            // Redirect back with a success message and title
            event(new AcceptFacilityReservationEvent($reservation, $reserver, $facility));

            return redirect()->back()
                ->with('success', 'Reservation approved successfully.')
                ->with('title', 'Facility Reservation');
            
        }


        // Redirect back with an error message if the status is not 'pending'
        return redirect()->back()
            ->with('error', 'Invalid status value.')
            ->with('title', 'Facility Reservation');
    }


    public function declineFacility($id)
    {
        // Retrieve the facility reservation by ID
        $reservation = FacilityReservation::where('id', $id)->firstOrFail();
        $facility = Facility::where('id', $reservation->facility_id)->firstOrFail();
    
        // Attempt to find the reserver as a student first
        $reserver = User::where('student_id', $reservation->reservers_id_no)->first();
    
        // If not found as a student, try to find as a faculty member
        if (!$reserver) {
            $reserver = User::where('faculty_id', $reservation->reservers_id_no)->first();
        }
    
        // Check if the reserver was found
        if (!$reserver) {
            return redirect()->back()->with('error', 'Reserver not found.')->with('title', 'Facility Reservation');
        }
    
        // Check if the reservation status is 'pending'
        if ($reservation->status == 'pending') { 
            // Update the reservation status to 'declined'
            $reservation->status = 'declined';
            $reservation->save();
            event(new DeclineFacilityReservationEvent($reservation, $reserver, $facility));
    
            // Redirect back with a success message and title
            return redirect()->back()
                ->with('success', 'Reservation declined successfully.')
                ->with('title', 'Facility Reservation');
        }
    
        // Redirect back with an error message if the status is not 'pending'
        return redirect()->back()
            ->with('error', 'Invalid status value.')
            ->with('title', 'Facility Reservation');
    }

    public function decline($id)
    {
        $reservation = EquipmentReservation::where('id', $id)->firstOrFail();
        $reserver = User::where('student_id', $reservation->reservers_id_no)
                ->orWhere('faculty_id', $reservation->reservers_id_no) // Assuming you have a faculty_id field
                ->first();
        $equipment = Equipment::where('id', $reservation->equipment_id)->firstOrFail();

        if (in_array('declined', ['pending', 'approved', 'declined'])) { // Replace with your ENUM values
            $reservation->status = 'declined';
            $reservation->save();

            event(new DeclineEquipmentReservationEvent($reservation, $reserver, $equipment));
            return redirect()->back()->with('success', 'Reservation declined successfully.');
        }

        return redirect()->back()->with('error', 'Invalid status value.');
    }

    public function facilityReservationLog()
    {
        // Fetch all reservations with related student, facility, and office data
        $reservations = FacilityReservation::with(['student', 'facility', 'offices'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        // Return the view with the reservations data
        return view('logs.facility_reservations', [
            'reservations' => $reservations,
            'title' => 'Facility Reservation Logs'
        ]);
    }

    public function facilityReservationDetails($id)
    {
        // Fetch the facility reservation by ID with related data
        $reservation = FacilityReservation::with(['student', 'faculty', 'facility', 'offices'])
            ->where('id', $id)
            ->firstOrFail(); 

        $facilityReservations = FacilityReservation::with('facility')->where('facility_id', $id)->get();
        

        $title = "Reservation Details";
        $data = [
            'reservation' => $reservation,
            'facilityReservations' => $facilityReservations,
            'title' => $title
        ];

        return view('reservations.facility_reservation_details')->with($data);
    }
    
    public function reserveFacility() {
        $offices = Office::with('facilities') 
            ->where('type', '=', 'avr')
            ->get();
        
        $facilities = Facility::whereIn('office_id', $offices->pluck('id'))
            ->get();
    
        // Return the view with the filtered facilities
        return view('reservations.reserve_facility', compact('facilities', 'offices'))
            ->with('title', 'Reserve Facility');
    }
    

    
    public function facilityForReservation($id){
        
        $facility = Facility::findOrFail($id);      
        
        $facilityReservations = FacilityReservation::with('facility')->where('facility_id', $id)->get();

        return view('reservations.facility_to_be_reserved', compact('facility', 'facilityReservations'))->with('title', 'Reserve Facility');
    }

    public function submitReservation(Request $request)
    {
        // Validate the request
        $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'time_in' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    // Get the current time in H:i format
                    $currentTime = now()->format('H:i');
                    // Check if the time_in is later than the current time
                    if ($value > $currentTime && $request->reservation_date == today()->toDateString()) {
                        $fail('The time in must not be later than the current time.');
                    }
                },
            ],
            'time_out' => 'required|date_format:H:i|after:time_in',
            'purpose' => 'required|string|max:255',
            'expected_audience_no' => 'required|integer',
            'stage_performers' => 'required|integer',
            'facility_id' => 'required|exists:facilities,id',
        ]);
    
        $facility = Facility::findOrFail($request->facility_id);
        $office = $facility->office_id;
    
        // Determine the reservers_id_no based on user type
        if (Auth::user()->type === 'student') {
            $reservers_id_no = Auth::user()->student_id;
        } else if (Auth::user()->type === 'faculty') {
            $reservers_id_no = Auth::user()->faculty_id;
        }
    
        // Check for conflicting reservations
        $conflictingReservation = FacilityReservation::where('facility_id', $request->facility_id)
            ->where('reservation_date', $request->reservation_date)
            ->where('status', 'approved') // Only check approved reservations
            ->where(function ($query) use ($request) {
                $query->whereBetween('time_in', [$request->time_in, $request->time_out])
                      ->orWhereBetween('time_out', [$request->time_in, $request->time_out])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('time_in', '<=', $request->time_in)
                                ->where('time_out', '>=', $request->time_out);
                      });
            })
            ->first();
    
        // If there is a conflicting reservation, return an error message
        if ($conflictingReservation) {
            return back()->with('error', 'The facility is already reserved during the selected time. Please choose a different time.')->with('title', 'Facility Reservation');
        }
    
        // Create the reservation
        $reservation = FacilityReservation::create([
            'reservers_id_no' => $reservers_id_no,
            'office_id' => $office,
            'facility_id' => $request->facility_id,
            'reservation_date' => $request->reservation_date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'purpose' => $request->purpose,
            'expected_audience_no' => $request->expected_audience_no,
            'stage_performers' => $request->stage_performers,
            'status' => 'pending',
        ]);
    
        // Trigger an event for the reservation
        event(new FacilityReservationEvent($reservation, Auth::user(), $office, $facility));
    
        return back()->with('success', 'Facility reserved successfully!');
    }

    public function cancel($id)
    {
        $reservation = EquipmentReservation::findOrFail($id);

        // Update the status to "cancelled"
        $reservation->status = 'cancelled';
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation has been cancelled successfully.');
    }


}
