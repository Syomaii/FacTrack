<?php

namespace App\Http\Controllers;

use App\Events\ReserveEquipmentEvent;
use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function reserveEquipment(Request $request)
    {
        $equipments = Equipment::all();
        $selectedEquipment = null;

        if ($request->filled('equipment_id')) {
            // Fetch selected equipment with facility relationship
            $selectedEquipment = Equipment::with('facility')->find($request->equipment_id);
        }

        return view('students.reserve_equipment', [
            'equipments' => $equipments,
            'selectedEquipment' => $selectedEquipment,
            'title' => 'Reserve Equipment',
        ]);
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

        // Fetch the equipment using the validated equipment_id
        $equipment = Equipment::find($request->equipment_id);

        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'Equipment not found.']);
        }

        $office = $equipment->facility->office->id; 
        $student = Auth::user();
        $studentId = Auth::user()->student_id;
        // Check if the equipment is already reserved in the given time range
        $existingReservation = Reservation::where('equipment_id', $request->equipment_id)
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
        $reservation = Reservation::create([
            'student_id' =>  $studentId,
            'equipment_id' => $request->equipment_id,
            'office_id' => $office,
            'reservation_date' => $request->reservation_date,
            'expected_return_date' => $request->expected_return_date,
            'status' => 'pending',
            'purpose' => $request->purpose,
        ]);
        event(new ReserveEquipmentEvent($reservation, $student, $office, $equipment));

        return redirect()->back()->with('success', 'Reservation successfully created.');
    }

    public function reservationLogs(){
        $reservations = Reservation::with(['student', 'equipment', 'offices'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('logs.reservation_logs', compact('reservations'))->with('title', 'Reservation Logs');
    }
    
    public function reservationDetails($id){
        $reservation = Reservation::with(['student', 'equipment', 'offices'])->where('id', $id)->first();
        $title = "Reservation Details";
        $data = [
            'reservation' => $reservation,
            'title' => $title
        ];

        return view('students.reservation_details')->with($data);
    }

    public function accept($id)
    {
        $reservation = Reservation::findOrFail($id);

        if (in_array('approved', ['pending', 'approved', 'declined'])) { // Replace with your ENUM values
            $reservation->status = 'approved';
            $reservation->save();

            return redirect()->back()->with('success', 'Reservation approved successfully.');
        }

        return redirect()->back()->with('error', 'Invalid status value.');
    }

    public function decline($id)
    {
        $reservation = Reservation::findOrFail($id);

        if (in_array('declined', ['pending', 'approved', 'declined'])) { // Replace with your ENUM values
            $reservation->status = 'declined';
            $reservation->save();

            return redirect()->back()->with('success', 'Reservation declined successfully.');
        }

        return redirect()->back()->with('error', 'Invalid status value.');
    }

}
