<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Borrower;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function borrowedEquipmentReports()
    {
        // Fetch all borrowed equipment and group by model
        $borrowedEquipments = Equipment::whereHas('borrows') // Ensure it only fetches equipment that has borrows
            ->with(['borrows' => function ($query) {
                $query->select('equipment_id', DB::raw('SUM(quantity) as total_quantity'))
                      ->groupBy('equipment_id'); // Group by equipment_id to sum quantities
            }])
            ->get()
            ->groupBy('model'); // Group by equipment model
    
        return view('reports.borrowed_equipments', compact('borrowedEquipments'))->with('title', 'Borrowed Equipment Reports');
    }

    public function maintenancedEquipmentReports(){
        return view('reports/maintenanced_equipments')->with('title', 'Maintained Equipments');
    }

    public function repairedEquipmentReports(){
        return view('reports/repaired_equipments')->with('title', 'Repaired Equipments');
    }

    public function disposedEquipmentReports(){
        return view('reports/disposed_equipments')->with('title', 'Disposed Equipments');
    }

    public function donatedEquipmentReports(){
        return view('reports/donated_equipments')->with('title', 'Donated Equipments');
    }
}
