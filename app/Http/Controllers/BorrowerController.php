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


    public function submitBorrow(Request $request, $id)
    {
        $validatedData = $request->validate([
            'borrowers_name' => 'required|string|max:255',
            'borrowers_id_no' => 'required|string|max:255',
            'expected_returned_date' => 'required|date',  // Validate expected_returned_date field
        ]);

        $equipment = Equipment::findOrFail($id);

        if ($equipment->status !== 'Available') {
            return back()->withErrors(['equipment' => 'This equipment is not available for borrowing.']);
        }

        Borrower::create([
            'borrowers_name' => $validatedData['borrowers_name'],
            'borrowers_id_no' => $validatedData['borrowers_id_no'],
            'user_id' => auth()->user()->id,
            'borrowed_date' => now(),
            'expected_returned_date' => $validatedData['expected_returned_date'],  
            'equipment_id' => $equipment->id,
            'status' => 'Borrowed',
        ]);

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


    
    
    public function returnEquipment(){


    }
}
