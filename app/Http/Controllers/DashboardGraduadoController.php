<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Registro;
use App\Models\Asistencia;

class DashboardGraduadoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener la cantidad de cursos registrados por el usuario
        $cursosRegistrados = Registro::where('usuario_id', $user->id)->count();

        // Obtener la cantidad de cursos finalizados en los que el usuario está registrado
        $cursosFinalizados = Registro::where('usuario_id', $user->id)
            ->whereHas('curso', function ($query) {
                $query->where('finalizado', true);
            })
            ->count();

        // Obtener los registros, asistencias y pagos del usuario
        $registros = Registro::where('usuario_id', $user->id)->get();
        $asistencias = Asistencia::where('usuario_id', $user->id)->get();

        return view('dashboard.graduado', compact('registros', 'asistencias', 'cursosRegistrados', 'cursosFinalizados'));
    }
}
