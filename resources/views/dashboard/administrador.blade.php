@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Caja de Usuarios Generales -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info"> <!-- Cambiado a bg-info -->
                    <div class="inner">
                        <h3>{{ $totalUsuarios }}</h3>
                        <p>Usuarios Generales</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{ route('usuarios.index') }}" class="small-box-footer">Más info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success"> <!-- bg-success -->
                    <div class="inner">
                        <h3>{{ $totalUsuariosCapacitadores }}</h3>
                        <p>Capacitadores</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-chalkboard-teacher"></i>
                    </div>
                    <a href="{{ route('usuarios.capacitadores') }}" class="small-box-footer">Más info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning"> <!-- bg-warning -->
                    <div class="inner">
                        <h3>{{ $totalUsuariosGraduados }}</h3>
                        <p>Graduados</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <a href="{{ route('usuarios.graduados') }}" class="small-box-footer">Más info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger"> <!-- bg-danger -->
                    <div class="inner">
                        <h3>{{ $totalUsuariosSecretarios }}</h3>
                        <p>Secretarios EPSU</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-tie"></i>
                    </div>
                    <a href="{{ route('usuarios.secretarios') }}" class="small-box-footer">Más info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary"> <!-- bg-primary -->
                    <div class="inner">
                        <h3>{{ $totalUsuariosEmpresarios }}</h3>
                        <p>Empresas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('empresas.index') }}" class="small-box-footer">Más info <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Usuarios Nuevos</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="usuariosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')
    <script>
        const ctx = document.getElementById('usuariosChart').getContext('2d');
        const usuariosChart = new Chart(ctx, {
            type: 'line', // Puedes cambiar a 'bar' si lo prefieres
            data: {
                labels: {!! json_encode($dias) !!}, // Cambiar por $meses o $anios para otros gráficos
                datasets: [{
                    label: 'Usuarios Creado por Día',
                    data: {!! json_encode($totalesPorDia) !!}, // Cambiar por $totalesPorMes o $totalesPorAnio para otros gráficos
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop
