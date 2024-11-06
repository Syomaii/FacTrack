<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Borrower;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $studentsIdNo = Students::where('department', $department)->pluck('id_no');
        $totalStudents = Students::where('department', $department)->count();
        $start = ($students->currentPage() - 1) * $students->perPage() + 1;
        $end = min($start + $students->perPage() - 1, $totalStudents);
    
        return view('students.view_students_by_department', compact('students', 'studentsIdNo', 'department', 'totalStudents', 'start', 'end'))
            ->with('title', 'Students in ' . $department);
    }
    
    public function search(Request $request)
    {
        $query = $request->input('search');
        $students = Students::where('firstname', 'like', "%$query%")
                            ->orWhere('lastname', 'like', "%$query%")
                            ->orWhere('email', 'like', "%$query%")
                            ->orWhere('course', 'like', "%$query%")
                            ->paginate(10);

        $department = $students->isNotEmpty() ? $students->first()->department : null;


        return view('students.view_students_by_department', [
            'students' => $students,
            'department' => $department, // Pass the department variable
            'totalStudents' => $students->total(), // You may want to update this
            'start' => ($students->currentPage() - 1) * $students->perPage() + 1,
            'end' => min(($students->currentPage() - 1) * $students->perPage() + $students->perPage(), $students->total())
        ])->with('title', 'Search Results');
    }

    public function studentProfile($id_no)
    {
        $student = Students::where('id_no', $id_no)->first();
        $studentBorrowHistory = Borrower::with('equipment')->where('borrowers_id_no', $id_no)->get();

        if (!$student) {
            abort(404); // Or handle no student found
        }

        return view('students.student_profile', compact('student', 'studentBorrowHistory'))->with('title', 'Student Profile');
    }
}
