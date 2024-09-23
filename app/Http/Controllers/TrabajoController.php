<?php

namespace App\Http\Controllers;

use App\Models\Trabajo;
use App\Models\Empresa;
use Illuminate\Http\Request;

class TrabajoController extends Controller
{
    // Mostrar todos los trabajos
    public function index()
    {
        $trabajos = Trabajo::all();
        return view('trabajos.index', compact('trabajos'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        $empresas = Empresa::all(); // Listar las empresas disponibles
        return view('trabajos.create', compact('empresas'));
    }

    // Guardar un nuevo trabajo
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'salario' => 'nullable|numeric',
            'empresa_id' => 'required|exists:empresas,id', // Verificar que la empresa exista
        ]);

        Trabajo::create($request->all());

        return redirect()->route('trabajos.index')->with('success', 'Trabajo creado exitosamente');
    }

    // Mostrar un trabajo específico
    public function show(Trabajo $trabajo)
    {
        return view('trabajos.show', compact('trabajo'));
    }

    // Mostrar el formulario de edición
    public function edit(Trabajo $trabajo)
    {
        $empresas = Empresa::all();
        return view('trabajos.edit', compact('trabajo', 'empresas'));
    }

    // Actualizar un trabajo
    public function update(Request $request, Trabajo $trabajo)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'salario' => 'nullable|numeric',
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        $trabajo->update($request->all());

        return redirect()->route('trabajos.index')->with('success', 'Trabajo actualizado exitosamente');
    }

    // Eliminar un trabajo
    public function destroy(Trabajo $trabajo)
    {
        $trabajo->delete();
        return redirect()->route('trabajos.index')->with('success', 'Trabajo eliminado exitosamente');
    }
}
