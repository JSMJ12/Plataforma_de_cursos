<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmpresaController extends Controller
{
    // Mostrar todas las empresas
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    // Mostrar el formulario de creación
    public function create()
    {
        return view('empresas.create');
    }

    // Guardar una nueva empresa
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:empresas,email',
            'logo' => 'nullable|image|max:2048',
            'dni' => 'required|string|max:20|unique:users,dni',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
        ]);

        // Manejo de logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Crear la empresa
        $empresa = Empresa::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'sitio_web' => $request->sitio_web,
            'logo' => $logoPath,
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('imagenes/usuarios', 'public');
        }

        // Crear el usuario asociado a la empresa
        $user = User::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'name2' => $request->name2,
            'apellidop' => $request->apellidop,
            'apellidom' => $request->apellidom,
            'email' => $request->email,
            'celular' => $request->celular,
            'password' => Hash::make($request->password),
            'image' => $imagePath, 
        ]);

        // Asignar el rol de 'Empresa' al usuario
        $user->assignRole('Empresa');

        // Loguear al usuario
        Auth::login($user);

        return redirect()->route('dashboard_empresa')->with('success', 'Empresa creada y usuario registrado exitosamente');
    }

    // Mostrar una empresa específica
    public function show(Empresa $empresa)
    {
        return view('empresas.show', compact('empresa'));
    }

    // Mostrar el formulario de edición
    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', compact('empresa'));
    }

    // Actualizar una empresa
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:empresas,email,' . $empresa->id,
            'logo' => 'nullable|image|max:2048',
        ]);

        // Manejo de logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $empresa->logo = $logoPath;
        }

        $empresa->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'sitio_web' => $request->sitio_web,
        ]);

        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada exitosamente');
    }

    // Eliminar una empresa
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada exitosamente');
    }
}
