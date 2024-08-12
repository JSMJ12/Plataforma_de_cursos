<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cursosTodos(Request $request)
    {
        $user = Auth::user();

        // Obtener el término de búsqueda si existe
        $search = $request->input('search');

        // Obtener los cursos que están activos y cuya fecha de inicio es futura
        $query = Curso::where('finalizado', false)
            ->where('fecha_inicio', '>', now());

        // Si hay un término de búsqueda, filtrar los cursos por nombre, descripción o capacitador
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')
                ->orWhere('descripcion', 'like', '%' . $search . '%')
                ->orWhereHas('capacitador', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('name2', 'like', '%' . $search . '%')
                        ->orWhere('apellidop', 'like', '%' . $search . '%')
                        ->orWhere('apellidom', 'like', '%' . $search . '%');
                });
            });
        }

        // Obtener el ID de los cursos a los que el usuario ya está registrado
        $cursosRegistrados = Registro::where('usuario_id', $user->id)
            ->pluck('curso_id');

        // Filtrar cursos que no están registrados por el usuario
        $cursosActivos = $query->whereNotIn('id', $cursosRegistrados);

        // Excluir cursos creados por el capacitador actual si el usuario autenticado es un capacitador
        if ($user->capacitador_id) {
            $cursosActivos->where('capacitador_id', '!=', $user->capacitador_id);
        }

        // Obtener los cursos finales
        $cursosActivos = $cursosActivos->get();

        return view('cursos.todos', compact('cursosActivos'));
    }
}
