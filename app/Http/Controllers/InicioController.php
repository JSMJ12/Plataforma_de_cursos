<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    public function redireccionarDashboard()
    { 
         if (auth()->user()->hasRole('Administrador')) {
            return redirect()->route('dashboard_admin');
        } elseif (auth()->user()->hasRole('Capacitador')) {
            return redirect()->route('dashboard_capacitador');
        } elseif (auth()->user()->hasRole('Participante')) {
            return redirect()->route('dashboard_participante');
        }elseif ($user->hasRole('Secretaria')) {
            return redirect()->route('dashboard_secretario_epsu');
        }
    }
}
