<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Reservation;
use Illuminate\Http\Request;

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

    dd($request->all());
    $request->validate([
        'equipment_id' => 'required|exists:equipments,id', // Ensure equipment_id is correctly validated
        'reservation_date' => 'required|date|after:now',
        'purpose' => 'required|string|max:255',
    ]);

    // Fetch the equipment using the validated equipment_id
    $equipment = Equipment::find($request->equipment_id);

    if (!$equipment) {
        return redirect()->back()->with('error', 'Equipment not found.');
    }

    if ($equipment->status !== 'Available') {
        return redirect()->back()->with('error', 'The selected equipment is not available for reservation.');
    }

    // Create a reservation
    Reservation::create([
        'user_id' => auth()->id(),
        'equipment_id' => $request->equipment_id, // Correctly assign the equipment_id here
        'reservation_date' => $request->reservation_date,
        'status' => 'Pending',
        'purpose' => $request->purpose,
    ]);

    // Update the equipment status to "Reserved"
    $equipment->update(['status' => 'Reserved']);

    return redirect()->back()->with('success', 'Reservation successfully created.');
}


    
}
