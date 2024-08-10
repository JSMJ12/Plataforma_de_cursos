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

        return redirect()->route('participante.cursos')->with('success', 'Registrado en el curso exitosamente.');
    }

}
