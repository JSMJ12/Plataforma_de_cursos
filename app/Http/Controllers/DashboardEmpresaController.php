<?php
namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Trabajo;
use Illuminate\Support\Facades\Auth;

class DashboardEmpresaController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        
        // Obtener la empresa asociada al usuario logueado
        $empresa = Empresa::where('user_id', $user->id)->firstOrFail();

        // Obtener los trabajos creados por la empresa
        $trabajos = Trabajo::where('empresa_id', $empresa->id)->get();

        // Inicializar contadores de postulaciones
        $postulacionesPendientes = 0;
        $postulacionesRevisadas = 0;

        // Recorrer trabajos para contar postulaciones
        foreach ($trabajos as $trabajo) {
            $postulacionesPendientes += $trabajo->postulaciones()->where('estado', 'pendiente')->count();
            $postulacionesRevisadas += $trabajo->postulaciones()->where('estado', 'revisado')->count();
        }

        // Calcular estadísticas adicionales (opcional)
        $totalTrabajos = $trabajos->count();
        $totalPostulaciones = $postulacionesPendientes + $postulacionesRevisadas;

        // Retornar la vista con los datos
        return view('dashboard.empresa', compact(
            'empresa', 
            'trabajos', 
            'postulacionesPendientes', 
            'postulacionesRevisadas', 
            'totalTrabajos', 
            'totalPostulaciones'
        ));
    }
}
