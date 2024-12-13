<?php

namespace App\Imports;

use App\Models\Office;
use App\Models\Students;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Validators\Failure;

class StudentsImport implements 
    ToModel, 
    WithHeadingRow, 
    SkipsOnError, 
    SkipsOnFailure,
    WithValidation,
    WithEvents

{
    use Importable, 
        SkipsErrors,
        SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public $totalRows = -1;
    protected $department;

    public function __construct($department = null)
    {
        HeadingRowFormatter::default('none');
        $this->department = $department;
    }

    public function model(array $row)
    {   
        Log::info('Row data:', $row);  // Log each row's data for debugging

        $userType = Auth::user()->type;
        $department = null;
        $officeId = null;

        if ($userType == 'admin') {
            $office = Office::where('type', '=', 'department')->first();
            $officeId = $office ? $office->id : null;
            $department = ucwords($this->department);
        } elseif ($userType == 'facility manager') {
            $department = Auth::user()->office->name;
            $officeId = Auth::user()->office_id;
        }

        // Create a Student record
        $student = new Students([
            'id' => $row["ID No."] ?? null,
            'firstname' => ucwords(strtolower($row["First Name"] ?? '')),
            'lastname' => ucwords(strtolower($row["Last Name"] ?? '')),
            'gender' => $row["Gender"] ?? null,
            'email' => $row["Email"] ?? null,
            'course' => $row["Course / Year"] ?? null,
            'department' => $department,
            'overdue_count' => 0
        ]);

        // Create a User record for the Student
        $user = new User([
            'student_id' => $row["ID No."] ?? null,
            'designation_id' => 3,
            'office_id' => $officeId,
            'image' => 'images/profile_pictures/default-profile.png',
            'firstname' => $student->firstname,
            'lastname' => $student->lastname,
            'email' => $student->email,
            'password' => bcrypt($student->id), 
            'type' => 'student', 
            'status' => 'active',
            'mobile_no' => 'none', 
        ]);

        $student->save(); // Save the Student record first
        $user->save();    // Save the corresponding User record

        return $student;
    }
    
    public function rules(): array
    {
        return [
            '*.ID No\.' => ['unique:students,id'], // Target the exact header format
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.ID No..unique' => 'The ID number has already been taken.', // Customized message
        ];
    }
    
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $count) {
                $this->totalRows = $count->getReader()->getTotalRows();
            },
        ];
    }

    public function getRowCount()
    {
        return $this->totalRows;
    }


    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;    
    }
}
