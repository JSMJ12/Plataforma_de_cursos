<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CapacitadorAccepted;
use Yajra\DataTables\DataTables; 

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::all(); 

            return DataTables::of($users)
                ->addColumn('actions', function ($user) {
                    $btn = '<a href="' . route('usuarios.show', $user->id) . '" class="btn btn-info btn-sm">Ver</a> ';
                    if ($user->titulo !== null && $user->getRoleNames()->isEmpty()) {
                        $btn .= '<a href="' . route('usuarios.accept', $user->id) . '" class="btn btn-primary btn-sm">Aceptar</a> ';
                    }
                    return $btn;
                })
                ->addColumn('roles', function ($user) {
                    return $user->getRoleNames()->implode(', ');
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('usuarios.index');
    }

    public function accept($id)
    {

        $user = User::find($id);

        if ($user) {
            // Generar una contraseña temporal
            $password = Str::random(8);
            $user->password = Hash::make($password);
            
            // Generar y guardar un token de login
            $loginToken = Str::random(60);
            $user->login_token = $loginToken;
            
            $user->assignRole('Capacitador');
            $user->aprovado = true;
            $user->save();

            // Enviar la notificación al usuario
            Notification::send($user, new CapacitadorAccepted($user, $password, $loginToken));

            return redirect()->route('usuarios.index')->with('success', 'Capacitador aceptado y notificado exitosamente.');
        }

        return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado');
    }

    public function changePermission(Request $request)
    {

        $user = User::findOrFail($request->id);
        
        if ($user->hasRole('Capacitador')) {
            $user->permiso = true;
            $user->save();
            return redirect()->route('usuarios.index')->with('success', 'Permiso dado al Capacitador.');
        }
        
        // Redireccionar o devolver una respuesta
        return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado');
    }

    public function revokePermission(Request $request)
    {

        $user = User::findOrFail($request->id);
        
        if ($user->hasRole('Capacitador')) {
            $user->permiso = false;
            $user->save();
            return redirect()->route('usuarios.index')->with('success', 'Permiso revocado al Capacitador.');
        }
        
        // Redireccionar o devolver una respuesta
        return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado');
    }


    public function show($dni)
    {
        $user = User::findOrFail($dni);
        return view('usuarios.show', compact('user'));
    }

    public function create_administrador()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:20|unique:users',
            'name' => 'required|string|max:255',
            'name2' => 'string|max:255|nullable',
            'apellidop' => 'required|string|max:255',
            'apellidom' => 'string|max:255|nullable',
            'email' => 'required|string|email|max:255|unique:users',
            'ciudad' => 'string|max:255|nullable',
            'celular' => 'required|string|max:20',
            'nivel_estudio' => 'string|max:255|nullable',
            'titulo' => 'string|max:255|nullable',
            'especialidad' => 'string|max:255|nullable',
            'anos_experiencia' => 'integer|nullable',
            'edad' => 'integer|nullable',
            'sexo' => 'string|max:1|nullable',
            'interes' => 'string|max:255|nullable',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:Capacitador,Participante,Administrador,Secretario/a EPSU,Graduados',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
        ]);

        // Manejo del archivo de imagen
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('imagenes/usuarios', 'public');
        }

        $user = User::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'name2' => $request->name2,
            'apellidop' => $request->apellidop,
            'apellidom' => $request->apellidom,
            'email' => $request->email,
            'ciudad' => $request->ciudad,
            'celular' => $request->celular,
            'nivel_estudio' => $request->nivel_estudio,
            'titulo' => $request->titulo,
            'especialidad' => $request->especialidad,
            'anos_experiencia' => $request->anos_experiencia,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'interes' => $request->interes,
            'password' => Hash::make($request->password),
            'image' => $imagePath, // Guardar la ruta de la imagen
        ]);

        // Asignar el rol al usuario
        if ($request->role === 'Capacitador' || $request->role === 'Administrador' || $request->role === 'Secretario/a EPSU') {
            if (Auth::check() && Auth::user()->hasRole('Administrador')) {
                // Asignar rol de Capacitador, Administrador o Secretario/a EPSU de inmediato si es un administrador
                $user->assignRole($request->role);
                return redirect()->route('usuarios.index')->with('success', ucfirst($request->role) . ' registrado y aceptado exitosamente.');
            } else {
                // Si el rol es Secretario/a EPSU, solo guardar y mostrar mensaje, NO iniciar sesión
                if ($request->role === 'Secretario/a EPSU') {
                    $user->assignRole('Secretario/a EPSU');
                    return redirect()->route('out')->with('info', 'Su información está siendo revisada. Recibirá un correo de confirmación.');
                }
                // Si no es administrador, redirigir para revisión
                return redirect()->route('out')->with('info', 'Su información está siendo revisada. Recibirá un correo de confirmación.');
            }
        } else {
            // Para otros roles como Participante o Graduados
            $user->assignRole($request->role);
            Auth::login($user);
            return redirect()->route('inicio')->with('success', 'Usuario registrado exitosamente.');
        }
    }

    public function searchByDni(Request $request)
    {
        $dni = $request->input('dni');
        $capacitador = User::where('dni', $dni)->first();
        
        if ($capacitador) {
            return response()->json($capacitador);
        } else {
            return response()->json(null);
        }
    }

    public function uploadCV(Request $request)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = Auth::user();

        if ($user->cv) {
            Storage::delete('public/' . $user->cv);
        }

        $path = $request->file('cv')->store('cvs', 'public');

        $user->cv = $path;
        $user->save();

        return redirect()->back()->with('success', 'Tu CV ha sido subido correctamente.');
    }
}



