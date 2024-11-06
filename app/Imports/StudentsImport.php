<?php

namespace App\Imports;

use App\Models\Students;
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
    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {   
        
        Log::info('Row data:', $row);  // Log each row's data for debugging

        $this->totalRows++;

        $userType = Auth::user()->type;
        if($userType == 'admin'){

            return new Students([
                'id_no' => $row["ID No."] ?? null,
                'firstname' => ucwords(strtolower($row["First Name"] ?? '')),
                'lastname' => ucwords(strtolower($row["Last Name"] ?? '')),
                'gender' => $row["Gender"] ?? null,
                'email' => $row["Email"] ?? null,
                'course' => $row["Course / Year"] ?? null,
                'department' => ["Department"] ?? null,
                
            ]);
        } elseif($userType == 'facility manager'){
            $department = Auth::user()->office->name;

            return new Students([
                'id_no' => $row["ID No."] ?? null,
                'firstname' => ucwords(strtolower($row["First Name"] ?? '')),
                'lastname' => ucwords(strtolower($row["Last Name"] ?? '')),
                'gender' => $row["Gender"] ?? null,
                'email' => $row["Email"] ?? null,
                'course' => $row["Course / Year"] ?? null,
                'department' => $department,
                
            ]);
        }
    }
    
    public function rules(): array
    {
        return [
            '*.ID No\.' => ['unique:students,id_no'], // Target the exact header format
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
