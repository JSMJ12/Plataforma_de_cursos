<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Ruta por defecto para redirigir después del login

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the authenticated method to redirect based on user role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('Administrador')) {
            return redirect()->route('dashboard_admin');
        } elseif ($user->hasRole('Capacitador')) {
            return redirect()->route('dashboard_capacitador');
        } elseif ($user->hasRole('Participante')) {
            return redirect()->route('dashboard_participante');
        }elseif ($user->hasRole('Secretaria')) {
            return redirect()->route('dashboard_secretario_epsu');
        }elseif ($user->hasRole('Graduados')) {
            return redirect()->route('dashboard_graduado');
        }elseif ($user->hasRole('Empresa')) {
            return redirect()->route('dashboard_empresa');
        }

        return redirect()->intended($this->redirectTo);
    }

    public function loginWithToken($token)
    {
        $user = User::where('login_token', $token)->first();

        if ($user) {
            Auth::login($user);
            
            // Limpiar el token después de iniciar sesión
            $user->login_token = null;
            $user->save();

            return redirect()->route('inicio');
        }

        return redirect()->route('login')->withErrors(['token' => 'Token de autenticación inválido.']);
    }
}