<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    public function importStudents(Request $request){
        $request->validate(['file' => 'required|mimes:xlsx,csv|max:2048']);
        
        Excel::import(new StudentsImport, $request->file('file'));

        return redirect()->back()->with('success', 'Successfully uploaded the file');
    }
}
