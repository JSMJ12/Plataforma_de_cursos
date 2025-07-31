<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;

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
    public function index()
    {
        return view('home');
    }

      public function cursosTodos(Request $request)
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
}
