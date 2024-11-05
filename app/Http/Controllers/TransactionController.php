<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Equipment;
use App\Models\Students;
use App\Models\Maintenance;
use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    // ----------------------------- BORROW TRANSACTION --------------------------------------

    public function borrowEquipment()
    {
        return view('transaction/borrow_equipments')->with('title', 'Borrow Equipment');
    }

    public function searchStudents(Request $request)
    {
        $search = $request->get('id');
     
        $result = Students::where('id_no', 'LIKE', '%' . $search . '%')->pluck('id_no');
          
        return response()->json($result);
    }

    public function getStudentDetails($id)
    {
        // Log the ID without any curly braces
        $id = trim($id, '{}'); // Remove curly braces if they exist
        \Log::info("Fetching details for cleaned ID: " . $id);
        
        $student = Students::where('id_no', $id)->first(['firstname', 'lastname', 'department']);
        
        if ($student) {
            return response()->json($student);
        }
        
        return response()->json(['error' => 'Student not found'], 404);
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
            'remarks' => 'The day the equipment is Borrowed',
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
    
        // Fallback values if not provided in the request
        $maintenanceDate = $request->input('maintenance_date') ?: now()->format('Y-m-d');
        $issueNote = $request->input('issue_note') ?: 'No issue provided';
    
        return view('equipments.maintenance_equipment_details', [
            'equipment' => $equipment,
            'maintenance_id_no' => $equipment->id, 
            'issue_note' => $issueNote,
            'maintenance_date' => $maintenanceDate,
        ])->with('title', 'Maintenance Details');
    }

    public function submitMaintenance(Request $request, $code)
    {
        $validatedData = $request->validate([
            'issue_note' => 'required|string|max:255',
            'maintenance_date' => 'required|date',
        ]);
    
        // Find the equipment by code
        $equipment = Equipment::findOrFail($code);
    
        // Check if the equipment is available for maintenance
        if ($equipment->status !== 'Available') {
            return back()->withErrors(['equipment' => 'This equipment is not available for maintenance.']);
        }
    
        // Create the maintenance record
        Maintenance::create([
            'equipment_id' => $equipment->id, // Use the ID of the equipment
            'remarks' => 'The day the equipment is Maintained', // Make sure this is the intended field
            'issue' => $validatedData['issue_note'],
            'maintained_date' => $validatedData['maintenance_date'], // Use the date from the input
            'user_id' => auth()->user()->id,
            'status' => 'In Maintenance',
        ]);
    
        // Update equipment status
        $equipment->status = 'In Maintenance';
        $equipment->save();
    
        return redirect()->route('maintenance_equipment') // Redirect to the equipments index page
                         ->with('maintenanceSuccessfully', 'Maintenance record submitted successfully.');
    }

    // ----------------------------- REPAIR TRANSACTION ---------------------------------------

    public function repairDetails(Request $request, $code)
    {
        // Fetch equipment details based on scanned code
        $equipment = Equipment::where('code', $code)->first();
    
        // Check if equipment exists
        if (!$equipment) {
            return redirect()->back()->withErrors(['error' => 'Equipment not found.']);
        }
    
        // Fallback values if not provided in the request
        $maintenanceDate = $request->input('repair_date') ?: now()->format('Y-m-d');
        $issueNote = $request->input('issue_note') ?: 'No issue provided';
    
        return view('equipments.repair_equipment_details', [
            'equipment' => $equipment,
            'repair_id_no' => $equipment->id, 
            'issue_note' => $issueNote,
            'repair_date' => $maintenanceDate,
        ])->with('title', 'Repair Details');
    }
    
    public function submitRepair(Request $request, $code)
    {
        $validatedData = $request->validate([
            'issue_note' => 'required|string|max:255',
            'repair_date' => 'required|date',
        ]);
    
        // Find the equipment by code
        $equipment = Equipment::findOrFail($code);
    
        // Check if the equipment is available for maintenance
        if ($equipment->status !== 'Available') {
            return back()->withErrors(['equipment' => 'This equipment is not available for repair.']);
        }
    
        // Create the maintenance record
        Repair::create([
            'equipment_id' => $equipment->id, // Use the ID of the equipment
            'remarks' => 'The day the equipment is Repaired', // Make sure this is the intended field
            'issue' => $validatedData['issue_note'],
            'repaired_date' => $validatedData['repair_date'], // Use the date from the input
            'user_id' => auth()->user()->id,
            'status' => 'In Repair',
        ]);
    
        // Update equipment status
        $equipment->status = 'In Repair';
        $equipment->save();
    
        return redirect()->route('repair_equipment') // Redirect to the equipments index page
                         ->with('repairSuccessfully', 'Repair record submitted successfully.');
    }

    public function returnEquipment($code, Request $request)
    {
        
        $equipment = Equipment::where('code', $code)->first();
        
        // Check if the equipment exists
        if (!$equipment) {
            return redirect()->back()->with('error', 'Equipment not found.');
        }

        // Retrieve the status from the request
        $status = $equipment->status;

        // Handle the equipment return based on its status
        switch ($status) {
            case 'Borrowed':
                // Handle returning borrowed equipment
                $returnedDate = $request->input('returned_date');
                $equipment->status = 'Available';

                // Optionally log the borrowing return
                // BorrowLog::create([
                //     'equipment_id' => $equipment->id,
                //     'returned_date' => $returnedDate,
                // ]);
                return redirect()->back()->with('success', 'Equipment returned successfully.');
            break;

            case "In Maintenance":
                $validatedData = $request->validate([
                    'returned_date' => 'required|date',
                    'issue_note' => 'required_if:status,In Maintenance|string',
                    'action_taken' => 'required_if:status,In Maintenance|string',
                    'remarks' => 'nullable|string',
                    'recommendations' => 'nullable|string',
                ]);
            
                // Retrieve the equipment using the scanned code
                $equipment = Equipment::where('code', $code)->first();
            
                if (!$equipment) {
                    return redirect()->back()->withErrors(['msg' => 'Equipment not found.']);
                }
            
                // Retrieve the existing maintenance record
                $maintenance = Maintenance::where('equipment_id', $equipment->id)->first();
            
                if (!$maintenance) {
                    return redirect()->back()->withErrors(['msg' => 'Maintenance record not found.']);
                }
            
                // Update the maintenance record
                $maintenance->update([
                    'returned_date' => $validatedData['returned_date'],
                    'status' => 'okay',
                    'issue_note' => $validatedData['issue_note'],
                    'action_taken' => $validatedData['action_taken'],
                    'remarks' => $validatedData['remarks'],
                    'recommendations' => $validatedData['recommendations'],
                ]);

                
            
                // Update the equipment status
                $equipment->status = 'Available';
                $equipment->save();
            
                return redirect()->back()->with('success', 'Equipment returned successfully.');
            break;

            case 'In Repair':
                // Handle repair return
                $repairIssueNote = $request->input('repair_issue_note'); // Ensure this matches your form field name
                $returnedDate = $request->input('returned_date'); // Use the returned date
                $actionTaken = $request->input('action_taken');
                $remarks = $request->input('remarks');
                $recommendations = $request->input('recommendations');

                // Process the repair return (e.g., logging the repair)
                Repair::create([
                    'equipment_id' => $equipment->id,
                    'repair_issue_note' => $repairIssueNote,
                    'repair_date' => $returnedDate,
                    'action_taken' => $actionTaken,
                    'remarks' => $remarks,
                    'recommendations' => $recommendations,
                ]);
                $equipment->status = 'Available'; // Update status
                $equipment->save();
                return redirect()->back()->with('success', 'Equipment returned successfully.');
            break;

            default:
                return redirect()->back()->with('error', 'Invalid status provided.');
                
            
        }

        // Save the equipment status change
        

        // Redirect back with a success message
        
    }

    

}
