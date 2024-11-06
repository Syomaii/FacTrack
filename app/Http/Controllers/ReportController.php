<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Borrower;
use App\Models\Maintenance;
use App\Models\Repair;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function borrowedEquipmentReports()
{
    $borrowedEquipments = Borrower::with(['equipment:id,name,brand']) 
        ->select('equipment_id', 'borrowed_date', 'returned_date', 'borrowers_name')
        ->orderBy('borrowed_date', 'desc')
        ->get()
        ->groupBy('equipment.brand');

    $reportData = $borrowedEquipments->map(function ($borrowsByBrand) {
        return $borrowsByBrand->map(function ($borrow) {
            return [
                'equipment' => $borrow->equipment,
                'borrowers_name' => $borrow->borrowers_name ?? 'N/A', 
                'times_borrowed' => $borrow->equipment->borrows->count(), 
                'last_borrowed' => $borrow->borrowed_date ?? 'N/A', 
                'last_returned' => $borrow->returned_date ?? 'N/A', 
            ];
        });
    });

    return view('reports.borrowed_equipments', compact('reportData', 'borrowedEquipments'))
        ->with('title', 'Borrowed Equipment Reports');
}

    

    public function getBorrowedEquipmentReports(Request $request)
    {
        try {
            $startDate = Carbon::parse($request->query('start'))->startOfDay();
            $endDate = Carbon::parse($request->query('end'))->endOfDay();

            // Validate the date range
            if (!$startDate || !$endDate || $startDate->greaterThan($endDate)) {
                return response()->json(['error' => 'Invalid or missing date range'], 400);
            }

            // Retrieve borrowed equipment data within the full date-time range
            $borrowedEquipments = Borrower::whereBetween('borrowed_date', [$startDate, $endDate])
                ->with('equipment') 
                ->get();

            // Group and map results
            $reportData = $borrowedEquipments->groupBy('equipment_id')->map(function ($group) {
                return [
                    'equipment_id' => $group[0]->equipment_id,
                    'equipment_name' => $group[0]->equipment->name,
                    'borrowers_name' => $group->pluck('borrowers_name')->unique()->values()->implode(', '), 
                    'last_borrowed' => $group->max('borrowed_date') ? Carbon::parse($group->max('borrowed_date'))->format('Y-m-d') : 'N/A',
                    'last_returned' => $group->max('returned_date') ? Carbon::parse($group->max('returned_date'))->format('Y-m-d') : 'N/A',
                    'times_borrowed' => $group->count(), 
                ];
            })->values();

            return response()->json($reportData);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }


    
    public function maintenancedEquipmentReports()
    {
        $maintenancedEquipments = Maintenance::with(['equipment:id,name,brand'])
            ->select('equipment_id', 'maintained_date', 'returned_date','technician', 'status', 'recommendations') 
            ->orderBy('maintained_date', 'desc')
            ->get()
        ->groupBy('equipment.brand'); 

        $reportData = $maintenancedEquipments->map(function ($maintenancesByBrand) {
            return $maintenancesByBrand->map(function ($maintenance) {
                return [
                    'equipment_id' => $maintenance->equipment->id,
                    'equipment_name' => $maintenance->equipment->name,
                    'maintained_date' => $maintenance->maintained_date ? $maintenance->maintained_date->format('Y-m-d') : 'N/A',
                    'returned_date' => $maintenance->returned_date ? $maintenance->returned_date->format('Y-m-d') : 'N/A',
                    'technician' => $maintenance->technician ?? 'N/A',
                    'status' => $maintenance->status ?? 'N/A',
                    'recommendations' => $maintenance->recommendations ?? 'N/A',
                ];
            });
        });

        return view('reports.maintenanced_equipments', compact('reportData'))
            ->with('title', 'Maintenanced Equipment Reports');
    }


    public function repairedEquipmentReports()
    {

        $repairedEquipments = Repair::with(['equipment:id,name,brand'])
        ->select('equipment_id', 'repaired_date', 'returned_date','technician', 'status', 'recommendations') 
        ->orderBy('repaired_date', 'desc')
        ->get()
         ->groupBy('equipment.brand'); 

        $reportData = $repairedEquipments->map(function ($repairsByBrand) {
        return $repairsByBrand->map(function ($repaired) {
            return [
                'equipment_id' => $repaired->equipment->id,
                'equipment_name' => $repaired->equipment->name,
                'repaired_date' => $repaired->repaired_date ? $repaired->repaired_date->format('Y-m-d') : 'N/A',
                'returned_date' => $repaired->returned_date ? $repaired->returned_date->format('Y-m-d') : 'N/A',
                'technician' => $repaired->technician ?? 'N/A',
                'status' => $repaired->status ?? 'N/A',
                'recommendations' => $repaired->recommendations ?? 'N/A',
            ];
        });
     });
        return view('reports/repaired_equipments', compact('reportData'))->with('title', 'Repaired Equipments');
    }

    public function setDateRepairedEquipmentReports(Request $request)
    {
        try {
            $startDate = Carbon::parse($request->query('start'))->startOfDay();
            $endDate = Carbon::parse($request->query('end'))->endOfDay();
    
            // Validate the date range
            if (!$startDate || !$endDate || $startDate->greaterThan($endDate)) {
                return response()->json(['error' => 'Invalid or missing date range'], 400);
            }
    
            // Retrieve repaired equipment data within the date range
            $repairedEquipments = Repair::whereBetween('repaired_date', [$startDate, $endDate])
                ->with('equipment') 
                ->get();
    
            // Group and map results
            $reportData = $repairedEquipments->groupBy('equipment_id')->map(function ($group) {
                return [
                    'equipment_id' => $group[0]->equipment_id,
                    'equipment_name' => $group[0]->equipment->name,
                    'technician' => $group[0]->technician,
                    'repaired_date' => $group->max('repaired_date') ? Carbon::parse($group->max('repaired_date'))->format('Y-m-d H:i') : 'N/A',
                    'returned_date' => $group->max('returned_date') ? Carbon::parse($group->max('returned_date'))->format('Y-m-d H:i') : 'N/A',
                    'status' => $group[0]->status, 
                    'recommendations' => $group[0]->recommendations
                ];
            })->values();
            
    
            return response()->json($reportData);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    

    public function disposedEquipmentReports(){
        return view('reports/disposed_equipments')->with('title', 'Disposed Equipments');
    }

    public function donatedEquipmentReports(){
        return view('reports/donated_equipments')->with('title', 'Donated Equipments');
    }
}
