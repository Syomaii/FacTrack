<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function borrowedEquipmentReports(){
        return view('reports/borrowed_equipments')->with('title', 'Borrowed Equipments');
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
