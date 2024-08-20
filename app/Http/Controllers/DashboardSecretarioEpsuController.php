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

    // Pagos diarios (últimos 7 días)
    $pagosDiarios = [];
    $fechasDiarias = [];
    for ($i = 6; $i >= 0; $i--) {
        $fecha = Carbon::today()->subDays($i);
        $pagosDiarios[] = Pago::where('verificado', true)
            ->whereDate('created_at', $fecha)
            ->sum('monto');
        $fechasDiarias[] = $fecha->format('d/m/Y');
    }

    // Pagos mensuales (últimos 12 meses)
    $pagosMensuales = [];
    $fechasMensuales = [];
    for ($i = 11; $i >= 0; $i--) {
        $fecha = Carbon::now()->subMonths($i);
        $pagosMensuales[] = Pago::where('verificado', true)
            ->whereMonth('created_at', $fecha->month)
            ->whereYear('created_at', $fecha->year)
            ->sum('monto');
        $fechasMensuales[] = $fecha->format('m/Y');
    }

    // Pagos anuales (últimos 5 años)
    $pagosAnuales = [];
    $fechasAnuales = [];
    for ($i = 4; $i >= 0; $i--) {
        $fecha = Carbon::now()->subYears($i);
        $pagosAnuales[] = Pago::where('verificado', true)
            ->whereYear('created_at', $fecha->year)
            ->sum('monto');
        $fechasAnuales[] = $fecha->format('Y');
    }

    return view('dashboard.secretario_epsu', compact(
        'pagos', 
        'pagosNoValidados', 
        'montoRecaudado', 
        'pagosDiarios', 
        'pagosMensuales', 
        'pagosAnuales', 
        'fechasDiarias', 
        'fechasMensuales', 
        'fechasAnuales'
    ));
}


}
