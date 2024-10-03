<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Facility;
use App\Models\Timeline;
use App\Models\Office;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function addEquipmentPost(Request $request){
    
        // Validate the request data
        $data = $request->validate([
            'brand' => 'required',
            'name' => 'required',
            'serial_no' => 'required|unique:equipments,serial_no',
            'serial_no' => 'required|unique:equipments,serial_no',  // Corrected serial_no validation rule
            'description' => 'required',
            'acquired_date' => 'required|date|before_or_equal:now',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:Available,In Maintenance,In Repair,Borrowed',
            'owned_by' => 'required',
        ]);
    
        // Get the facility ID and verify its existence
        $facilityId = $request->input('facility');
        $facility = Facility::where('id', $facilityId)->firstOrFail();
        
        // Get the associated office ID from the facility
        $officeId = $facility->office_id;
    
        // Add facility_id and user_id to the data array
        $data['facility_id'] = $facility->id;
        $data['user_id'] = auth()->user()->id;
    
        // Generate a unique equipment code
        $code = date('y') . $officeId . date('m') . date('d') . $facilityId . date('H') . $data['user_id'] . date('is');
        $data['code'] = $code;
    
        // Handle the image file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->move(public_path('images/equipments'), $image->getClientOriginalName());
            $data['image'] = 'images/equipments/' . $image->getClientOriginalName();
        } 
    
        // Create the new equipment
        $equipment = Equipment::create($data);
        
    
        // Create a timeline entry for the new equipment
        Timeline::create([
            'equipment_id' => $equipment->id,
            'status' => $equipment->status,
            'remarks' => 'The day the equipment is added in the system',
            'user_id' => auth()->user()->id
        ]);
    
        // Redirect to the facility's equipment page with a success message
        return redirect()->route('facility_equipment', ['id' => $facility->id])
                     ->with('title', 'Facility Equipment')
                     ->with('addEquipmentSuccessfully', 'Equipment Added Successfully!');
    }
    
    
    public function updateEquipment(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'serial_no' => 'required|unique:equipments,serial_no,' . $request->id, 
            'description' => 'required',
            'acquired_date' => 'required|date|before_or_equal:now',
            'facility' => 'required|string', 
            'status' => 'required|in:Available,In Maintenance,In Repair,Borrowed',
        ]);

        $facility = Facility::where('name', $data['facility'])->first();

        if (!$facility) {
            return back()->withErrors(['facility' => 'Facility not found.']);
        }

        $updateData = [
            'name' => $data['name'],
            'brand' => $data['brand'],
            'serial_no' => $data['serial_no'],
            'description' => $data['description'],
            'acquired_date' => $data['acquired_date'],
            'facility_id' => $facility->id, 
            'status' => $data['status'],
        ];

        $equipment = Equipment::where('id', $request['id'])->first();
        $equipment->update($updateData);

        Timeline::create([
            'equipment_id' => $equipment->id,
            'status' => $equipment->status,
            'remarks' => 'The day the equipment is updated in the system',
            'user_id' => auth()->id()
        ]);

        return redirect()->route('equipments')->with('updateEquipmentSuccessfully', 'Equipment updated successfully');
    }
  

    public function deleteEquipment($id){

        Equipment::where('id', $id)->delete();
        return redirect('equipments/equipments')->with('deleteEquipmentSuccessfully', 'Equipment deleted successfully');
    }

    
}



//disposed codes

#
    // $acquiredDate = Carbon::parse($data['acquired_date']);
        // $year = $acquiredDate->format('y');
        // $month = str_pad($acquiredDate->month, 2, '0', STR_PAD_LEFT);
        // $day = str_pad($acquiredDate->day, 2, '0', STR_PAD_LEFT);
        // $time = Carbon::now();
        // $hour = str_pad($time->hour, 2, '0', STR_PAD_LEFT); // Get the hour and pad with leading zero if necessary
        // $minute = str_pad($time->minute, 2, '0', STR_PAD_LEFT); // Get the minute and pad with leading zero if necessary
        // $second = str_pad($time->second, 2, '0', STR_PAD_LEFT);

        // $facility = Facility::where('id', $facilityName)->firstOrFail();
#
