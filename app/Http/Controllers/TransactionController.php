<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Equipment;
use App\Models\Students;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // ----------------------------- BORROW TRANSACTION --------------------------------------

    public function borrowEquipment()
    {
        return view('transaction/borrow_equipments')->with('title', 'Borrow Equipment');
    }

    public function searchStudents(Request $request)
    {
        $search = $request->input('search');
        $students = Students::where('id_no', 'like', "%{$search}%")
                            ->orWhere('firstname', 'like', "%{$search}%")
                            ->get(['id_no', 'firstname', 'lastname', 'department']); // Select specific columns

        return response()->json($students);
    }

    public function borrowerFormPost(Request $request)
    {
        $data = $request->validate([
            'borrowers_id_no' => 'required|string|max:255',
            'borrowers_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
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

        $data = [
            'equipment' => $equipment,
            'borrowers_id_no' => $borrowers_id_no = $request->query('borrowers_id_no'),
            'borrowers_name' => $borrowers_name = $request->query('borrowers_name'),
            'department' => $department = $request->query('department'),
            'purpose' => $purpose = $request->query('purpose'),
            'expected_return_date' => $expected_return_date = $request->query('expected_return_date'),
            'title' => 'Borrow Details',
        ];


        return view('equipments/borrow_details', $data);
    }

    public function submitBorrow(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'borrowers_id_no' => 'required|string|max:255',
            'borrowers_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'expected_returned_date' => 'required|date',  // Validate expected_returned_date field
        ]);

        $equipment = Equipment::findOrFail($id);

        // Find the equipment using the ID
        $equipment = Equipment::findOrFail($id);

        // Check if the equipment is available for borrowing
        if ($equipment->status !== 'Available') {
            return back()->withErrors(['equipment' => 'This equipment is not available for borrowing.']);
        }

        // Insert the borrow details into the 'borrows' table
        Borrower::create([
            'borrowers_id_no' => $validatedData['borrowers_id_no'],
            'borrowers_name' => $validatedData['borrowers_name'],
            'department' => $validatedData['department'],
            'purpose' => $validatedData['purpose'],
            'user_id' => auth()->user()->id,
            'borrowed_date' => now(),
            'remarks' => 'Borrowed',
            'expected_returned_date' => $validatedData['expected_returned_date'],   // Save expected_returned_date
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
    

    
    // ---------------------------------------------------------------------------------------------

    // ----------------------------- MAINTENANCE TRANSACTION ---------------------------------------

    public function maintenanceDetails(Request $request, $code)
    {
        // Fetch equipment details based on scanned code
        $equipment = Equipment::where('code', $code)->first();

        // Check if equipment exists
        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'Equipment not found.']);
        }

        return view('maintenance_equipment_details', [
            'equipment' => $equipment,
            'maintenance_id_no' => $request->maintenance_id_no, 
            'maintenance_description' => $request->maintenance_description,
            'maintenance_date' => $request->maintenance_date,
        ]);
    }

}
