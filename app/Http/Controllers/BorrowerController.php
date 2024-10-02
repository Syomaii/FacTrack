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

    public function borrowerFormPost(Request $request)
    {
        $data = $request->validate([
            'borrowers_name' => 'required',
            'borrowers_id_no' => 'required',
            'expected_return_date' => 'required|date|after:today',
            'equipment_code' => 'required', 
        ]);

        $equipment = Equipment::where('code', $data['equipment_code'])->first();

        if (!$equipment) {
            return back()->withErrors(['equipment_code' => 'Invalid equipment code.'])->withInput();
        }

        if ($equipment->status !== 'Available') {
            return back()->withErrors(['equipment_code' => 'Equipment is already borrowed.'])->withInput();
        }

        return redirect()->route('equipments/borrow_details', ['code' => $equipment->code])
                         ->with([
                             'borrowers_name' => $data['borrowers_name'],
                             'borrowers_id_no' => $data['borrowers_id_no'],
                             'expected_return_date' => $data['expected_return_date'],
                             'equipment' => $equipment,
                         ]);
    }

    public function showBorrowDetails(Request $request, $code)
    {
        $equipment = Equipment::where('code', $code)->first();

        $borrowers_name = $request->query('borrowers_name');
        $borrowers_id_no = $request->query('borrowers_id_no');
        $expected_return_date = $request->query('expected_return_date');


        return view('equipments/borrow_details', compact('equipment', 'borrowers_name', 'borrowers_id_no', 'expected_return_date', 'code'))
            ->with('title', 'Borrow Details');

        
    }

<<<<<<< HEAD

    public function submitBorrow(Request $request, $id)
    {
=======
    public function submitBorrow(Request $request, $id)
    {
        // Validate the incoming data
>>>>>>> 668536f218def52b373ebd4c7264c4cca379b78e
        $validatedData = $request->validate([
            'borrowers_name' => 'required|string|max:255',
            'borrowers_id_no' => 'required|string|max:255',
            'expected_returned_date' => 'required|date',  // Validate expected_returned_date field
        ]);

<<<<<<< HEAD
        $equipment = Equipment::findOrFail($id);

=======
        // Find the equipment using the ID
        $equipment = Equipment::findOrFail($id);

        // Check if the equipment is available for borrowing
>>>>>>> 668536f218def52b373ebd4c7264c4cca379b78e
        if ($equipment->status !== 'Available') {
            return back()->withErrors(['equipment' => 'This equipment is not available for borrowing.']);
        }

<<<<<<< HEAD
=======
        // Insert the borrow details into the 'borrows' table
>>>>>>> 668536f218def52b373ebd4c7264c4cca379b78e
        Borrower::create([
            'borrowers_name' => $validatedData['borrowers_name'],
            'borrowers_id_no' => $validatedData['borrowers_id_no'],
            'user_id' => auth()->user()->id,
            'borrowed_date' => now(),
<<<<<<< HEAD
            'expected_returned_date' => $validatedData['expected_returned_date'],  
=======
            'expected_returned_date' => $validatedData['expected_returned_date'],  // Save expected_returned_date
>>>>>>> 668536f218def52b373ebd4c7264c4cca379b78e
            'equipment_id' => $equipment->id,
            'status' => 'Borrowed',
        ]);

<<<<<<< HEAD
        $equipment->status = 'Borrowed';
        $equipment->save();

        return redirect()->route('borrow_equipment')->with('borrowEquipmentSuccessfully', 'Equipment borrowed successfully!');
    }


    public function validateEquipmentStatus(Request $request)
    {
        $equipment = Equipment::where('code', $request->code)->first();

        if ($equipment && $equipment->status === 'Available') {
            return response()->json(['available' => true]);
        } else {
            return response()->json(['available' => false]);
        }
    }

=======
        // Update the equipment status to 'Borrowed'
        $equipment->status = 'Borrowed';
        $equipment->save();

        // Redirect with a success message
        return redirect()->route('borrow_equipment')->with('borrowEquipmentSuccessfully', 'Equipment borrowed successfully!');
    }

    public function returnEquipment(Request $request)
    {
        // Retrieve the equipment code from the query parameters
        $code = $request->query('code');

        // Fetch the equipment by its code
        $equipment = Equipment::where('code', $code)->first();

        if (!$equipment) {
            return back()->withErrors(['message' => 'Equipment not found.']);
        }
>>>>>>> 668536f218def52b373ebd4c7264c4cca379b78e

        if ($equipment->status === "Borrowed") {
            $equipment->status = "Available";
            $equipment->save(); // Don't forget to save changes

            return redirect()->route('equipments.equipments')
                            ->with('returnEquipmentSuccessful', 'Equipment returned successfully!');
        }

        if ($equipment->status === "Available") {
            $data = [
                'equipments' => $equipment,
                'timeline' => $equipment->timeline,
                'title' => 'Equipment Details'
            ];

            return redirect()->route('', $data)->with('title', 'Equipment Details');
        }

        return back()->withErrors(['message' => 'Invalid equipment status.']);
    }

}
