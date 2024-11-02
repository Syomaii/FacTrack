<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Borrower;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function borrowedEquipmentReports()
    {
        $borrowedEquipments = Equipment::whereHas('borrows')
            ->with(['borrows' => function ($query) {
                $query->select('equipment_id', 'borrowed_date', 'returned_date')
                    ->orderBy('borrowed_date', 'desc');
            }])
            ->get()
            ->groupBy('model');
    
        $reportData = $borrowedEquipments->map(function ($equipments) {
            // Grouped by model, calculate the brand count within each group
            $brandCounts = $equipments->pluck('brand')->countBy();
    
            return $equipments->map(function ($equipment) use ($brandCounts) {
                return [
                    'equipment' => $equipment,
                    'brand_count' => $brandCounts[$equipment->brand] ?? 0,
                    'times_borrowed' => $equipment->borrows->count(),
                    'last_borrowed' => optional($equipment->borrows->first())->borrowed_date ?? 'N/A',
                    'last_returned' => optional($equipment->borrows->first())->returned_date ?? 'N/A',
                ];
            });
        });
    
        return view('reports.borrowed_equipments', compact('reportData', 'borrowedEquipments'))
            ->with('title', 'Borrowed Equipment Reports');
    }
    

    public function getBorrowedEquipmentReports(Request $request)
    {
        try {
            $startDate = Carbon::parse($request->query('start'));
            $endDate = Carbon::parse($request->query('end'));
    
            if (!$startDate || !$endDate || $startDate->greaterThan($endDate)) {
                return response()->json(['error' => 'Invalid or missing date range'], 400);
            }
    
            // Retrieve borrowed equipment data within the full date-time range
            $borrowedEquipments = Borrower::whereBetween('borrowed_date', [$startDate, $endDate])
                ->with('equipment') // Eager load equipment relationship
                ->get();
    
            // Group and map results
            $reportData = $borrowedEquipments->groupBy('equipment_id')->map(function ($group) {
                return [
                    'equipment_id' => $group[0]->equipment_id,
                    'equipment_name' => $group[0]->equipment->name,
                    'quantity' => $group->countBy('equipment.brand')->values()->sum(), // Count by brand
                    'last_borrowed' => $group->max('borrowed_date') ? Carbon::parse($group->max('borrowed_date'))->format('Y-m-d H:i') : 'N/A',
                    'last_returned' => $group->max('returned_date') ? Carbon::parse($group->max('returned_date'))->format('Y-m-d H:i') : 'N/A',
                    'times_borrowed' => $group->count(), // Total times borrowed
                ];
            })->values();
    
            return response()->json($reportData);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
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
