<?php

namespace App\Imports;

use App\Models\Students;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    private $current = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->current++;
        if($this->current > 5){
            $count = Students::where('email', '=', $row[7])->count();
            if(empty($count)){
                $student = new Students;
                $student->id_no = $row[1];
                $student->firstname = $row[3];
                $student->lastname = $row[2];
                $student->gender = $row[5];
                $student->email = $row[7];
                $student->course = $row[4];
                $student->department = "College of Computer Studies";
                $student->save();
            }
        }
    }
}
