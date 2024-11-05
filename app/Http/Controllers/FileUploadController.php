<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;
use Laravel\Prompts\Concerns\Fallback;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    public function importStudents(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xlsx,xls|max:2048', ]);
        $file = $request->file("file")->store('import');

        $import = new StudentsImport();
        $import->import($file);
        
        // Check if there are any failures
        if ($import->failures()->isNotEmpty()) {
            FacadesLog::info('Import Failures: ', $import->failures()->toArray());

            $failure = $import->failures();
            // dd($failure);
            session()->flash('abc', $failure);
            session()->keep(['abc']);

            // dd(session('failure'));
            // return redirect()->route('import.file');
            return view('imports.students', ['abc' => $failure, 'title' => 'Import']);

        }
        
        return redirect()->back()->with('success','Successfully uploaded and imported the file.');
    }



}