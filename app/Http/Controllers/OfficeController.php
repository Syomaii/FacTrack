<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function officeFacilities($id){

        $office = Office::findorfail($id);
        $facilities = Facility::where('office_id', $id)->paginate(5);

        return view('/offices/facilities_in_offices', compact('office', 'facilities'))->with('title', 'Facility Equipments');

    }

    public function addOffice(Request $request){
        $data = $request->validate([
            'name' => 'required|unique:offices,name',
            'description' => 'nullable',
        ]);

        $officeData = ([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        Office::create($officeData);

        return redirect('/offices')->with('addOfficeSuccessfully', 'Office added successfully.');
    }
    


    public function updateOffice(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:offices,name',
            'description' => 'nullable',
        ]);

        $office = Office::find($request->id);
        if ($office) {
            $office->update($data);
            return redirect()->back()->with('updateOfficeSuccess', 'Office updated successfully!');
        }

        return redirect()->back()->with('updateOfficeError', 'Office not found!');
    }

    public function deleteOffice($id)
    {
        Office::findOrFail($id)->delete();
        return redirect('/offices')->with('deleteOfficeSuccess', 'Office Deleted Successfully!');
    }
}
