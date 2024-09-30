<?php

namespace App\Http\Controllers;

use App\Models\Postulacion;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostulacionController extends Controller
{
    // Mostrar todas las postulaciones
    public function index()
    {
        $user = Auth::user();
        $postulaciones = Postulacion::where('user_id', $user->id)->with('trabajo.empresa')->get();

        return view('postulaciones.index', compact('postulaciones'));
    }

    // Crear una nueva postulación para un trabajo
    public function store(Request $request, Trabajo $trabajo)
    {
        $request->validate([
            'trabajo_id' => 'required|exists:trabajos,id',
        ]);

        // Verificar si el usuario ya se ha postulado a este trabajo
        $yaPostulado = Postulacion::where('user_id', Auth::id())
            ->where('trabajo_id', $request->trabajo_id)
            ->exists();

        if ($yaPostulado) {
            return redirect()->back()->with('error', 'Ya te has postulado a este trabajo.');
        }

        Postulacion::create([
            'user_id' => Auth::id(),
            'trabajo_id' => $request->trabajo_id,
            'estado' => 'pendiente',
        ]);

        return redirect()->back()->with('success', 'Postulación enviada exitosamente');
    }

    // Mostrar detalles de una postulación específica
    public function show(Postulacion $postulacion)
    {
        return view('postulaciones.show', compact('postulacion'));
    }

    // Actualizar el estado de una postulación
    public function update(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string',
        ]);

        $postulacion = Postulacion::findOrFail($id);
        $postulacion->update($request->only('estado'));

        return response()->json(['success' => 'Estado de la postulación actualizado']);
    }


    // Eliminar una postulación
    public function destroy(Postulacion $postulacion)
    {
        $postulacion->delete();
        return redirect()->route('postulaciones.index')->with('success', 'Postulación eliminada');
    }
}
