<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $menu = 'Dashboard';
        return view('dashboard.admin', compact('menu'));
    }
}
