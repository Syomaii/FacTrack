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
        return view('index')->with('title', 'Login');
    }

    public function dashboard(){
        return view('dashboard')->with('title', 'Dashboard');
    }

    public function facilities(){
        $officeId = auth()->user()->office_id;
        $facilities = Facility::whereHas('office', function ($query) use ($officeId) {
            $query->where('office_id', $officeId);
        })->paginate(5);

        return view('facilities', compact('officeId', 'facilities'))->with('title', 'Facilities');
    }

    public function users(){
        $users = User::with(['designation', 'office'])->get();

        return view('users', compact('users'))->with('title', 'Users');
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

        return view('equipments', compact('equipments'))->with('title', 'Equipments');
    }

    public function borrowedEquipmentReports(){
        return view('borrowed_equipments')->with('title', 'Borrowed Equipments');
    }

    public function addFacility(){
        return view('add_facility')->with('title', 'Reports');
    }

    public function scanCode(){
        return view('scancode')->with('title', 'Scan Code');
    }
    
    public function error404(){
        return view('errors.404')->with('title', 'Error 404 - Page Not Found');
    }

    public function error401(){
        return view('errors.401')->with('title', 'Error 401 - Unauthorized');
    }
    public function offices(){
        return view('offices')->with('title', 'Offices');
    }

    public function addEquipment($id){
        $facility = Facility::find($id);
        return view('add_equipment', compact('facility'))->with('title', 'Add Equipment');
    }

    public function equipmentDetails($code){
        $equipments = Equipment::where('code', $code)->first();
        $data = [
            'equipments' => $equipments,
            'title' => 'Equipment Details'
        ];

        return view('equipment_details', $data);
    }

    public function addUser(){
        $designations = Designation::all();
        $offices = Office::all();
        $userType = auth()->user()->type;
        $officeId = auth()->user()->office_id;

        return view('add_user', compact('designations', 'offices', 'userType', 'officeId'))->with('title', 'Add User');
    }

    public function generatedQr(){
        $equipments = Equipment::findOrFail('id');

        return view('generateqr', compact('equipments'))->with('title', 'Generated Qr');
    }

    public function facilityEquipments($id)
    {
        $facility = Facility::findOrFail($id);
        $equipments = Equipment::where('facility_id', $id)->get();

        return view('facility_equipments', compact('facility', 'equipments'))->with('title', 'Facility Equipments');
    }

    
}
