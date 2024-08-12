<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables; 

class DashboardAdministradorController extends Controller
{
    public function index()
    {   
        $totalUsuarios = User::count();
        $totalUsuariosCapacitadores = User::role('Capacitador')->count();
        return view('dashboard.administrador', 
        compact('totalUsuarios', 'totalUsuariosCapacitadores'));
    }


    public function usuarios_capacitadores(Request $request)
    {
        if ($request->ajax()) {
            $capacitadores = User::whereHas('roles', function ($query) {
                $query->where('name', 'Capacitador');
            })
            ->orWhereDoesntHave('roles')
            ->get(); 

            return DataTables::of($capacitadores)
                ->addColumn('image', function ($user) {
                    $url = asset('storage/' . $user->image);
                    return '<img src="' . $url . '" alt="Foto" width="50" height="70"/>';
                })
                ->addColumn('actions', function ($user) {
                    $btn = '<a href="' . route('usuarios.show', $user->id) . '" class="btn btn-info btn-sm">Ver</a> ';
                    if ($user->titulo !== null && $user->getRoleNames()->isEmpty()) {
                        $btn .= '<a href="' . route('usuarios.accept', $user->id) . '" class="btn btn-primary btn-sm">Aceptar</a> ';
                    }
                    return $btn;
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }
        return view('capacitadores.index');
    }

}
