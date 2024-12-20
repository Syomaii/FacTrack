<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\FacultiesImport;
use App\Imports\StudentsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Laravel\Prompts\Concerns\Fallback;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    public function importStudents(Request $request)
    {
        $userType = Auth::user()->type;
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls|max:2048',
                'department' => $userType === 'admin' ? 'required|string' : 'nullable|string',

            ]);
            Log::info('File validation passed');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors());
        }
        
        $file = $request->file("file")->store('import');

        $import = new StudentsImport($request->input('department'));
        $import->import($file);

        $totalRows = $import->getRowCount();
        $failureCount = $import->failures()->count();

        Log::info('Import Failures: ', $import->failures()->toArray());
        if ($failureCount === $totalRows) {
            return redirect()->back()->with('error', 'All the IDs are taken.');
        } elseif ($failureCount > 0 && $failureCount < $totalRows) {
            return redirect()->back()->with('success', 'Successfully uploaded and imported the file with some duplicates skipped.');
        }elseif($failureCount === 0){
            return redirect()->back()->with('success', 'Successfully uploaded and imported the file.');
        }

        // If no rows failed, show a full success message
    }

    public function importFaculties(Request $request)
    {
        $userType = Auth::user()->type;

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:2048',
            'department' => $userType === 'admin' ? 'required|string' : 'nullable|string',
        ]);
        $file = $request->file("file")->store('import');

        $import = new FacultiesImport($request->input('department'));
        $import->import($file);

        $totalRows = $import->getRowCount();
        $failureCount = $import->failures()->count();

        Log::info('Import Failures: ', $import->failures()->toArray());
        if ($failureCount === $totalRows) {
            return redirect()->back()->with('error', 'All the IDs are taken.');
        } elseif ($failureCount > 0 && $failureCount < $totalRows) {
            return redirect()->back()->with('success', 'Successfully uploaded and imported the file with some duplicates skipped.');
        }elseif($failureCount === 0){
            return redirect()->back()->with('success', 'Successfully uploaded and imported the file.');
        }

        // If no rows failed, show a full success message
    }

}