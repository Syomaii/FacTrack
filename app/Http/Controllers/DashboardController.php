<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function countForWidgets(){
        $count = User::count();

        $data = [
            'count' => $count,
            'title' => 'Dashboard'
        ];

        return $data; 

    }
}
