<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function countForWidgets(){
        $userCount = User::count();

        $data = [
            'userCount' => $userCount,
            'title' => 'Dashboard'
        ];

        return $data; 

    }
}
