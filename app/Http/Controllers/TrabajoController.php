<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class TrabajoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Encuentra la empresa del usuario logueado
        $empresa = Empresa::where('user_id', $user->id)->first();

        // Si la empresa existe, obtén los trabajos asociados
        $trabajos = $empresa ? $empresa->trabajos : [];

        return view('trabajos.index', compact('empresa', 'trabajos'));
    }

    public function trabajos_todos()
    {
        $user = Auth::user();

        // Obtener los trabajos a los que el usuario NO está postulado
        $trabajos = Trabajo::where('fecha_limite', '>=', now())
            ->whereDoesntHave('postulaciones', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();

        return view('trabajos.trabajos_todos', compact('trabajos', 'user'));
    }

    // Guardar un nuevo trabajo
    public function store(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'titulo' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|in:fijo,temporal,practicante',
            'salario' => 'nullable|numeric',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'fecha_publicacion' => 'required|date',
            'fecha_limite' => 'required|date|after_or_equal:fecha_publicacion',
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        // Crear el trabajo
        Trabajo::create([
            'titulo' => $request->titulo,
            'ubicacion' => $request->ubicacion,
            'tipo_contrato' => $request->tipo_contrato,
            'salario' => $request->salario,
            'descripcion' => $request->descripcion,
            'requisitos' => $request->requisitos,
            'fecha_publicacion' => $request->fecha_publicacion,
            'fecha_limite' => $request->fecha_limite,
            'empresa_id' => $request->empresa_id, // Se asocia la empresa
        ]);

        // Redirigir a la lista de trabajos con un mensaje de éxito
        return redirect()->route('dashboard_empresa')->with('success', 'Trabajo creado exitosamente');
    }

    public function create()
    {
        return view('trabajos.create');
    }

    // Mostrar el formulario de edición
    public function edit(Trabajo $trabajo)
    {
        return view('trabajos.edit', compact('trabajo'));
    }

    public function update(Request $request, Trabajo $trabajo)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'tipo_contrato' => 'required|string|in:fijo,temporal,practicante',
            'salario' => 'nullable|numeric',
            'descripcion' => 'required|string',
            'requisitos' => 'required|string',
            'fecha_publicacion' => 'required|date',
            'fecha_limite' => 'required|date|after_or_equal:fecha_publicacion',
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        $trabajo->update($request->all());

        return redirect()->route('dashboard_empresa')->with('success', 'Trabajo actualizado exitosamente');
    }

    // Eliminar un trabajo
    public function destroy(Trabajo $trabajo)
    {
        $trabajo->delete();
        return redirect()->route('dashboard_empresa')->with('success', 'Trabajo eliminado exitosamente');
    }

    public function getPostulaciones($id)
    {
        $trabajo = Trabajo::with('postulaciones.usuario')->findOrFail($id);

        $postulaciones = $trabajo->postulaciones->map(function ($postulacion) {
            return [
                'id' => $postulacion->id,
                'estado' => $postulacion->estado,
                'user' => [
                    'name' => $postulacion->usuario->full_name,
                    'imagen' => $postulacion->usuario->image,
                ],
                'cv' => $postulacion->usuario->cv,
            ];
        });

        return response()->json($postulaciones);
    }
}
