<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\RegisteredUserMail;
use App\Models\Borrower;
use App\Models\Designation;
use App\Models\EquipmentReservation;
use App\Models\FacilityReservation;
use App\Models\Office;
use App\Models\Reservation;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;

class StudentController extends Controller
{
    public function viewDepartment(){

        $students = Students::all()->groupBy('department');

        return view('students.view_department', compact('students'))->with('title', 'Students Department');
    }

    public function viewStudentsByDepartment($department)
    {
        $students = Students::where('department', $department)->paginate(10);
        $studentsIdNo = Students::where('department', $department)->pluck('id');
        $totalStudents = Students::where('department', $department)->count();
        $start = ($students->currentPage() - 1) * $students->perPage() + 1;
        $end = min($start + $students->perPage() - 1, $totalStudents);
    
        return view('students.view_students_by_department', compact('students', 'studentsIdNo', 'department', 'totalStudents', 'start', 'end'))
            ->with('title', 'Students in ' . $department);
    }
    
    public function search(Request $request)
    {
        $query = Students::query();
    
        // Get the department from the request
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
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('course', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        // Year filter (1st Year, 2nd Year, etc.)
        if ($request->filled('year')) {
            $year = $request->input('year'); // e.g., "1st Year", "2nd Year", etc.
            $yearNumber = (int) filter_var($year, FILTER_SANITIZE_NUMBER_INT); // Extract the year number (1, 2, 3, 4)
            $query->where('course', 'LIKE', "%{$yearNumber}%");
        }
    
        // Sort by name (ascending or descending)
        if ($request->filled('sort') && in_array($request->input('sort'), ['asc', 'desc'])) {
            $query->orderBy('firstname', $request->input('sort'));
        }
    
        // Paginate results
        $students = $query->paginate(10)->appends($request->query());
    
        // Get the department from the first student's data
        $department = $students->isNotEmpty() ? $students->first()->department : null;
    
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return view('partials.student_table', [
                'students' => $students,
                'totalStudents' => $students->total(),
                'start' => ($students->currentPage() - 1) * $students->perPage() + 1,
                'end' => min(($students->currentPage() - 1) * $students->perPage() + $students->count(), $students->total())
            ]);
        }
    
        // Render full view if not an AJAX request
        return view('students.view_students_by_department', [
            'students' => $students,
            'department' => $department,
            'totalStudents' => $students->total(),
            'start' => ($students->currentPage() - 1) * $students->perPage() + 1,
            'end' => min(($students->currentPage() - 1) * $students->perPage() + $students->count(), $students->total())
        ])->with('title', 'Search Results');
    }
    
    public function studentProfile($id)
{
    $student = Students::findOrFail($id);
    
    // Get current date
    $currentDate = Carbon::now();

    // Fetch approved equipment reservations that have passed their expected return date
    $studentReservations = EquipmentReservation::with('equipment')
        ->where('reservers_id_no', $id)
        ->where('status', 'approved')
        ->where('expected_return_date', '<', $currentDate)
        ->get();

    // Process each approved equipment reservation that has passed the expected return date
    foreach ($studentReservations as $reservation) {
        // Create a new borrow history entry
        Borrower::create([
            'equipment_id' => $reservation->equipment_id,
            'user_id' => Auth::user()->id, 
            'borrowers_id_no' => $reservation->reservers_id_no,
            'borrowers_name' => $student->firstname . ' ' . $student->lastname,
            'department' => $student->department,
            'borrowed_date' => $currentDate,
            'expected_returned_date' => $reservation->expected_return_date,
            'returned_date' => $currentDate, // Set returned_date to current date
            'status' => 'Returned', // Set status to Returned
            'purpose' => $reservation->purpose,
            'remarks' => 'The day the equipment is Returned', 
        ]);

        // Update the reservation status to completed
        $reservation->status = 'completed'; 
        $reservation->save();
    }

    // Fetch the updated borrow history
    $studentBorrowHistory = Borrower::with('equipment')->where('borrowers_id_no', $id)->get();

    // Fetch active reservations (not completed or archived)
    $studentReservations = EquipmentReservation::with('equipment')
        ->where('reservers_id_no', $id)
        ->where('status', '!=', 'completed') // Exclude completed reservations
        ->get();

    $studentFacilityReservations = FacilityReservation::with('facility')
        ->where('reservers_id_no', $id)
        ->where('status', '!=', 'approved') 
        ->get();

    return view('students.student_profile', compact('student', 'studentBorrowHistory', 'studentReservations', 'studentFacilityReservations'))
        ->with('title', 'Student Profile');
}
    public function addStudentPost(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|digits:8|unique:students,id', 
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNotNull('faculty_id')->orWhereNotNull('student_id');
                }),
            ],
            'course' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);
        $office = Office::where('type', '=', 'department')->first();
        $officeId = $office ? $office->id : null;
        
        Students::create([
            'id' => $data['id'],
            'firstname' => ucwords(strtolower($data['firstname'])),
            'lastname' => ucwords(strtolower($data['lastname'])),
            'gender' => $data['gender'],
            'email' => $data['email'],
            'course' => strtoupper($data['course']), 
            'department' => ucwords($data['department']), 
        ]);
        
        User::create([
            'student_id' => $data['id'] ?? null,
            'designation_id' => 3,
            'office_id' => $officeId,
            'image' => 'images/profile_pictures/default-profile.png',
            'firstname' => ucwords(strtolower($data['firstname'])),
            'lastname' => ucwords(strtolower($data['lastname'])),
            'email' => $data['email'],
            'password' => bcrypt($data['id']), // Default password (should be updated by the user later)
            'type' => 'student', // Assign role as 'student'
            'status' => 'active',
            'mobile_no' => 'none', // Optional: Link to the Student ID
        ]);
        
        

        return redirect('/add-student')->with('success', 'Student added successfully.');
    }

    public function studentDashboard(){
        $student = Auth::user(); // Get the authenticated student
    
        
        // Fetch the student's reservations
        $studentReservations = FacilityReservation::with('facility')->where('reservers_id_no', $student->student_id)->get();
    
        // Return the view with student data and reservations
        $data = [
            'student' => $student,
            'studentReservations' => $studentReservations, // Include the reservations data
            'title' => 'Student Dashboard',
        ];
    
        return view('students.student_dashboard', $data);
    }

    // public function profile($student_id)
    // {
    //     $student = Students::findOrFail($student_id);
    //     $studentBorrowHistory = Borrower::with('equipment')->where('borrowers_id_no', $student_id)->get();
    //     $studentReservations = Reservation::with('equipment')->where('student_id', $student_id)->get();
        
    //     if (!$student) {
    //         abort(404); 
    //     }

    //     return view('students.student_profile', compact('student', 'studentBorrowHistory', 'studentReservations'))
    //         ->with('title', 'Student Profile');
    // }
}
