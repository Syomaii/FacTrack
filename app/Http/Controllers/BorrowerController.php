<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Equipment;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    public function borrowEquipment()
    {
        return view('equipments/borrow_equipments')->with('title', 'Borrow Equipment');
    }

    // Step 1: Handle form submission and redirect to review page
    public function borrowerFormPost(Request $request)
    {
        $data = $request->validate([
            'borrowers_name' => 'required',
            'borrowers_id_no' => 'required',
            'expected_returned_date' => 'required|date|after:today',
            'equipment_code' => 'required', // Equipment code from QR
        ]);

        $equipment = Equipment::where('code', $data['equipment_code'])->first();

        // Equipment validation
        if (!$equipment) {
            return back()->withErrors(['equipment_code' => 'Invalid equipment code.'])->withInput();
        }

        if ($equipment->status !== 'Available') {
            return back()->withErrors(['equipment_code' => 'Equipment is already borrowed.'])->withInput();
        }

        // Pass the data to the "borrow details" page for confirmation
        return redirect()->route('borrow.details', ['equipment_id' => $equipment->id])
                         ->with([
                             'borrowers_name' => $data['borrowers_name'],
                             'borrowers_id_no' => $data['borrowers_id_no'],
                             'expected_returned_date' => $data['expected_returned_date'],
                             'equipment' => $equipment,
                         ]);
    }

    // Step 2: Show the borrow details for confirmation
    public function showBorrowDetails($code, Request $request)
    {
        $equipment = Equipment::findOrFail($code);

        // Retrieve the data passed from the previous step
        $borrowers_name = session('borrowers_name');
        $borrowers_id_no = session('borrowers_id_no');
        $expected_returned_date = session('expected_returned_date');

        return view('equipments.borrow_details', compact('equipment', 'borrowers_name', 'borrowers_id_no', 'expected_returned_date'));
    }

    // Step 3: Final submission to save the borrow record
    public function submitBorrow(Request $request)
    {
        $data = $request->validate([
            'borrowers_name' => 'required',
            'borrowers_id_no' => 'required',
            'expected_returned_date' => 'required|date|after:today',
            'equipment_id' => 'required',
        ]);

        $equipment = Equipment::find($data['equipment_id']);

        if ($equipment->status !== 'Available') {
            return back()->withErrors(['equipment_code' => 'Equipment is already borrowed.'])->withInput();
        }

        // Create the borrower record
        Borrower::create([
            'borrowers_name' => $data['borrowers_name'],
            'borrowers_id_no' => $data['borrowers_id_no'],
            'user_id' => auth()->user()->id,
            'borrowed_date' => now(),
            'expected_returned_date' => $data['expected_returned_date'],
            'equipment_id' => $equipment->id,
            'status' => 'Borrowed',
        ]);

        // Update equipment status
        $equipment->status = 'Borrowed';
        $equipment->save();

        return redirect()->route('equipments.equipments')->with('success', 'Equipment borrowed successfully.');
    }
}
