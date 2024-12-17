<?php

namespace App\Http\Controllers;

use App\Events\ReserveEquipmentEvent;
use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentReservation;
use App\Models\Facility;
use App\Models\Office;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function showReservationForm($code)
    {
        $equipment = Equipment::where('code', $code)->firstOrFail();

        return view('students.reserve_equipment', compact('equipment'))->with('title', 'Reserve Equipment');
    }

    public function storeReservation(Request $request, $code) {
        
        // Convert input dates to the application's timezone
        $reservationDate = Carbon::parse($request->input('reservation_date'))->setTimezone(config('app.timezone'));
        $expectedReturnDate = Carbon::parse($request->input('expected_return_date'))->setTimezone(config('app.timezone'));

        // Validate the request
        $request->validate([
            'purpose' => 'required|string|max:255',
            'reservation_date' => 'required|date|after_or_equal:now',
            'expected_return_date' => 'required|date|after:reservation_date',
        ]);

        // Find the equipment by its code
        $equipment = Equipment::where('code', $code)->firstOrFail();

        // Check if the equipment is available for reservation
        if ($equipment->status !== 'Available') {
            return back()->with('error', 'This equipment is not available for reservation.');
        }

        // Save the reservation
        Reservation::create([
            'equipment_id' => $equipment->id,
            'purpose' => $request->input('purpose'),
            'reservation_date' => $reservationDate,
            'expected_return_date' => $expectedReturnDate,
            'reserved_by' => auth()->id(), // Assuming you are tracking who reserves the equipment
        ]);

        // Update equipment status to 'Reserved'
        $equipment->update(['status' => 'Reserved']);

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

    public function reserved(Request $request)
    {
        // Validate the request
        $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'reservation_date' => 'required|date|after:now',
            'expected_return_date' => 'required|date|after:reservation_date',
            'purpose' => 'required|string|max:255',
        ]);

        $equipment = Equipment::find($request->equipment_id);
        
        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'Equipment not found.']);
        }

        $office = $equipment->facility->office->id; 
        $reserver = Auth::user();
        if($reserver->type === 'student'){
            $reservers_id_no = Auth::user()->student_id;
        }else if($reserver->type === 'faculty'){
            $reservers_id_no = Auth::user()->faculty_id;
        }
        // Check if the equipment is already reserved in the given time range
        $existingReservation = EquipmentReservation::where('equipment_id', $request->equipment_id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('reservation_date', [$request->reservation_date, $request->expected_return_date])
                ->orWhereBetween('expected_return_date', [$request->reservation_date, $request->expected_return_date]);
        })
        ->where('status', 'completed') 
        ->exists();

        if ($existingReservation) {
            return redirect()->back()->withErrors(['error' => 'The selected equipment is already reserved for the chosen date range.']);
        }

        // Check if the equipment is available
        if ($equipment->status !== 'Available') {
            return redirect()->back()->withErrors(['error' => 'The selected equipment is not available for reservation.']);
        }

        // Create a new reservation
        $reservation = EquipmentReservation::create([
            'reservers_id_no' =>  $reservers_id_no,
            'equipment_id' => $request->equipment_id,
            'office_id' => $office,
            'reservation_date' => $request->reservation_date,
            'expected_return_date' => $request->expected_return_date,
            'status' => 'pending',
            'purpose' => $request->purpose,
        ]);
        event(new ReserveEquipmentEvent($reservation, $reserver, $office, $equipment));

        return redirect()->back()->with('success', 'Reservation successfully created.');
    }

    public function equipmentReservationLog()
    {
        // Get the authenticated user
        $user = Auth::user();
    
        if ($user && $user->office) {
            $reservations = EquipmentReservation::with(['student', 'equipment', 'offices'])
                ->whereHas('offices', function ($query) use ($user) {
                    $query->where('id', $user->office->id); 
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $reservations = collect(); 
        }
    
        return view('logs.reservation_logs', compact('reservations'))->with('title', 'Reservation Logs');
    }
    
    public function reservationDetails($id){
        $reservation = EquipmentReservation::with(['student', 'faculty', 'equipment', 'offices'])->where('id', $id)->first();
        $title = "Reservation Details";
        $data = [
            'reservation' => $reservation,
            'title' => $title
        ];

        return view('students.reservation_details')->with($data);
    }

    
    public function accept($id)
    {
        $reservation = EquipmentReservation::findOrFail($id);

        if (in_array('approved', ['pending', 'approved', 'declined'])) { // Replace with your ENUM values
            $reservation->status = 'approved';
            $reservation->save();

            return redirect()->back()->with('success', 'Reservation approved successfully.');
        }

        return redirect()->back()->with('error', 'Invalid status value.');
    }

    public function decline($id)
    {
        $reservation = EquipmentReservation::findOrFail($id);

        if (in_array('declined', ['pending', 'approved', 'declined'])) { // Replace with your ENUM values
            $reservation->status = 'declined';
            $reservation->save();

            return redirect()->back()->with('success', 'Reservation declined successfully.');
        }

        return redirect()->back()->with('error', 'Invalid status value.');
    }

    
    public function reserveFacility(){
        $office = Office::with('facilities')->get();
        $facilities = Facility::whereHas('office')->where('allow_reservation', '=', '1')->get();
        return view('students.reserve_facility', compact('facilities', 'office'))
            ->with('title','Reserve Facility');
    }

    
    public function facilityForReservation($id){
        $facility = Facility::where('id', $id)->first();
        

        return view('students.facility_to_be_reserved', compact('facility'))->with('title', 'Reserve Facility');
    }
}
