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
        $request->validate(['file' => 'required|file|mimes:xlsx,xls|max:2048',
                                    'department' => 'required']);
        $file = $request->file("file")->store('import');

        $import = new StudentsImport($request->input('department'));
        $import->import($file);

        $totalRows = $import->getRowCount();
        $failureCount = $import->failures()->count();

        FacadesLog::info('Import Failures: ', $import->failures()->toArray());
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