<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardEmpresaController extends Controller
{
    public function index()
    {
        return view('dashboard.empresa');
    }
}
