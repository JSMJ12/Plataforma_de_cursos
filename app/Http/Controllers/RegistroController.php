<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Registro;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'tipo_participante' => 'required|string',
        ]);

        Registro::create([
            'curso_id' => $request->curso_id,
            'usuario_id' => Auth::id(),
            'tipo_participante' => $request->tipo_participante,
        ]);

        return redirect()->route('cursos.registrados')->with('success', 'Registrado en el curso exitosamente.');
    }

    public function aprobarCurso(Request $request)
    {
        $registro = Registro::find($request->input('registro_id'));

        if ($registro) {
            $registro->aprobado = true;
            $registro->save();

            return response()->json(['message' => 'Curso aprobado exitosamente.']);
        }

        return response()->json(['message' => 'Registro no encontrado.'], 404);
    }


}
