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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PageController extends Controller
{
    public function login(){
        return view('users/index')->with('title', 'Login');
    }

    public function dashboard(Request $request)
    {
        $loggedInUser = Auth::user();

        // Fetch recent logged-in users, paginated users, and equipment data
        $recentLoggedIn = User::where('type', '!=', 'admin')
            ->orderBy('last_login_at', 'desc')
            ->take(8)
            ->get();

        $facilities = Facility::where('office_id', '=', $loggedInUser->office_id)->pluck('id');  

        $equipments = Equipment::whereIn('facility_id', $facilities)->get();

        if ($loggedInUser->type === 'admin') {
            $users = User::with(['designation', 'office'])
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
        } elseif ($loggedInUser->type === 'operator' || $loggedInUser->type === 'facility manager') {
            $users = User::where('type', '!=', 'admin')
                ->where('office_id', $loggedInUser->office_id)
                ->paginate(5);

            $equipmentCount = Equipment::with('facility')
                ->whereIn('facility_id', $facilities)
                ->count();

            $borrows = Borrower::whereIn('equipment_id', $equipments->pluck('id'))->get();

            $totalBorrowedEquipments = Borrower::whereIn('equipment_id', $equipments->pluck('id'))
                ->whereNull('returned_date')->count();

            $totalInRepairEquipments = Repair::whereIn('equipment_id', $equipments->pluck('id'))
                ->whereNull('returned_date')->count();

            $userCount = User::where('type', '!=', 'admin')
                ->where('office_id', $loggedInUser->office_id)
                ->count();

            $borrowedPerMonth = Borrower::selectRaw('YEAR(borrowed_date) as year, MONTH(borrowed_date) as month, COUNT(*) as total')
                ->join('equipments', 'borrows.equipment_id', '=', 'equipments.id')
                ->join('facilities', 'equipments.facility_id', '=', 'facilities.id')
                ->whereIn('equipments.facility_id', $facilities)
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        }

        // Extract unique years from the borrowedPerMonth data
        $years = $borrowedPerMonth->pluck('year')->unique()->sort()->values();

        // If a year filter is set, filter the borrowedPerMonth data for that year
        if ($request->has('year')) {
            $year = $request->input('year');
            $borrowedPerMonth = $borrowedPerMonth->where('year', $year);
        }

        $start = ($users->currentPage() - 1) * $users->perPage() + 1;
        $end = min($start + $users->perPage() - 1, $userCount);

        return view('dashboard', compact(
            'userCount', 'equipmentCount', 'totalBorrowedEquipments',
            'totalInRepairEquipments', 'borrows', 'users', 'recentLoggedIn', 'borrowedPerMonth',
            'start', 'end', 'years' // Pass years to the view
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
            $loggedInUserType = Auth::user()->type;

            // If no search term, just exclude admin users
            if($loggedInUserType != 'admin'){
                return $query->where('type', '!=', 'admin');
            }else{
                return $query;
            }
            
        })->paginate(5);
    
        // Get the total count of users for pagination
        $totalUsers = User::where('type', '!=', 'admin')->count(); 
        $start = $users->firstItem();
        $end = $users->lastItem();
    
        // Fetch other required data
        $userCount = User::where('type', '!=', 'admin')->count(); 
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
    
    public function notifications()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to log in to view notifications.');
        }

        $notifications = Auth::user()->notifications;

        foreach ($notifications as $notification) {
            if (is_null($notification->read_at)) {
                $notification->update(['read_at' => now()]);
            }
        }

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
    
        // Get the facilities associated with the user's office
        $facilities = Facility::where('office_id', '=', $officeId)->pluck('id');  
    
        // Get the equipments associated with the facilities
        $equipments = Equipment::with('facility')
                    ->whereIn('facility_id', $facilities)
                    ->paginate(10);
    
        // Assuming you want to pass the first facility ID or a specific one
        $facilityId = $facilities->first(); // or set it to a specific facility ID if needed
    
        // Return the view with the equipments data
        return view('equipments/equipments', compact('equipments', 'facilities', 'facilityId')) // Pass the facilityId
               ->with('title', 'Equipments');
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
            'equipment' => $equipments,
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
    
        // Check user type
        if (Auth::user()->type === 'student' || Auth::user()->type === 'faculty') {
            // Exclude disposed and donated equipment
            $equipments = Equipment::where('facility_id', $id)
                ->whereNotIn('status', ['disposed', 'donated'])
                ->paginate(5);
        } else {
            // No restriction for other user types
            $equipments = Equipment::where('facility_id', $id)->paginate(5);
        }
    
        return view('facilities/facility_equipments', compact('facility', 'equipments'))->with('title', 'Facility Equipments');
    }
    

    public function borrowersLog()
    {
        $user = Auth::user();
    
        if ($user && $user->office) {
            // Get the office ID of the authenticated user
            $officeId = $user->office->id;
    
            // Debugging: Check the office ID
            // dd($officeId); 
    
            // Retrieve borrowers associated with the same office
            $borrows = Borrower::with(['equipment', 'user'])
                ->whereHas('user', function ($query) use ($officeId) {
                    $query->where('office_id', $officeId); 
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
    
            // Debugging: Check the generated SQL query
            // \DB::enableQueryLog();
            // dd(\DB::getQueryLog()); // Uncomment to see the last executed query
        } else {
            $borrows = collect(); 
        }
    
        return view('reports.borrowers_log', compact('borrows'))->with('title', 'Borrowers Details');
    }


    // In BorrowerController.php
    public function borrowerSearch(Request $request)
    {
        $query = Borrower::query();

        $officeId = Auth::user()->office_id;

        $query->where('office_id', $officeId); // Assuming the Borrower model has an office_id field
        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('borrowers_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('borrowers_id_no', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('department', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('equipment', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Sort by ID filter
        if ($request->filled('sort_by_id') && in_array($request->input('sort_by_id'), ['asc', 'desc'])) {
            $query->orderBy('borrowers_id_no', $request->input('sort_by_id'));
        }

        // Paginate the results and preserve query parameters
        $borrows = $query->with('equipment')->paginate(10)->appends($request->query());

        return view('reports/borrowers_log', [
            'borrows' => $borrows,
            'totalBorrows' => $borrows->total(),
            'start' => ($borrows->currentPage() - 1) * $borrows->perPage() + 1,
            'end' => min(($borrows->currentPage() - 1) * $borrows->perPage() + $borrows->count(), $borrows->total())
        ])->with('title', "Borrower's Log");
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

    public function faculties(){
        $offices = Office::all();

        return view('faculty.faculties', compact('offices'))->with('title', 'Import');
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

    public function addFaculty()
    {
        $offices = Office::all();
        return view('faculty.add_faculty', compact('offices'))->with('title', 'Add Faculty');
    }

}
