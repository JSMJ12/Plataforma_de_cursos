<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class GraduadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function edit1($id = null)
    {
        $graduado = Auth::user();

        return view('graduados.datos', compact('graduado'));
    }

    public function update(Request $request)
    { 
        $request->validate([
            'programa_maestria' => 'required|string|max:255',
            'fecha_graduacion' => 'required|date',
            'empleado_actualmente' => 'required|in:si,no',
            'nombre_empresa' => 'nullable|string|max:255',
            'cargo_actual' => 'nullable|string|max:255',
            'trabajo_vinculado' => 'nullable|in:totalmente,parcialmente,no',
            'anos_experiencia_laboral' => 'required|string',
            'empleos_desde_graduacion' => 'required|string',
            'estudios_adicionales' => 'required|in:si,no',
            'desarrollo_profesional_continuo' => 'required|in:si,no',
            'pertinencia_formacion' => 'required|in:totalmente,pertinente,poco_pertinente,nada_pertinente',
            'satisfaccion_programa' => 'required|integer|between:1,5',
            'aspectos_utiles' => 'nullable|string',
            'aspectos_mejorables' => 'nullable|string',
            'actividades_investigacion' => 'required|in:si,no',
            'recomendar_programa' => 'required|in:si,no',
            'interes_capacitacion_continua' => 'required|in:si,no',
            'temas_interes' => 'nullable|string',
            'resolucion_problemas' => 'nullable|string|in:muy_alta,alta,media,baja,muy_baja',
            'comunicacion_oral' => 'nullable|string|in:muy_alta,alta,media,baja,muy_baja',
            'analisis' => 'nullable|string|in:muy_alta,alta,media,baja,muy_baja',
            'creatividad' => 'nullable|string|in:muy_alta,alta,media,baja,muy_baja',
            'trabajo_en_equipo' => 'nullable|string|in:muy_alta,alta,media,baja,muy_baja',
        ]);

        // Obtén el usuario autenticado
        $user = auth()->user();

        // Actualiza los campos del usuario
        $user->update($request->only([
            'programa_maestria',
            'fecha_graduacion',
            'empleado_actualmente',
            'nombre_empresa',
            'cargo_actual',
            'trabajo_vinculado',
            'anos_experiencia_laboral',
            'empleos_desde_graduacion',
            'estudios_adicionales',
            'desarrollo_profesional_continuo',
            'pertinencia_formacion',
            'satisfaccion_programa',
            'aspectos_utiles',
            'aspectos_mejorables',
            'actividades_investigacion',
            'recomendar_programa',
            'interes_capacitacion_continua',
            'temas_interes',
            'resolucion_de_problemas',
            'comunicacion_oral',
            'analisis',
            'creatividad',
            'trabajo_en_equipo',
        ]));
        return redirect()->back()->with('success', 'Datos actualizados con éxito.');
    }
}
