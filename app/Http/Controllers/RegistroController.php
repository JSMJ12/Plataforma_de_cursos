<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Registro;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'tipo_participante' => 'required|string',
        ]);

        // Verificar si existe un pago verificado para este usuario y curso
        $pagoVerificado = \App\Models\Pago::where('usuario_id', Auth::id())
            ->where('curso_id', $request->curso_id)
            ->where('verificado', true)
            ->exists();

        if (!$pagoVerificado) {
            return redirect()->back()->with('error', 'Debe tener un pago verificado para registrarse en este curso.');
        }

        Registro::create([
            'curso_id' => $request->curso_id,
            'usuario_id' => Auth::id(),
            'tipo_participante' => $request->tipo_participante,
        ]);

        return redirect()->route('cursos.registrados')->with('success', 'Registrado en el curso exitosamente.');
    }

    public function aprobarCurso(Request $request)
    {
        try {
            // Buscar el registro
            $registro = Registro::find($request->input('registro_id'));

            if ($registro) {
                // Marcar el registro como aprobado
                $registro->aprobado = true;
                $registro->save();

                $usuario = $registro->usuario;
                $curso = $registro->curso;

                // Convertir las fechas en objetos Carbon
                $fechas = $curso->itinerarios->pluck('fecha')->map(function($fecha) {
                    return \Carbon\Carbon::createFromFormat('Y-m-d', $fecha);
                });

                // Agrupar fechas por mes
                $fechasAgrupadas = $fechas->groupBy(function($fecha) {
                    return $fecha->format('m');
                });

                // Formatear fechas
                $fechasFormateadas = $fechasAgrupadas->map(function($fechasMes, $key) {
                    $mes = \Carbon\Carbon::create()->month($key)->locale('es_ES')->translatedFormat('F');
                    $dias = $fechasMes->map(function($fecha) {
                        return $fecha->day;
                    })->unique()->sort()->values();

                    $diasFormateados = $dias->map(function($dia) {
                        return $dia;
                    })->toArray();

                    if (count($diasFormateados) === 1) {
                        $resultado = $diasFormateados[0];
                    } else {
                        $ultimo = array_pop($diasFormateados);
                        $resultado = implode(', ', $diasFormateados);
                        $resultado .= ' y ' . $ultimo;
                    }

                    return $resultado . ' de ' . $mes;
                })->implode(', ');

                $nombreArchivo = $usuario->name . '_' . $usuario->apellidop . '_' . $curso->id . '.pdf';
                $rutaArchivo = 'certificados/participantes/' . $nombreArchivo;
                $urlCertificado = url(Storage::url($rutaArchivo));
                $qrCode = QrCode::format('png')
                    ->size(100)
                    ->eye('circle')
                    ->gradient(24, 115, 108, 33, 68, 59, 'diagonal')
                    ->errorCorrection('H')
                    ->generate($urlCertificado);

                $pdf = Pdf::loadView('certificados.participantes', compact('usuario', 'qrCode', 'curso', 'fechasFormateadas'))
                    ->setPaper('a4', 'landscape')
                    ->setOption('margin-top', 0)
                    ->setOption('margin-bottom', 0)
                    ->setOption('margin-left', 0)
                    ->setOption('margin-right', 0)
                    ->setOption('disable-smart-shrinking', true);
                Storage::disk('public')->put($rutaArchivo, $pdf->output());

                return response()->json([
                    'message' => 'Participante aprobado exitosamente.',
                ]);
            }

            return response()->json(['message' => 'Registro no encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al generar el certificado: ' . $e->getMessage()], 500);
        }
    }

}
