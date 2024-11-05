<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;
use Laravel\Prompts\Concerns\Fallback;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Jobs\ProxyFailures;

class FileUploadController extends Controller
{
    public function importStudents(Request $request)
    {
        $file = $request->file("file")->store('import');

        $import = new StudentsImport();
        $import->import($file);
        
        // Check if there are any failures
        if ($import->failures()->isNotEmpty()) {
            FacadesLog::info('Import Failures: ', $import->failures()->toArray());
            return back()->with('failures', $import->failures());
        }
        return back()->withStatus('Successfully uploaded and imported the file.');
    }



}