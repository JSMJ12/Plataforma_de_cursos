<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use App\Models\Registro;
use App\Models\Itinerario;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();

            // Verificar si el usuario tiene el rol de 'Capacitador'
            if ($user->hasRole('Capacitador')) {
                // Obtener solo los cursos creados por el usuario autenticado
                $cursos = Curso::where('capacitador_id', $user->id)->with('itinerarios')->get();
            } else {
                // Obtener todos los cursos
                $cursos = Curso::with('itinerarios')->get();
            }

            return DataTables::of($cursos)
                ->addColumn('capacitador_dni', function ($curso) {
                    return $curso->capacitador ? $curso->capacitador->dni : 'No asignado';
                })
                ->addColumn('estado', function ($curso) {
                    return (int) $curso->finalizado;
                })
                ->addColumn('actions', function ($curso) use ($user) {
                    // Botón para finalizar o reactivar curso
                    $finalizarButton = $curso->finalizado
                        ? '<form action="' . route('cursos.reactivar', $curso->id) . '" method="POST" style="display: inline;">
                                ' . csrf_field() . '
                                ' . method_field('PUT') . '
                                <button type="submit" class="btn btn-outline-success btn-sm" title="Reactivar">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>'
                        : '<form action="' . route('cursos.finalizar', $curso->id) . '" method="POST" style="display: inline;">
                                ' . csrf_field() . '
                                ' . method_field('PUT') . '
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Finalizar">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </form>';

                    // Botón para tomar lista
                    $takeAttendanceButton = $user->hasRole('Capacitador') && !$curso->finalizado
                        ? '<a href="' . route('asistencias.index', ['curso_id' => $curso->id]) . '" class="btn btn-warning btn-sm" title="Tomar Lista">
                                <i class="fas fa-list"></i>
                            </a>'
                        : '';

                    // Botón para editar
                    $editButton = '
                        <button class="btn btn-info btn-sm" title="Editar" onclick="editCurso(' . $curso->id . ')">
                            <i class="fas fa-edit"></i>
                        </button>
                    ';
                    
                    // Botón para eliminar
                    $deleteButton = '
                        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="deleteCurso(' . $curso->id . ')">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-' . $curso->id . '" action="' . route('cursos.destroy', $curso->id) . '" method="POST" style="display: none;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                        </form>
                    ';
                    
                    // Concatenar y retornar los botones
                    return '
                        <div class="btn-group" style="gap: 5px;">
                            ' . $editButton . '
                            ' . $finalizarButton . '
                            ' . $takeAttendanceButton . '
                            ' . $deleteButton . '
                        </div>
                    ';
                })
                ->editColumn('image', function ($curso) {
                    if ($curso->image) {
                        $url = asset('storage/' . $curso->image);
                        return '<img src="' . $url . '" alt="Imagen" width="50" height="50"/>';
                    } else {
                        return '<img src="' . asset('storage/default-image.png') . '" alt="Imagen" width="50" height="50"/>';
                    }
                })
                ->addColumn('actividades', function ($curso) {
                    // Usar el ID del curso para construir la URL
                    $url = route('itinerarios.cursos', ['id' => $curso->id]);

                    // Botón para agregar actividad
                    $addActivityButton = '
                        <button class="btn btn-success btn-sm" title="Agregar Actividad" onclick="showCreateActivityModal(' . $curso->id . ')">
                            <i class="fas fa-plus"></i>
                        </button>
                    ';

                    // Enlace para ver actividades
                    $verActividades = '
                        <a href="' . $url . '" class="btn btn-info btn-sm" title="Ver Actividades">
                            <i class="fas fa-eye"></i>
                        </a>
                    ';

                    // Concatenar y retornar los botones
                    return $addActivityButton . ' ' . $verActividades;
                })
                ->rawColumns(['actions', 'image', 'actividades'])
                ->make(true);
        }

        $capacitadores = User::role('Capacitador')->get();
        return view('cursos.index', compact('capacitadores'));
    }

    
    public function show($id)
    {
        if (!auth()->check()) {
            // Si el usuario no está autenticado, redirige a la vista de login
            return redirect()->route('login')->with('message', 'Por favor, inicie sesión para ver más detalles.');
        }
        $curso = Curso::findOrFail($id);
        $user = Auth::user();
        $userRegistered = Registro::where('curso_id', $id)
            ->where('usuario_id', Auth::id())
            ->exists();

        $paymentCompleted = Pago::where('usuario_id', $user->id)
        ->where('curso_id', $curso->id)
        ->exists();
        

        // Obtener los itinerarios del curso ordenados por fecha y hora de inicio
        $itinerarios = Itinerario::where('curso_id', $curso->id)
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        // Retornar la vista con el curso y sus itinerarios
        return view('cursos.show', compact('curso', 'itinerarios', 'userRegistered', 'paymentCompleted'));
    }

    public function edit($id)
    {
        try {
            // Encuentra el curso
            $curso = Curso::findOrFail($id);
    
            return response()->json([
                'tipo_curso' => $curso->tipo_curso,
                'nombre' => $curso->nombre,
                'coordinador_maestria' => $curso->coordinador_maestria,
                'descripcion' => $curso->descripcion,
                'fecha_inicio' => $curso->fecha_inicio,
                'fecha_fin' => $curso->fecha_fin,
                'precio' => $curso->precio,
                'horas_academicas' => $curso->horas_academicas,
                'tipo' => $curso->tipo,
                'nombre_maestria' => $curso->nombre_maestria,
                'image' => $curso->image,
                'capacitador_id' => $curso->capacitador_id
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Curso no encontrado. ' . $e->getMessage()], 500);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'capacitador_id' => 'required|exists:users,id',
            'nombre' => 'required|string|max:255',
            'tipo_curso' => 'required|string|max:255',
            'coordinador_maestria' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'precio' => 'nullable|numeric',
            'horas_academicas' => 'required|integer',
            'tipo' => 'required|in:Maestría,Instituto',
            'nombre_maestria' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (Auth::user()->hasRole('Capacitador')) {
            $capacitador_id = Auth::id(); 
        } else {
            $capacitador_id = $request->capacitador_id;
        }

        $curso = new Curso();
        $curso->nombre = $request->nombre;
        $curso->tipo_curso = $request->tipo_curso;
        $curso->coordinador_maestria = $request->coordinador_maestria;
        $curso->descripcion = $request->descripcion;
        $curso->fecha_inicio = $request->fecha_inicio;
        $curso->fecha_fin = $request->fecha_fin;
        $curso->precio = $request->precio;
        $curso->horas_academicas = $request->horas_academicas;
        $curso->tipo = $request->tipo;
        $curso->nombre_maestria = $request->nombre_maestria;
        $curso->capacitador_id = $capacitador_id; 
        // Manejar la carga de la imagen
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public', $filename);
            $curso->image = $filename;
        }

        // Guardar el curso en la base de datos
        $curso->save();

        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente.');
    }


    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);
        $request->validate([
            'capacitador_id' => 'required|exists:users,id',
            'nombre' => 'required|string|max:255',
            'tipo_curso' => 'required|string|max:255',
            'coordinador_maestria' => 'nullable|string|max:255',
            'descripcion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'precio' => 'required|numeric',
            'horas_academicas' => 'required|integer',
            'tipo' => 'required|string',
            'nombre_maestria' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Verificar si el usuario autenticado es un capacitador
        if (Auth::user()->hasRole('Capacitador')) {
            $capacitador_id = Auth::id();
        } else {
            $capacitador_id = $request->capacitador_id;;

        }

        // Manejar la imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($curso->image && file_exists(public_path('storage/' . $curso->image))) {
                unlink(public_path('storage/' . $curso->image));
            }

            // Subir la nueva imagen
            $imagePath = $request->file('image')->store('public/cursos');
            $imagePath = str_replace('public/', '', $imagePath); // Elimina 'public/' del path
            $curso->image = $imagePath;
        }

        // Actualizar los demás campos
        $curso->nombre = $request->nombre;
        $curso->tipo_curso = $request->tipo_curso;
        $curso->coordinador_maestria = $request->coordinador_maestria;
        $curso->descripcion = $request->descripcion;
        $curso->fecha_inicio = $request->fecha_inicio;
        $curso->fecha_fin = $request->fecha_fin;
        $curso->precio = $request->precio;
        $curso->horas_academicas = $request->horas_academicas;
        $curso->tipo = $request->tipo;
        $curso->nombre_maestria = $request->nombre_maestria;
        $curso->capacitador_id = $capacitador_id;
        
        $curso->save();

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado exitosamente');
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);

        // Eliminar la imagen del almacenamiento si existe
        if ($curso->image) {
            $imagePath = storage_path('app/public/' . $curso->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Eliminar el curso de la base de datos
        $curso->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado exitosamente.');
    }

    public function finalizarCurso($id)
    {
        $curso = Curso::find($id);

        if ($curso) {
            $curso->finalizado = true;
            $curso->save();

            return redirect()->back()->with(['success' => 'Curso finalizado con éxito.']);
        } else {
            return redirect()->back()->with(['error' => 'Curso no encontrado.'], 404);
        }
    }

    public function reactivar($id)
    {
        $curso = Curso::findOrFail($id);

        if (!$curso->finalizado) {
            return redirect()->back()->with(['message' => 'El curso ya está activo.'], 400);
        }

        $curso->finalizado = false;
        $curso->save();

        return redirect()->back()->with(['message' => 'Curso reactivado con éxito.']);
    }

}

