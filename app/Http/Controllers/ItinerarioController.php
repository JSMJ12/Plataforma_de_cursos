<?php

namespace App\Http\Controllers;

use App\Models\Itinerario;
use App\Models\Curso;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ItinerarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'tema' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);

        Itinerario::create([
            'curso_id' => $request->curso_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'tema' => $request->tema,
            'link' => $request->link,
        ]);

        return redirect()->back()->with('success', 'Itinerario creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i:s', // Incluir segundos
            'hora_fin' => 'required|date_format:H:i:s',     
            'tema' => 'required|string|max:255',
            'link' => 'nullable|url',
        ]);
    
        $itinerario = Itinerario::findOrFail($id);
        $itinerario->update([
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'tema' => $request->tema,
            'link' => $request->link,
        ]);
    
        return response()->json(['success' => 'Itinerario actualizado exitosamente.']);
    }
    
    public function edit($id)
    {
        $itinerario = Itinerario::findOrFail($id);
        return response()->json($itinerario);
    }

    public function destroy($id)
    {
        try {
            $itinerario = Itinerario::findOrFail($id);
            $itinerario->delete();

            return response()->json(['success' => 'Itinerario eliminado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar el itinerario. ' . $e->getMessage()], 500);
        }
    }


    public function itinerariosCursos($cursoId)
    {
        $curso = Curso::with('itinerarios')->findOrFail($cursoId);
        $user = auth()->user();
        $isAdminOrCapacitador = $user->hasRole('Administrador') || $user->hasRole('Capacitador');

        return view('itinerarios.index', compact('curso', 'isAdminOrCapacitador'));
    }


    public function getItinerariosData(Request $request, $cursoId)
    {
        $user = auth()->user();
        $isAdminOrCapacitador = $user->hasRole('Administrador') || $user->hasRole('Capacitador');

        $itinerarios = Itinerario::where('curso_id', $cursoId)->get();

        return DataTables::of($itinerarios)
            ->addColumn('acciones', function ($itinerario) use ($isAdminOrCapacitador) {
                if ($isAdminOrCapacitador) {
                    return '<button class="btn btn-warning btn-sm" onclick="editItinerario(' . $itinerario->id . ')">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteItinerario(' . $itinerario->id . ')">Eliminar</button>';
                }
                return ''; // No mostrar acciones si no es administrador o capacitador
            })
            ->addColumn('link', function ($itinerario) {
                return '<a href="' . $itinerario->link . '" target="_blank">' . $itinerario->link . '</a>';
            })
            ->rawColumns(['acciones', 'link']) // Asegúrate de que el contenido HTML se renderiza correctamente
            ->make(true);
    }

}
