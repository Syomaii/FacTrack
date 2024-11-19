<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function reserveEquipment(){
        return view('students.reserve_equipment')->with('title', 'Reserve Equipment');
    }
}
