<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Facility;
use App\Models\Office;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function addEquipmentPost(Request $request){
        
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'acquired_date' => 'required|date',
            'image' => 'mimes:jpg,png,jpeg,gif|max:2048',
            'status' => 'required|in:Available,In Maintenance,In Repair,Borrowed',
            'owned_by' => 'required',
        ]);

        $facilityId = $request->input('facility');
        $facility = Facility::where('id', $facilityId)->firstOrFail();
        
        $officeId = $facility->office_id;

        $data['facility_id'] = $facility->id;
        $data['user_id'] = auth()->user()->id;

        $code = date('y') . $officeId . date('m') . date('d') . $facilityId . date('H') . $data['user_id'] . date('is');
        
        $data['code'] = $code;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->move(public_path('images/equipments'), $image->getClientOriginalName());
            $data['image'] = 'images/equipments/' . $image->getClientOriginalName();
        }

        Equipment::create($data);

        return redirect()->route('facility_equipments', ['id' => $facility->id])
                     ->with('title', 'Facility Equipment')
                     ->with('addEquipmentSuccessfully', 'Equipment Added Successfully!');
    }
    
    public function updateEquipment(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'acquired_date' => 'required|date|before_or_equal:now',
            'facility' => 'required',
            'status' => 'required|in:Available,In Maintenance,In Repair,Borrowed',
        ]);

        $acquiredDate = new \DateTime($data['acquired_date']);
        $now = new \DateTime();

        if ($acquiredDate > $now) {
            return back()->withErrors(['acquired_date' => 'The acquisition date must be present or past date.']);
        }

        Equipment::where('id', $request['id'])->update($data);
        return redirect()->route('equipments')->with('updateEquipmentSuccessfully', 'Equipment updated successfully');
    }

    public function deleteEquipment($id){

        Equipment::where('id', $id)->delete();
        return redirect('/equipments')->with('deleteEquipmentSuccessfully', 'Equipment deleted successfully');
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