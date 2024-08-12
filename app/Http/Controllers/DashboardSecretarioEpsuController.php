<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pago;
use Carbon\Carbon;


class DashboardSecretarioEpsuController extends Controller
{   public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $pagos = Pago::orderBy('created_at', 'desc')->get();
        $pagosNoValidados = Pago::where('verificado', false)->count();
        $montoRecaudado = Pago::where('verificado', true)->sum('monto');

        // Gráficos de pagos
        $pagosDiarios = Pago::where('verificado', true)
            ->whereDate('created_at', Carbon::today())
            ->count();
        $fechasDiarias = [Carbon::today()->format('d/m/Y')];
        
        $pagosSemanales = Pago::where('verificado', true)
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        $fechasSemanales = [Carbon::now()->startOfWeek()->format('d/m/Y'), Carbon::now()->endOfWeek()->format('d/m/Y')];
        
        $pagosMensuales = Pago::where('verificado', true)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $fechasMensuales = [Carbon::now()->startOfMonth()->format('d/m/Y'), Carbon::now()->endOfMonth()->format('d/m/Y')];
        
        $pagosAnuales = Pago::where('verificado', true)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $fechasAnuales = [Carbon::now()->startOfYear()->format('d/m/Y'), Carbon::now()->endOfYear()->format('d/m/Y')];

        return view('dashboard.secretario_epsu', compact('pagos', 'pagosNoValidados', 'montoRecaudado', 'pagosDiarios', 'pagosSemanales', 'pagosMensuales', 'pagosAnuales', 'fechasDiarias', 'fechasSemanales', 'fechasMensuales', 'fechasAnuales'));
    }  

}
