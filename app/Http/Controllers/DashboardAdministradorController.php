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
        return view(
            'dashboard.administrador',
            compact('totalUsuarios', 'totalUsuariosCapacitadores')
        );
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

    public function usuarios_graduados(Request $request)
    {
        if ($request->ajax()) {
            // Obtener graduados con rol de "Graduados"
            $graduados = User::whereHas('roles', function ($query) {
                $query->where('name', 'Graduados'); // Asegúrate de que el nombre del rol es correcto
            })->get();

            return DataTables::of($graduados)
                ->addColumn('image', function ($user) {
                    $url = asset('storage/' . $user->image);
                    return '<img src="' . $url . '" alt="Foto" width="50" height="70"/>';
                })
                ->addColumn('actions', function ($user) {
                    $btn = '<a href="' . route('usuarios.show', $user->id) . '" class="btn btn-info btn-sm">Ver</a>';
                    return $btn;
                })
                ->rawColumns(['image', 'actions'])
                ->make(true);
        }

        // Cálculo de indicadores de evaluación
        $total_graduados = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Asegúrate de que el nombre del rol es correcto
        })->count();


        // Tasa de Empleo
        $empleados = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Filtrar por Graduados
        })->where('empleado_actualmente', 'Sí')->count(); // Cambiado a 'Sí'
        $tasa_empleo = ($total_graduados > 0) ? ($empleados / $total_graduados) * 100 : 0;

        // Relevancia del Empleo
        $trabajo_relacionado = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Filtrar por Graduados
        })->whereIn('trabajo_vinculado', ['totalmente', 'parcialmente'])
            ->where('empleado_actualmente', 'Sí') // Agregar condición para empleado actual
            ->count();

        $no_relacionado = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Filtrar por Graduados
        })->where('trabajo_vinculado', 'no')->count(); // No relacionado

        $relevancia_empleo = ($empleados > 0) ? ($trabajo_relacionado / $empleados) * 100 : 0;


        // Contar graduados en cada rango de experiencia
        $experiencia_rangos = [
            'Menos de 1 año' => User::whereHas('roles', function ($query) {
                $query->where('name', 'Graduados');
            })->where('anos_experiencia_laboral', 'Menos_de_1')->count(),

            '1-3 años' => User::whereHas('roles', function ($query) {
                $query->where('name', 'Graduados');
            })->where('anos_experiencia_laboral', '1-3')->count(),

            '4-6 años' => User::whereHas('roles', function ($query) {
                $query->where('name', 'Graduados');
            })->where('anos_experiencia_laboral', '4-6')->count(),

            '7-10 años' => User::whereHas('roles', function ($query) {
                $query->where('name', 'Graduados');
            })->where('anos_experiencia_laboral', '7-10')->count(),

            'Más de 10 años' => User::whereHas('roles', function ($query) {
                $query->where('name', 'Graduados');
            })->where('anos_experiencia_laboral', 'Mas_de_10')->count(),
        ];

        // Continuidad en la Formación
        // Contar graduados que tienen estudios adicionales
        $estudios_adicionales = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Filtrar por Graduados
        })->where('estudios_adicionales', 'Sí')->count();

        // Contar graduados que no tienen estudios adicionales
        $no_estudios_adicionales = $total_graduados - $estudios_adicionales;

        // Calcular porcentaje (esto es opcional si solo necesitas la cantidad)
        $continuidad_formacion = ($total_graduados > 0) ? ($estudios_adicionales / $total_graduados) * 100 : 0;


        // Satisfacción con el Programa
        $satisfaccion_promedio = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Filtrar por Graduados
        })->avg('satisfaccion_programa');

        // Pertinencia
        $pertinencia_formacion = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Filtrar por Graduados
        })->whereIn('pertinencia_formacion', ['totalmente', 'pertinente'])->count(); // Relacionados

        $no_pertinencia = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Filtrar por Graduados
        })->whereIn('pertinencia_formacion', ['poco_pertinente', 'nada_pertinente'])->count(); // No relacionado

        $pertinencia_formacion_p = ($total_graduados > 0) ? ($pertinencia_formacion / $total_graduados) * 100 : 0;

        // Desarrollo Profesional Continuo
        // Contar graduados que tienen desarrollo profesional continuo
        $desarrollo_profesional_continuo = User::whereHas('roles', function ($query) {
            $query->where('name', 'Graduados'); // Filtrar por Graduados
        })->where('desarrollo_profesional_continuo', 'Sí')->count();

        // Contar graduados que no tienen desarrollo profesional continuo
        $no_desarrollo_profesional_continuo = $total_graduados - $desarrollo_profesional_continuo;

        // Calcular porcentaje (opcional)
        $porcentaje_desarrollo_profesional = ($total_graduados > 0) ? ($desarrollo_profesional_continuo / $total_graduados) * 100 : 0;

        // Enviar indicadores a la vista
        return view('graduados.index', compact(
            'empleados',
            'total_graduados',
            'tasa_empleo',
            'trabajo_relacionado',
            'no_relacionado',
            'relevancia_empleo',
            'experiencia_rangos',
            'estudios_adicionales',
            'no_estudios_adicionales',
            'continuidad_formacion',
            'satisfaccion_promedio',
            'pertinencia_formacion',
            'no_pertinencia',
            'pertinencia_formacion_p',
            'desarrollo_profesional_continuo',
            'no_desarrollo_profesional_continuo',
            'porcentaje_desarrollo_profesional',
        ));
    }
}
