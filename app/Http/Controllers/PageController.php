<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Equipment;
use App\Models\Facility;
use App\Models\Office;
use App\Models\User;
use Database\Factories\EquipmentFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function login(){
        return view('users/index')->with('title', 'Login');
    }

    public function dashboard(){
        $userCount = User::count();
        $equipmentCount = Equipment::count();
    
        $data = [
            'userCount' => $userCount,
            'equipmentCount' => $equipmentCount,
            'title' => 'Dashboard'
        ];
    

        return view('dashboard')->with($data);
    }

    public function facilities(){
        $officeId = auth()->user()->office_id;
        $facilities = Facility::whereHas('office', function ($query) use ($officeId) {
            $query->where('office_id', $officeId);
        })->paginate(5);

        return view('facilities/facilities', compact('officeId', 'facilities'))->with('title', 'Facilities');
    }

    public function users(){
        $users = User::with(['designation', 'office'])->get();

        return view('users/users', compact('users'))->with('title', 'Users');
    }

    public function equipments(){
        $officeId = auth()->user()->office_id;

        if (isset($_GET['q'])){
            $q = $_GET['q'];
            $category = $_GET['category'];
            $e = $_GET['e'];
            $equipments = Equipment::whereHas('facility', function ($query) use ($officeId) {
                $query->where('office_id', $officeId);
            })->orderBy('acquired_date', 'desc')->paginate($e);
        }else{
            $equipments = Equipment::whereHas('facility', function ($query) use ($officeId) {
                $query->where('office_id', $officeId);
            })->orderBy('acquired_date', 'desc')->paginate(5);
        }

        return view('equipments/equipments', compact('equipments'))->with('title', 'Equipments');
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        $designations = Designation::all(); 

        return view('users/profile', compact('user', 'designations'))->with('title', 'Profile');
    }

    public function addFacility(){
        return view('facilities/add_facility')->with('title', 'Reports');
    }

    public function scanCode(){
        return view('equipments/scancode')->with('title', 'Scan Code');
    }

    public function returnEquipment(){
        return view('equipments/return_equipment')->with('title', 'Return Equipment');
    }
    
    public function error404(){
        return view('errors.404')->with('title', 'Error 404 - Page Not Found');
    }

    public function error401(){
        return view('errors.401')->with('title', 'Error 401 - Unauthorized');
    }

    public function offices(){
        $offices = Office::all();

        return view('offices/offices')
            ->with('title', 'Offices')
            ->with('offices', $offices);
    }

    public function addEquipment($id){
        $facility = Facility::find($id);
        return view('equipments/add_equipment', compact('facility'))->with('title', 'Add Equipment');
    }

    public function equipmentDetails($code){
        $equipments = Equipment::where('code', $code)->first();
        $data = [
            'equipments' => $equipments,
            'timeline' => $equipments->timeline,
            'title' => 'Equipment Details'
        ];

        return view('equipments/equipment_details', $data);
    }

    public function addUser(){
        $designations = Designation::all();
        $offices = Office::all();
        $userType = auth()->user()->type;
        $officeId = auth()->user()->office_id;

        return view('users/add_user', compact('designations', 'offices', 'userType', 'officeId'))->with('title', 'Add User');
    }

    public function generatedQr(){
        $equipments = Equipment::findOrFail('id');

        return view('equipments/generateqr', compact('equipments'))->with('title', 'Generated Qr');
    }

    public function facilityEquipments($id)
    {
        $facility = Facility::findOrFail($id);
        $equipments = Equipment::where('facility_id', $id)->paginate(5);

        return view('facilities/facility_equipments', compact('facility', 'equipments'))->with('title', 'Facility Equipments');
    }

    
}
