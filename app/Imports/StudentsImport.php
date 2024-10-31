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

class StudentsImport implements 
    ToModel, 
    WithHeadingRow, 
    SkipsOnError, 
    WithValidation, 
    WithBatchInserts, 
    WithChunkReading+
{
    use Importable, 
        SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        return new Students([
            'id_no' => $row[trim("ID No.")] ?? null,
            'firstname' => $row[trim("First Name")] ?? null,
            'lastname' => $row[trim("Last Name")] ?? null,
            'gender' => $row[trim("Gender")] ?? null,
            'email' => $row[trim("Email")] ?? null,
            'course' => $row[trim("Course / Year")] ?? null,
            'department' => "College of Computer Studies",
        ]);
    }
    
    public function rules(): array
    {
        return [
            '*.email' => ['email', 'unique:students,email']
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
