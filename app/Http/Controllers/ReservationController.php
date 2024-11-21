<?php

namespace App\Http\Controllers;

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
        Reservation::create([
            'student_id' =>  Auth::user()->student_id ,
            'equipment_id' => $request->equipment_id,
            'reservation_date' => $request->reservation_date,
            'expected_return_date' => $request->expected_return_date,
            'status' => 'pending',
            'purpose' => $request->purpose,
        ]);

        return redirect()->back()->with('success', 'Reservation successfully created.');
    }

    public function reservationLogs(){
        $reservations = Reservation::with(['equipment', 'student'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('logs.reservation_logs', compact('reservations'))->with('title', 'Reservation Logs');
    }
    
}
