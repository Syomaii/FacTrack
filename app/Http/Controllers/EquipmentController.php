<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Facility;
use App\Models\Timeline;
use App\Models\Office;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function addEquipmentPost(Request $request){
    
        // Validate the request data
        $data = $request->validate([
            'brand' => 'required',
            'name' => 'required',
            'serial_no' => 'required|unique:equipments,serial_no',  
            'description' => 'required',
            'acquired_date' => 'required|date|before_or_equal:now',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:Available,In Maintenance,In Repair,Borrowed',
            'owned_by' => 'required',
            'owned_by_other' => 'required_if:owned_by,Others',
        ]);

        $facilityId = $request->input('facility');
        $facility = Facility::where('id', $facilityId)->firstOrFail();
        
        $officeId = $facility->office_id;
    
        $data['facility_id'] = $facility->id;
        $data['user_id'] = Auth::user()->id;
    
        $code = date('y') . $officeId . date('m') . date('d') . $facilityId . date('H') . $data['user_id'] . date('is') . $data['serial_no'];
        $data['code'] = $code;

        $data['next_due_date'] = Carbon::now()->addDays(30);

        $ownedBy = $request->owned_by === 'Others' ? $request->owned_by_other : $request->owned_by;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->move(public_path('images/equipments'), $image->getClientOriginalName());
            $imageUrl = 'images/equipments/' . $image->getClientOriginalName();
        } 
    
        $equipment = Equipment::create([
            'facility_id' => $facility->id,
            'user_id' => Auth::user()->id,
            'brand' => ucwords(strtolower($data['brand'])),
            'name' => ucwords(strtolower($data['name'])),
            'serial_no' => $data['serial_no'],  
            'description' => ucfirst($data['description']),
            'acquired_date' => $data['acquired_date'],
            'code' => $data['code'],
            'image' => $imageUrl,
            'status' => $data['status'],
            'owned_by' => $ownedBy,
            'next_due_date' => Carbon::now()->addDays(30),

        ]);
        
        Timeline::create([
            'equipment_id' => $equipment->id,
            'status' => $equipment->status,
            'remarks' => 'The day the equipment is added in the system',
            'user_id' => Auth::user()->id
        ]);
    
        return redirect()->route('equipment-details', ['code' => $equipment->code])
                     ->with('title', 'Equipment Details')
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
        ];

        $equipment = Equipment::where('id', $request['id'])->first();
        $equipment->update($updateData);

        Timeline::create([
            'equipment_id' => $equipment->id,
            'status' => $equipment->status,
            'remarks' => 'The day the equipment is updated in the system',
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('equipments')->with('updateEquipmentSuccessfully', 'Equipment updated successfully');
    }
  

    public function deleteEquipment($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
    
        return redirect()->route('equipments')->with('deleteEquipmentSuccessfully', 'Equipment deleted successfully.');
    }
    
    public function equipmentSearch(Request $request)
{
    $search = $request->input('search');
    $equipments = Equipment::when($search, function ($query, $search) {
        return $query->where('name', 'like', '%' . $search . '%')
                     ->orWhere('brand', 'like', '%' . $search . '%')
                     ->orWhere('serial_no', 'like', '%' . $search . '%')
                     ->orWhere('owned_by', 'like', '%' . $search . '%');
    })->paginate(10);

    return view('equipments/equipments', compact('equipments'))->with('title', 'Equipments');
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
