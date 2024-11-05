<?php

namespace App\Imports;

use App\Models\Students;
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
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Validators\Failure;

class StudentsImport implements 
    ToModel, 
    WithHeadingRow, 
    SkipsOnError, 
    SkipsOnFailure,
    WithBatchInserts, 
    WithChunkReading,
    WithValidation

{
    use Importable, 
        SkipsErrors,
        SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function model(array $row)
    {   
        Log::info('Row data:', $row);  // Log each row's data for debugging

        return new Students([
            'id_no' => $row["ID No."] ?? null,
            'firstname' => $row["First Name"] ?? null,
            'lastname' => $row["Last Name"] ?? null,
            'gender' => $row["Gender"] ?? null,
            'email' => $row["Email"] ?? null,
            'course' => $row["Course / Year"] ?? null,
            'department' => "College of Computer Studies",
        ]);
    }
    
    public function rules(): array
    {
        return [
            '*.Email' => ['email', 'unique:students,email']
        ];
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
