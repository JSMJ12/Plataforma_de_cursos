<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Asistencia;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Verificar si el usuario tiene el rol de 'Capacitador'
        if ($user->hasRole('Capacitador')) {
            $cursoId = $request->query('curso_id');

            // Obtener el curso con itinerarios y registros asociados
            $curso = Curso::where('id', $cursoId)
                ->with(['itinerarios', 'registros.usuario'])
                ->firstOrFail();

            // Obtener asistencias existentes para el curso
            $asistencias = Asistencia::whereIn('usuario_id', $curso->registros->pluck('usuario_id'))
                ->whereIn('itinerario_id', $curso->itinerarios->pluck('id'))
                ->get()
                ->groupBy('usuario_id');

            return view('asistencias.index', compact('curso', 'asistencias'));
        } else {
            return redirect()->route('home')->with('error', 'No tienes acceso a esta sección.');
        }
    }

    public function store(Request $request)
    {
        // Obtener el curso desde la base de datos
        $cursoId = $request->input('curso_id');
        $curso = Curso::with(['registros', 'itinerarios'])->findOrFail($cursoId);
        
        // Obtener las asistencias del formulario
        $asistencias = $request->input('asistencias', []);

        // Si $asistencias es null, algo está fallando en el envío del formulario
        if (is_null($asistencias)) {
            return redirect()->back()->withErrors('No se recibieron las asistencias.');
        }

        // Iterar sobre todos los usuarios y sus itinerarios en el curso
        foreach ($curso->registros as $registro) {
            foreach ($curso->itinerarios as $itinerario) {
                // Verificar si hay asistencia marcada
                $asistio = isset($asistencias[$registro->usuario_id][$itinerario->id]) 
                    ? (bool)$asistencias[$registro->usuario_id][$itinerario->id] 
                    : false;

                // Actualizar o crear el registro de asistencia
                Asistencia::updateOrCreate(
                    [
                        'itinerario_id' => $itinerario->id,
                        'usuario_id' => $registro->usuario_id,
                    ],
                    ['asistio' => $asistio]
                );
            }
        }

        return redirect()->route('asistencias.index', ['curso_id' => $cursoId])
            ->with('success', 'Asistencias actualizadas exitosamente.');
    }

}
