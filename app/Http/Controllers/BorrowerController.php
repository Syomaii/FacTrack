<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Equipment;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    public function borrowEquipment(){
        return view('equipments/borrow_equipments')->with('title', 'Borrow Equipment');
    }
    public function borrowerFormPost(Request $request)
    {
        $data = $request->validate([
            'borrowers_name' => 'required',
            'borrowers_id_no' => 'required',
            'borrowed_date' => 'required|date',
            'expected_returned_date' => 'required|date|after:borrowed_date',
        ]);
    
        // Get current time
        $borrowedDate = now(); 
    
        // Convert input dates
        $inputBorrowedDate = \DateTime::createFromFormat('Y-m-d\TH:i', $data['borrowed_date'], new \DateTimeZone('UTC'))
            ?: \DateTime::createFromFormat('m/d/Y H:i A', $data['borrowed_date'], new \DateTimeZone('UTC'))
            ?: new \DateTime($data['borrowed_date'], new \DateTimeZone('UTC'));
        $returnedDate = \DateTime::createFromFormat('Y-m-d\TH:i', $data['expected_returned_date'], new \DateTimeZone('UTC'))
            ?: \DateTime::createFromFormat('m/d/Y H:i A', $data['expected_returned_date'], new \DateTimeZone('UTC'))
            ?: new \DateTime($data['expected_returned_date'], new \DateTimeZone('UTC'));
    
        if ($inputBorrowedDate->format('Y-m-d') !== $borrowedDate->format('Y-m-d')) {
            return back()->withErrors(['borrowed_date' => 'The borrowing date must be today\'s date.'])->withInput();
        }
    
        if ($returnedDate <= $inputBorrowedDate) {
            return back()->withErrors(['returned_date' => 'The return date must be after the borrowed date.'])->withInput();
        }
    
        $equipment = Equipment::findOrFail($request->id);
        $equipment->status = 'Borrowed';
        $equipment->save();
    
        Borrower::create([
            'borrowers_name' => $data['borrowers_name'],
            'borrowers_id_no' => $data['borrowers_id_no'],
            'user_id' => auth()->user()->id,
            'borrowed_date' => $inputBorrowedDate->format('Y-m-d H:i:s'),
            'expected_returned_date' => $returnedDate->format('Y-m-d H:i:s'),
            'equipment_id' => $equipment->id,
            'status' => $equipment->status,
        ]);
    
        return redirect()->route('equipments/equipments')->with('borrowedSuccessfully', 'Equipment borrowed successfully');
    }

    public function showDetails($code)
    {
        $borrower = Borrower::where('borrower_code', $code)->first();
        if (!$borrower) {
            return redirect()->back()->with('error', 'Invalid QR code');
        }

        // Retrieve borrower and item details and display them on the next page
        return view('borrow.details', compact('borrower'));
    }
}
