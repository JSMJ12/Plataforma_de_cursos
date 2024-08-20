@extends('adminlte::page')

@section('title', 'Dashboard de Pagos')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard de Pagos</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h3>{{ $pagosNoValidados }}</h3>
                    <p>Pagos sin validar</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h3>${{ number_format($montoRecaudado, 2) }}</h3>
                    <p>Monto Recaudado</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8 mb-3">
            <div class="btn-group" role="group" aria-label="Visualización de pagos">
                <button id="btnDiario" type="button" class="btn btn-primary">Diario</button>
                <button id="btnMensual" type="button" class="btn btn-primary">Mensual</button>
                <button id="btnAnual" type="button" class="btn btn-primary">Anual</button>
            </div>
        </div>
    </div>
    <!-- Gráfico de pagos y tabla de pagos lado a lado -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Gráfico de Pagos</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficoPagos"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Pagos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-responsive" id="tablaPagos">
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
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        // Inicializar DataTable
        $('#tablaPagos').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });

        // Datos iniciales (Diarios)
        const data = {
            labels: @json($fechasDiarias),
            datasets: [{
                label: 'Pagos Diarios',
                data: @json($pagosDiarios),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1,
                fill: true
            }]
        };

        const config = {
            type: 'line',
            data: data,
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
