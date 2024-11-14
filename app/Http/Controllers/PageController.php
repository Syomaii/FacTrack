<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
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

    public function dashboard()
    {
        // Fetch recent logged-in users, paginated users, and equipment data
        $recentLoggedIn = User::where('type', '!=', 'admin')
            ->orderBy('last_login_at', 'desc')
            ->take(5)
            ->get();
    
        $users = User::where('type', '!=', 'admin')->paginate(10);
        $userCount = User::where('type', '!=', 'admin')->count();
        $equipmentCount = Equipment::count();
        $totalBorrowedEquipments = Borrower::whereNull('returned_date')->count();
        $totalInRepairEquipments = Equipment::where('status', 'in_repair')->count();
    
        // Fetch all data from the borrows table
        $borrows = Borrower::all(); // Fetch all records from the borrows table
    
        // Calculate borrowed equipment per month (you can modify this query as needed)
        $borrowedPerMonth = Borrower::selectRaw('YEAR(borrowed_date) as year, MONTH(borrowed_date) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    
        // Pass all data to the view
        return view('dashboard', compact(
            'userCount', 'equipmentCount', 'totalBorrowedEquipments',
            'totalInRepairEquipments', 'borrows', 'users', 'recentLoggedIn', 'borrowedPerMonth'
        ))->with('title', 'Dashboard');
    }
    
    
    

    public function facilities(){

        $officeId = Auth::user()->office_id;
        $office = Office::with('facilities')->find($officeId);

        $facilities = Facility::whereHas('office', function ($query) use ($officeId) {
            $query->where('office_id', $officeId);
        })->paginate(5);

        return view('facilities/facilities', compact('officeId', 'facilities'))->with('title', 'Facilities');
    }

    public function users(Request $request)
    {
        // Get the currently logged-in user
        $loggedInUser = Auth::user();


        if($loggedInUser->type === 'admin'){
            $users = User::with(['designation', 'office']) // Load relationships
                    ->where('type', '!=', 'admin') // Filter by office ID
                    ->paginate(10); 
        }else{
            $users = User::with(['designation', 'office']) // Load relationships
                    ->where('type', '!=', 'admin') // Exclude admin users
                    ->where('office_id', $loggedInUser->office_id) // Filter by office ID
                    ->paginate(10); 
        }

        $totalUsers = $users->total();
        $currentPage = $users->currentPage();
        $perPage = $users->perPage();
        $currentCount = $users->count();
        $start = ($currentPage - 1) * $perPage + 1;
        $end = $start + $currentCount - 1;

        return view('users.users', compact('users', 'totalUsers', 'start', 'end'))
            ->with('title', 'Users');
    }

    public function equipments(){
        $officeId = Auth::user()->office_id;

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
        return view('transaction.scancode')->with('title', 'Scan Code');
    }

    public function returnEquipment(){
        return view('transaction/return_equipment')->with('title', 'Return Equipment');
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

    public function equipmentDetails($code)
    {
        $equipments = Equipment::where('code', $code)->first();
        
        // Check if equipment exists
        if (!$equipments) {
            return redirect()->back()->with('error', 'Equipment not found');
        }
    
        // Get the timeline for the equipment
        $timeline = $equipments->timeline()->get(); // Get the timeline entries
    
        // Pass the data to the view
        $data = [
            'equipments' => $equipments,
            'timeline' => $timeline,
            'title' => 'Equipment Details'
        ];
        
        return view('equipments/equipment_details', $data);
    }
    
    
    

    public function addUser(){
        $designations = Designation::all();
        $offices = Office::all();
        $userType = Auth::user()->type;
        $officeId = Auth::user()->office_id;

        return view('users/add_user', compact('designations', 'offices', 'userType', 'officeId'))->with('title', 'Add User');
    }

    public function generatedQr(){
        $equipments = Equipment::findOrFail('id');

        return view('equipments/generateqr', compact('equipments'))->with('title', 'Generated Qr');
    }

   public function facilityEquipments($id)
    {
        $facility = Facility::with('office')->findOrFail($id); 
        $equipments = Equipment::where('facility_id', $id)->paginate(5);

        return view('facilities/facility_equipments', compact('facility', 'equipments'))->with('title', 'Facility Equipments');
    }

    public function borrowersLog()
    {
        // Fetch the borrow records from the database
        $perPage = 10; // Or you can get this from a request parameter
        $borrows = Borrower::with(['equipment', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('reports.borrowers_log', compact('borrows'))->with('title', 'Borrowers Details');
    }

    public function maintenance()
    {
        // Logic for scanning or displaying equipment in maintenance
        return view('transaction.maintenance')->with('title', 'Maintenance Equipment'); // Load the maintenance view
    }   
    public function repairEquipment()
    {
        // Logic for scanning or displaying equipment in maintenance
        return view('transaction.repair')->with('title', 'Repair Equipment'); // Load the maintenance view
    }    
    public function students(){
        return view('students.students')->with('title', 'Import');
    }

    public function disposeEquipment()
    {
        // Logic for scanning or displaying equipment in maintenance
        return view('transaction/disposed')->with('title', 'Dispose Equipment'); // Load the maintenance view
    }
    
    public function donateEquipment()
    {
        // Logic for scanning or displaying equipment in maintenance
        return view('transaction/donate')->with('title', 'Donate Equipment'); // Load the maintenance view
    }

    public function addStudent()
{
    return view('students/add_student')->with('title', 'Add Student');
}

}
