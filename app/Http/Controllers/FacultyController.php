<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredUserMail;
use App\Models\Borrower;
use App\Models\Designation;
use App\Models\EquipmentReservation;
use App\Models\FacilityReservation;
use App\Models\Faculty;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

class FacultyController extends Controller
{
    public function viewDepartment(){

        $faculty = Faculty::all()->groupBy('department');

        return view('faculty.view_department_faculty', compact('faculty'))->with('title', 'Faculty');
    }

    public function viewFacultyByDepartment($department)
    {
        $faculties = Faculty::where('department', $department)->paginate(10);
        $facultyIdNo = Faculty::where('department', $department)->pluck('id');
        $totalFaculties = Faculty::where('department', $department)->count();
        $start = ($faculties->currentPage() - 1) * $faculties->perPage() + 1;
        $end = min($start + $faculties->perPage() - 1, $totalFaculties);
    
        return view('faculty.view_faculty_by_department', compact('faculties', 'facultyIdNo', 'department', 'totalFaculties', 'start', 'end'))
            ->with('title', 'Faculty in ' . $department);
    }
    
    public function search(Request $request)
    {
        $query = Faculty::query();

        if ($request->filled('department')) {
            $department = $request->input('department');
            $query->where('department', $department);
        }
    
        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('firstname', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('lastname', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        // Sort by name (ascending or descending)
        if ($request->filled('sort') && in_array($request->input('sort'), ['asc', 'desc'])) {
            $query->orderBy('firstname', $request->input('sort'));
        }
    
        // Paginate results
        $faculties = $query->paginate(10)->appends($request->query());
    
        // Get the department from the first faculty's data
        $department = $faculties->isNotEmpty() ? $faculties->first()->department : null;
    
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return view('partials.faculty_table', [
                'faculties' => $faculties,
                'totalFaculties' => $faculties->total(),
                'start' => ($faculties->currentPage() - 1) * $faculties->perPage() + 1,
                'end' => min(($faculties->currentPage() - 1) * $faculties->perPage() + $faculties->count(), $faculties->total())
            ]);
        }
    
        // Render full view if not an AJAX request
        return view('faculty.view_faculty_by_department', [
            'faculties' => $faculties,
            'department' => $department,
            'totalFaculties' => $faculties->total(),
            'start' => ($faculties->currentPage() - 1) * $faculties->perPage() + 1,
            'end' => min(($faculties->currentPage() - 1) * $faculties->perPage() + $faculties->count(), $faculties->total())
        ])->with('title', 'Search Results');
    }
    

    public function facultyProfile($id)
    {
        $faculty = Faculty::findOrFail($id);
        $facultyBorrowHistory = Borrower::with('equipment')->where('borrowers_id_no', $id)->get();
        $facultyReservations = EquipmentReservation::with('equipment')->where('reservers_id_no', $id)->get();
        $facultyFacilityReservations = FacilityReservation::with('facility')->where('reservers_id_no', $id)->get();
        
        
        if (!$faculty) {
            abort(404); 
        }

        return view('faculty.faculty_profile', compact('faculty', 'facultyBorrowHistory', 'facultyFacilityReservations', 'facultyReservations'))
            ->with('title', 'Faculty Profile');
    }

    public function addFacultyPost(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|digits:6|unique:faculty,id', 
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNotNull('faculty_id')->orWhereNotNull('student_id');
                }),
            ],
            'department' => 'required|string|max:255',
        ]);

        $office = Office::where('type', '=', 'department')->first();
        $officeId = $office ? $office->id : null;
        
        Faculty::create([
            'id' => $data['id'],
            'firstname' => ucwords(strtolower($data['firstname'])),
            'lastname' => ucwords(strtolower($data['lastname'])),
            'email' => $data['email'],
            'department' => ucwords($data['department']), 
        ]);
        
        User::create([
            'faculty_id' => $data['id'] ?? null,
            'designation_id' => 4,
            'office_id' => $officeId,
            'image' => 'images/profile_pictures/default-profile.png',
            'firstname' => ucwords(strtolower($data['firstname'])),
            'lastname' => ucwords(strtolower($data['lastname'])),
            'email' => $data['email'],
            'password' => bcrypt($data['id']), // Default password (should be updated by the user later)
            'type' => 'faculty', // Assign role as 'faculty'
            'status' => 'active',
            'mobile_no' => 'none', // Optional: Link to the Student ID
        ]);
        
        

        return redirect('/add-faculty')->with('success', 'Faculty member added successfully.');
    }

    public function facultyDashboard(){
        
        $faculty = Auth::user();

        $facultyReservations = EquipmentReservation::with('equipment')->where('reservers_id_no', $faculty->faculty_id)->get();

        $data = ([
            'faculty' => $faculty,
            'facultyReservations' => $facultyReservations,
            'title' => 'Faculty Dashboard'
        ]);


        return view('faculty.faculty_dashboard', $data);
    }

    // public function profile($faculty_id)
    // {
    //     $faculty = facultys::findOrFail($faculty_id);
    //     $facultyBorrowHistory = Borrower::with('equipment')->where('borrowers_id_no', $faculty_id)->get();
    //     $facultyReservations = Reservation::with('equipment')->where('faculty_id', $faculty_id)->get();
        
    //     if (!$faculty) {
    //         abort(404); 
    //     }

    //     return view('faculty.faculty_profile', compact('faculty', 'facultyBorrowHistory', 'facultyReservations'))
    //         ->with('title', 'Faculty Profile');
    // }
}
