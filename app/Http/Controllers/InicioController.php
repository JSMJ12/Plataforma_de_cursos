<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    public function redireccionarDashboard()
    {
        // Verificar si el usuario no está autenticado
        if (!auth()->check()) {
            return redirect()->route('login'); // Redirigir al login si no está autenticado
        }

        // Redirigir según el rol del usuario autenticado
        if (auth()->user()->hasRole('Administrador')) {
            return redirect()->route('dashboard_admin');
        } elseif (auth()->user()->hasRole('Capacitador')) {
            return redirect()->route('dashboard_capacitador');
        } elseif (auth()->user()->hasRole('Participante')) {
            return redirect()->route('dashboard_participante');
        } elseif (auth()->user()->hasRole('Secretario/a EPSU')) {
            return redirect()->route('dashboard_secretario_epsu');
        } elseif (auth()->user()->hasRole('Graduados')) {
            return redirect()->route('dashboard_graduado');
        }elseif (auth()->user()->hasRole('Empresa')) {
            return redirect()->route('dashboard_empresa');
        }

        // Opcional: si no se encuentra un rol, puedes redirigir a una página por defecto o a un error
        return redirect()->route('login'); // Redirigir por defecto al login
    }
}
