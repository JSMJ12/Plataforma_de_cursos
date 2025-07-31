<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GraduadosController extends Controller
{
    public function create()
    {
        return view('graduados.datos1'); 
    }
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
        ]);

        // Manejo del archivo de imagen
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('imagenes/usuarios', 'public');
        }
        // Crear el usuario graduado
        $user = User::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'name2' => $request->name2,
            'apellidop' => $request->apellidop,
            'apellidom' => $request->apellidom,
            'email' => $request->email,
            'ciudad' => $request->ciudad,
            'celular' => $request->celular,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
            'programa_maestria' => $request->programa_maestria,
            'fecha_graduacion' => $request->fecha_graduacion,
            'empleado_actualmente' => $request->empleado_actualmente,
            'nombre_empresa' => $request->nombre_empresa,
            'cargo_actual' => $request->cargo_actual,
            'trabajo_vinculado' => $request->trabajo_vinculado,
            'anos_experiencia_laboral' => $request->anos_experiencia_laboral,
            'empleos_desde_graduacion' => $request->empleos_desde_graduacion,
            'estudios_adicionales' => $request->estudios_adicionales,
            'desarrollo_profesional_continuo' => $request->desarrollo_profesional_continuo,
            'pertinencia_formacion' => $request->pertinencia_formacion,
            'satisfaccion_programa' => $request->satisfaccion_programa,
            'aspectos_utiles' => $request->aspectos_utiles,
            'aspectos_mejorables' => $request->aspectos_mejorables,
            'actividades_investigacion' => $request->actividades_investigacion,
            'recomendar_programa' => $request->recomendar_programa,
            'interes_capacitacion_continua' => $request->interes_capacitacion_continua,
            'temas_interes' => $request->temas_interes,
            'resolucion_problemas' => $request->resolucion_problemas,
            'comunicacion_oral' => $request->comunicacion_oral,
            'analisis' => $request->analisis,
            'creatividad' => $request->creatividad,
            'trabajo_en_equipo' => $request->trabajo_en_equipo,
        ]);
        // Asignar el rol de Graduado
        $user->assignRole('Graduados');
        Auth::login($user);
        return redirect()->route('inicio')->with('success', 'Usuario registrado exitosamente como Graduado.');
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
            'empleado_actualmente' => 'required',
            'nombre_empresa' => 'nullable|string|max:255',
            'cargo_actual' => 'nullable|string|max:255',
            'trabajo_vinculado' => 'nullable|in:totalmente,parcialmente,no',
            'anos_experiencia_laboral' => 'required|string',
            'empleos_desde_graduacion' => 'required|string',
            'estudios_adicionales' => 'required',
            'desarrollo_profesional_continuo' => 'required',
            'pertinencia_formacion' => 'required|in:totalmente,pertinente,poco_pertinente,nada_pertinente',
            'satisfaccion_programa' => 'required|integer|between:1,5',
            'aspectos_utiles' => 'nullable|string',
            'aspectos_mejorables' => 'nullable|string',
            'actividades_investigacion' => 'required',
            'recomendar_programa' => 'required',
            'interes_capacitacion_continua' => 'required',
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
