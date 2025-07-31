@extends('adminlte::page')

@section('title', 'Dashboard de Pagos')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4 text-center font-weight-bold">Dashboard de Pagos</h1>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-warning text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x text-white-50"></i>
                            <i class="fas fa-exclamation-triangle fa-stack-1x text-warning"></i>
                        </span>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $pagosNoValidados }}</h3>
                        <p class="mb-0">Pagos sin validar</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-success text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x text-white-50"></i>
                            <i class="fas fa-dollar-sign fa-stack-1x text-success"></i>
                        </span>
                    </div>
                    <div>
                        <h3 class="mb-0">${{ number_format($montoRecaudado, 2) }}</h3>
                        <p class="mb-0">Monto Recaudado</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0 bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x text-white-50"></i>
                            <i class="fas fa-chart-line fa-stack-1x text-primary"></i>
                        </span>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ count($pagos) }}</h3>
                        <p class="mb-0">Pagos Totales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de pagos (ahora arriba del gráfico) -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-info text-white">
                    <h3 class="card-title mb-0"><i class="fas fa-table"></i> Listado de Pagos</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="tablaPagos" style="width:100%">
                            <thead class="thead-dark">
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
                                    <td>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-user"></i> {{ $pago->usuario->name }} {{ $pago->usuario->name2 }} {{ $pago->usuario->apellidop }} {{ $pago->usuario->apellidom }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <i class="fas fa-book"></i> {{ $pago->curso->nombre }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-dollar-sign"></i> ${{ number_format($pago->monto, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-calendar-alt"></i> {{ $pago->fecha_pago }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/'.$pago->archivo_comprobante) }}" target="_blank" class="btn btn-sm btn-outline-dark" title="Ver Comprobante">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($pago->verificado)
                                            <span class="badge badge-success"><i class="fas fa-check"></i> Sí</span>
                                        @else
                                            <span class="badge badge-danger"><i class="fas fa-times"></i> No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$pago->verificado)
                                        <form action="{{ route('pagos.validar', $pago) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Validar Pago">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled title="Pago ya validado">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de filtro del gráfico -->
    <div class="row justify-content-center mb-3 mt-4">
        <div class="col-lg-8 text-center">
            <div class="btn-group" role="group" aria-label="Visualización de pagos">
                <button id="btnDiario" type="button" class="btn btn-outline-primary" title="Ver pagos diarios">
                    <i class="fas fa-calendar-day"></i> Diario
                </button>
                <button id="btnMensual" type="button" class="btn btn-outline-primary" title="Ver pagos mensuales">
                    <i class="fas fa-calendar-alt"></i> Mensual
                </button>
                <button id="btnAnual" type="button" class="btn btn-outline-primary" title="Ver pagos anuales">
                    <i class="fas fa-calendar"></i> Anual
                </button>
            </div>
        </div>
    </div>

    <!-- Gráfico de pagos (más pequeño) -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title mb-0"><i class="fas fa-chart-area"></i> Gráfico de Pagos</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficoPagos" style="height: 200px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- FontAwesome CDN para iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        $('#tablaPagos').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            pageLength: 8,
            lengthMenu: [8, 15, 30, 50],
            order: [[ 0, "desc" ]]
        });

        // Datos iniciales (Diarios)
        const data = {
            labels: @json($fechasDiarias),
            datasets: [{
                label: 'Pagos Diarios',
                data: @json($pagosDiarios),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointRadius: 5,
                fill: true,
                tension: 0.3
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#333',
                            font: {
                                size: 16
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#fff',
                        titleColor: '#333',
                        bodyColor: '#333'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: '#333',
                            font: {
                                size: 13
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#333',
                            font: {
                                size: 13
                            }
                        }
                    }
                }
            }
        };

        // Crear gráfico
        const ctx = document.getElementById('graficoPagos').getContext('2d');
        let graficoPagos = new Chart(ctx, config);

        // Función para actualizar el gráfico
        function actualizarGrafico(labels, data, label) {
            graficoPagos.data.labels = labels;
            graficoPagos.data.datasets[0].data = data;
            graficoPagos.data.datasets[0].label = label;
            graficoPagos.update();
        }

        // Manejar clicks en los botones
        $('#btnDiario').click(function() {
            actualizarGrafico(@json($fechasDiarias), @json($pagosDiarios), 'Pagos Diarios');
        });

        $('#btnMensual').click(function() {
            actualizarGrafico(@json($fechasMensuales), @json($pagosMensuales), 'Pagos Mensuales');
        });

        $('#btnAnual').click(function() {
            actualizarGrafico(@json($fechasAnuales), @json($pagosAnuales), 'Pagos Anuales');
        });
    });
</script>
@stop
