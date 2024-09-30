<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class EmpresaController extends Controller
{
    // Mostrar todas las empresas
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $empresas = Empresa::with('usuario')->get(); 
            return DataTables::of($empresas)
                ->addColumn('logo', function ($empresa) {
                    return $empresa->logo ? '<img src="' . asset('storage/' . $empresa->logo) . '" alt="Logo" width="50">' : 'No tiene logo';
                })
                ->addColumn('usuario', function ($empresa) {
                    return $empresa->usuario ? $empresa->usuario->full_name : 'Sin encargado';
                })
                ->rawColumns(['logo'])
                ->make(true);
        }

        return view('empresas.index');
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
            'email' => 'required|email|unique:users,email',
            'email_contacto' => 'required|email|unique:empresas,email',
            'logo' => 'nullable|image|max:2048',
            'dni' => 'required|string|max:20|unique:users,dni',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
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
            'user_id' => $user->id,
        ]);

        // Loguear al usuario
        Auth::login($user);

        return redirect()->route('dashboard_empresa')->with('success', 'Empresa creada y usuario registrado exitosamente');
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

        return redirect()->route('dashboard_empresa')->with('success', 'Empresa actualizada exitosamente');
    }
}
