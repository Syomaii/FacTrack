<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Laravel\Prompts\Concerns\Fallback;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Jobs\ProxyFailures;

class FileUploadController extends Controller
{
    public function importStudents(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv|max:2048']);

        $import = new StudentsImport();
        try {
            $import->import($request->file('file'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error importing the file: ' . $e->getMessage()]);
        }

        if ($import->failures()->isNotEmpty()) {
            return redirect()->back()->withErrors($import->failures());
        }

        return redirect()->back()->with('success', 'Successfully uploaded and imported the file.');
    }

}