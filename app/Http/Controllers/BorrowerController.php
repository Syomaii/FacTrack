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
            'expected_return_date' => 'required|date|after:today',
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
        return redirect()->route('equipments/borrow_details', ['code' => $equipment->code])
                         ->with([
                             'borrowers_name' => $data['borrowers_name'],
                             'borrowers_id_no' => $data['borrowers_id_no'],
                             'expected_return_date' => $data['expected_return_date'],
                             'equipment' => $equipment,
                         ]);
    }

    // Step 2: Show the borrow details for confirmation
    public function showBorrowDetails(Request $request, $code)
    {
        // Fetch any necessary data based on the code (e.g., borrower, equipment, etc.)
        $equipment = Equipment::where('code', $code)->first();

        $borrowers_name = $request->query('borrowers_name');
        $borrowers_id_no = $request->query('borrowers_id_no');
        $expected_return_date = $request->query('expected_return_date');


        return view('equipments/borrow_details', compact('equipment', 'borrowers_name', 'borrowers_id_no', 'expected_return_date', 'code'))
            ->with('title', 'Borrow Details');

        
    }


    // Step 3: Final submission to save the borrow record
    public function submitBorrow(Request $request, $id)
{
    // Validate the incoming data
    $validatedData = $request->validate([
        'borrowers_name' => 'required|string|max:255',
        'borrowers_id_no' => 'required|string|max:255',
        'expected_returned_date' => 'required|date',  // Validate expected_returned_date field
    ]);

    // Find the equipment using the ID
    $equipment = Equipment::findOrFail($id);

    // Check if the equipment is available for borrowing
    if ($equipment->status !== 'Available') {
        return back()->withErrors(['equipment' => 'This equipment is not available for borrowing.']);
    }

    // Insert the borrow details into the 'borrows' table
    Borrower::create([
        'borrowers_name' => $validatedData['borrowers_name'],
        'borrowers_id_no' => $validatedData['borrowers_id_no'],
        'user_id' => auth()->user()->id,
        'borrowed_date' => now(),
        'expected_returned_date' => $validatedData['expected_returned_date'],  // Save expected_returned_date
        'equipment_id' => $equipment->id,
        'status' => 'Borrowed',
    ]);

    // Update the equipment status to 'Borrowed'
    $equipment->status = 'Borrowed';
    $equipment->save();

    // Redirect with a success message
    return redirect()->route('borrow_equipment')->with('borrowEquipmentSuccessfully', 'Equipment borrowed successfully!');
}

    
    
    public function returnEquipment(){


    }
}
