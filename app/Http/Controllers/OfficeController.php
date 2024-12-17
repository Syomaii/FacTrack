<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Office;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function officeFacilities($id){

        $office = Office::findorfail($id);
        
        $facilities = Facility::where('office_id', $id)->paginate(5);

        return view('/offices/facilities_in_offices', compact('office', 'facilities'))->with('title', 'Facilities in Offices');

    }

    public function addOffice(Request $request) {
        $data = $request->validate([
            'name' => 'required|unique:offices,name',
            'description' => 'nullable',
            'type' => 'required|in:office,department', 
        ]);
    
        $officeData = [
            'name' => ucwords($data['name']),
            'description' => $data['description'],
            'type' => $data['type'], 
        ];
    
        // Create the office
        Office::create($officeData);
    
        return redirect('/offices')->with('addOfficeSuccessfully', 'Office added successfully.');
    }
    
    public function updateOffice(Request $request)
    {
        $office = Office::find($request->id);

        if (!$office) {
            return redirect()->back()->with('updateOfficeError', 'Office not found!');
        }

        if ($office->name === $request->name) {
            $data = $request->validate([
                'name' => 'required',
                'description' => 'nullable|string',
                'type' => 'nullable|string',
            ]);
        } else {
            $data = $request->validate([
                'name' => 'required|unique:offices,name,' . $request->id,
                'description' => 'nullable|string',
                'type' => 'nullable|string',
            ]);
        }

        if ($office->name !== $data['name']) {
            Students::where('department', $office->name)->update(['department' => $data['name']]);
        }

        // Update office
        $office->update($data);

        return redirect()->back()->with('updateOfficeSuccess', 'Office updated successfully!');
    }

    public function deleteOffice($id)
    {
        // Attempt to find the office by ID and delete it
        $office = Office::findOrFail($id);
        
        // Delete the office
        $office->delete();
    
        return redirect('/offices')->with('deleteOfficeSuccess', 'Office deleted successfully.');
    }
    
    
}
