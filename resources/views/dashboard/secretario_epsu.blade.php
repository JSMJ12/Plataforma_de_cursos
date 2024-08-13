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

    <!-- Gráfico de pagos -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Gráficos de Pagos</h3>
                </div>
                <div class="card-body">
                    <canvas id="graficoPagos"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de pagos -->
    <div class="row">
        <div class="col-lg-12">
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
        $('#tablaPagos').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
            }
        });

        // Datos para el gráfico combinado
        const pagosDiarios = @json($pagosDiarios);
        const pagosSemanales = @json($pagosSemanales);
        const pagosMensuales = @json($pagosMensuales);
        const pagosAnuales = @json($pagosAnuales);

        const fechasDiarias = @json($fechasDiarias);
        const fechasSemanales = @json($fechasSemanales);
        const fechasMensuales = @json($fechasMensuales);
        const fechasAnuales = @json($fechasAnuales);

        // Gráfico combinado de Pagos
        const ctxPagos = document.getElementById('graficoPagos').getContext('2d');
        new Chart(ctxPagos, {
            type: 'line',
            data: {
                labels: fechasDiarias.concat(fechasSemanales).concat(fechasMensuales).concat(fechasAnuales),
                datasets: [
                    {
                        label: 'Pagos Diarios',
                        data: pagosDiarios,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Pagos Semanales',
                        data: pagosSemanales,
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Pagos Mensuales',
                        data: pagosMensuales,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Pagos Anuales',
                        data: pagosAnuales,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }
                ]
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
