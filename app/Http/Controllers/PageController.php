<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Designation;
use App\Models\Equipment;
use App\Models\Facility;
use App\Models\Office;
use App\Models\Repair;
use App\Models\User;
use Database\Factories\EquipmentFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PageController extends Controller
{
    public function login(){
        return view('users/index')->with('title', 'Login');
    }

    public function dashboard()
    {
        $loggedInUser = Auth::user();
        // Fetch recent logged-in users, paginated users, and equipment data
        $recentLoggedIn = User::where('type', '!=', 'admin')
            ->orderBy('last_login_at', 'desc')
            ->take(5)
            ->get();

        $facilities = Facility::where('office_id', '=', $loggedInUser->office_id)->pluck('id');  

        $equipments = Equipment::whereIn('facility_id', $facilities)->get();

        if($loggedInUser->type === 'admin'){
            $users = User::with(['designation', 'office']) // Load relationships
                    ->where('type', '!=', 'admin') // Filter by office ID
                    ->paginate(5); 
            
            $borrows = Borrower::all(); 
            
            $equipmentCount = Equipment::count();
            
            $userCount = User::count();
            
            $totalBorrowedEquipments = Borrower::whereNull('returned_date')->count();
            
            $totalInRepairEquipments = Equipment::where('status', 'in_repair')->count();
            
            $borrowedPerMonth = Borrower::selectRaw('YEAR(borrowed_date) as year, MONTH(borrowed_date) as month, COUNT(*) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        }elseif($loggedInUser->type === 'operator' || $loggedInUser->type === 'facility manager'){
            $users = User::where('type', '!=', 'admin') // Exclude admin users
                    ->where('office_id', $loggedInUser->office_id) // Filter by office ID
                    ->paginate(5); 
            
                    $equipmentCount = Equipment::with('facility') 
                    ->whereIn('facility_id', $facilities) 
                    ->count();
            // Get all the borrowers who have borrowed the equipments from the retrieved list
            $borrows = Borrower::whereIn('equipment_id', $equipments->pluck('id'))->get();
            
            $totalBorrowedEquipments = Borrower::whereIn('equipment_id', $equipments->pluck('id'))
                                    ->whereNull('returned_date')->count();
            $totalInRepairEquipments = Repair::whereIn('equipment_id', $equipments->pluck('id'))
                                    ->whereNull('returned_date')->count();

            $userCount = User::where('type', '!=', 'admin')->where('office_id', $loggedInUser->office_id)->count();
            
            $borrowedPerMonth = Borrower::selectRaw('YEAR(borrowed_date) as year, MONTH(borrowed_date) as month, COUNT(*) as total')
                ->join('equipments', 'borrows.equipment_id', '=', 'equipments.id') // Join with the equipment table
                ->join('facilities', 'equipments.facility_id', '=', 'facilities.id') // Join with the facilities table
                ->whereIn('equipments.facility_id', $facilities) // Filter by the equipment's facility_id (which belongs to the same office)
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        }

        $start = ($users->currentPage() - 1) * $users->perPage() + 1;
        $end = min($start + $users->perPage() - 1, $userCount);

        
    
        return view('dashboard', compact(
            'userCount', 'equipmentCount', 'totalBorrowedEquipments',
            'totalInRepairEquipments', 'borrows', 'users', 'recentLoggedIn', 'borrowedPerMonth',
            'start', 'end'
        ))->with('title', 'Dashboard');
    }

    

    public function dashboardSearchUser (Request $request)
    {
        $search = $request->input('search');
    
        // Adjust the query to exclude admin users
        $users = User::when($search, function ($query, $search) {
            return $query->where('type', '!=', 'admin') // Exclude admin users
                         ->where(function($q) use ($search) {
                             $q->where('firstname', 'like', '%' . $search . '%')
                               ->orWhere('lastname', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                         });
        }, function ($query) {
            // If no search term, just exclude admin users
            return $query->where('type', '!=', 'admin');
        })->paginate(10);
    
        // Get the total count of users for pagination
        $totalUsers = User::where('type', '!=', 'admin')->count(); // Count excluding admin users
        $start = $users->firstItem();
        $end = $users->lastItem();
    
        // Fetch other required data
        $userCount = User::where('type', '!=', 'admin')->count(); // Count excluding admin users
        $equipmentCount = Equipment::count();
        $totalBorrowedEquipments = Equipment::where('status', 'Borrowed')->count();
        $totalInRepairEquipments = Equipment::where('status', 'In Repair')->count();
        $borrowedPerMonth = Borrower::selectRaw('YEAR(borrowed_date) as year, MONTH(borrowed_date) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        $recentLoggedIn = User::orderBy('last_login_at', 'desc')->take(5)->get();
    
        return view('dashboard', compact(
            'userCount', 'equipmentCount', 'totalBorrowedEquipments',
            'totalInRepairEquipments', 'users', 'recentLoggedIn', 'borrowedPerMonth',
            'totalUsers', 'start', 'end'
        ))->with('title', 'Dashboard');
    }
    
    public function notifications(){
        $notifications = Auth::check() ? Auth::user()->notifications()->get() : collect();
        return view('notifications', compact('notifications'))->with('title', 'Notifications');
    }
    

    public function facilities(){

        $officeId = Auth::user()->office_id;
        $office = Office::with('facilities')->find($officeId);

        $facilities = Facility::whereHas('office', function ($query) use ($officeId) {
            $query->where('office_id', $officeId);
        })->get();

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

    public function equipments() {
        
        $officeId = Auth::user()->office_id;

        $facilities = Facility::where('office_id', '=', $officeId)->pluck('id');  
    
        $equipments = Equipment::with('facility')  // Make sure to load the facility relationship
                    ->whereIn('facility_id', $facilities)  // Filter equipments where facility_id is in the list of retrieved facilities
                    ->paginate(10);
        // dd($equipments->toArray());
        // Return the view with the equipments data
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
    $user = Auth::user();

    if ($user && $user->office) {
        $borrows = Borrower::with(['equipment', 'user'])
            ->whereHas('user', function ($query) use ($user) {
                $query->where('office_id', $user->office->id); 
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }else {
        $borrows = collect(); 
    }

    return view('reports.borrowers_log', compact('borrows'))->with('title', 'Borrowers Details');
}

    // In BorrowerController.php
public function borrowerSearch(Request $request)
{
    $search = $request->input('search');

    $borrows = Borrower::with('equipment')
        ->when($search, function ($query, $search) {
            return $query->where('borrowers_name', 'LIKE', "%{$search}%")
                         ->orWhere('borrowers_id_no', 'LIKE', "%{$search}%")
                         ->orWhereHas('equipment', function ($q) use ($search) {
                             $q->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('brand', 'LIKE', "%{$search}%");
                         });
        })
        ->paginate(10); // Adjust pagination as needed

    return view('reports/borrowers_log', compact('borrows'))->with('title', 'Borrowers Log');
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
        $offices = Office::all();

        return view('students.students', compact('offices'))->with('title', 'Import');
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
        $offices = Office::all();
        return view('students/add_student', compact('offices'))->with('title', 'Add Student');
    }

}
