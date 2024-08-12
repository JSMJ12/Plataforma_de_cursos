<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PagoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'curso_id' => 'required|exists:cursos,id',
            'monto' => 'required|numeric',
            'fecha_pago' => 'required|date',
            'archivo_comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pago = new Pago();
        $pago->usuario_id = $request->usuario_id;
        $pago->curso_id = $request->curso_id;
        $pago->monto = $request->monto;
        $pago->fecha_pago = $request->fecha_pago;

        if ($request->hasFile('archivo_comprobante')) {
            $file = $request->file('archivo_comprobante');
            $filePath = $file->store('comprobantes', 'public');
            $pago->archivo_comprobante = $filePath;
        }

        $pago->save();

        return redirect()->back()->with('success', 'Pago realizado con éxito.');
    }

    public function index()
    {
        $pagos = Pago::orderBy('created_at', 'desc')->get();
        $pagosNoValidados = Pago::where('verificado', false)->count();
        $montoRecaudado = Pago::where('verificado', true)->sum('monto');

        // Gráficos de pagos
        $pagosDiarios = Pago::where('verificado', true)->whereDate('created_at', Carbon::today())->count();
        $pagosSemanales = Pago::where('verificado', true)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $pagosMensuales = Pago::where('verificado', true)->whereMonth('created_at', Carbon::now()->month)->count();
        $pagosAnuales = Pago::where('verificado', true)->whereYear('created_at', Carbon::now()->year)->count();

        return view('dashboard.secretario_epsu', compact('pagos', 'pagosNoValidados', 'montoRecaudado', 'pagosDiarios', 'pagosSemanales', 'pagosMensuales', 'pagosAnuales'));
    }

    public function validar(Pago $pago)
    {
        $pago->verificado = true;
        $pago->save();

        return redirect()->back()->with('success', 'Pago validado con éxito.');
    }

}
