<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function addFacility(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $facilityData = ([
            'name' => $data['name'],
            'description' => $data['description'],
            'office_id' => auth()->user()->office_id,
        ]);

        Facility::create($facilityData);

        return redirect('facilities/facilities')->with('addFacilitySuccessfully', 'Facility added successfully.');
    }
    


    public function updateFacility(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $facility = Facility::find($request->id);
        if ($facility) {
            $facility->update($data);
            return redirect()->back()->with('updateFacilitySuccess', 'Facility updated successfully!');
        }

        return redirect()->back()->with('updateFacilityError', 'Facility not found!');
    }
    public function deleteFacility($id)
    {
        Facility::findOrFail($id)->delete();
        return redirect('facilities/facilities')->with('deleteFacilitySuccess', 'Facility Deleted Successfully!');
    }

    
}
