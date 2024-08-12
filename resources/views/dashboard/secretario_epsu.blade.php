@extends('adminlte::page')

@section('title', 'Dashboard de Pagos')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard de Pagos</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h3>{{ $pagosNoValidados }}</h3>
                    <p>Pagos sin validar</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h3>${{ number_format($montoRecaudado, 2) }}</h3>
                    <p>Monto Recaudado</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <canvas id="graficoDiario"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="graficoSemanal"></canvas>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <canvas id="graficoMensual"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="graficoAnual"></canvas>
        </div>
    </div>

    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Curso</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Comprobante</th>
                <th>Validado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
            <tr>
                <td>{{ $pago->id }}</td>
                <td>{{ $pago->usuario->name }}</td>
                <td>{{ $pago->curso->nombre }}</td>
                <td>${{ number_format($pago->monto, 2) }}</td>
                <td>{{ $pago->fecha_pago }}</td>
                <td><a href="{{ asset('storage/'.$pago->archivo_comprobante) }}" target="_blank">Ver Comprobante</a></td>
                <td>{{ $pago->verificado ? 'Sí' : 'No' }}</td>
                <td>
                    @if(!$pago->verificado)
                    <form action="{{ route('pagos.validar', $pago) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Validar</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos de ejemplo, debes reemplazar estos datos con los datos reales que envíes desde el controlador
        const pagosDiarios = @json($pagosDiarios);
        const pagosSemanales = @json($pagosSemanales);
        const pagosMensuales = @json($pagosMensuales);
        const pagosAnuales = @json($pagosAnuales);

        const fechasDiarias = @json($fechasDiarias); // Fechas para pagos diarios
        const fechasSemanales = @json($fechasSemanales); // Fechas para pagos semanales
        const fechasMensuales = @json($fechasMensuales); // Fechas para pagos mensuales
        const fechasAnuales = @json($fechasAnuales); // Fechas para pagos anuales

        // Gráfico Diario
        const ctxDiario = document.getElementById('graficoDiario').getContext('2d');
        new Chart(ctxDiario, {
            type: 'line',
            data: {
                labels: fechasDiarias,
                datasets: [{
                    label: 'Pagos Diarios',
                    data: pagosDiarios,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico Semanal
        const ctxSemanal = document.getElementById('graficoSemanal').getContext('2d');
        new Chart(ctxSemanal, {
            type: 'line',
            data: {
                labels: fechasSemanales,
                datasets: [{
                    label: 'Pagos Semanales',
                    data: pagosSemanales,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico Mensual
        const ctxMensual = document.getElementById('graficoMensual').getContext('2d');
        new Chart(ctxMensual, {
            type: 'line',
            data: {
                labels: fechasMensuales,
                datasets: [{
                    label: 'Pagos Mensuales',
                    data: pagosMensuales,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gráfico Anual
        const ctxAnual = document.getElementById('graficoAnual').getContext('2d');
        new Chart(ctxAnual, {
            type: 'line',
            data: {
                labels: fechasAnuales,
                datasets: [{
                    label: 'Pagos Anuales',
                    data: pagosAnuales,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

@stop