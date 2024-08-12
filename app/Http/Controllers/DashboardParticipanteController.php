<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Registro;
use App\Models\Asistencia;
use App\Models\Pago;

class DashboardParticipanteController extends Controller
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

        return view('dashboard.participante', compact('registros', 'asistencias', 'cursosRegistrados', 'cursosFinalizados'));
    }


    public function cursosParticipantes(Request $request)
    {
        $user = Auth::user();

        // Obtener el término de búsqueda si existe
        $search = $request->input('search');

        // Obtener los cursos que están activos y cuya fecha de inicio es futura
        $query = Curso::where('finalizado', false)
            ->where('fecha_inicio', '>', now());

        // Si hay un término de búsqueda, filtrar los cursos por nombre o descripción
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')
                ->orWhere('descripcion', 'like', '%' . $search . '%');
            });
        }

        $cursosActivos = $query->get();

        return view('welcome', compact('cursosActivos'));
    }

    public function cursosRegistrados()
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirige a la página de inicio de sesión si no está autenticado
        }

        $user = Auth::user();
        $cursos = $user->registros()->with('curso.capacitador')->get()->pluck('curso');

        return view('cursos.registrados', compact('cursos'));
    }

}