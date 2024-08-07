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
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $totalUsuarios }}</h3>
                        <p>Usuarios Generales</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{ route('usuarios.index') }}" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Caja de Usuarios Capacitadores -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalUsuariosCapacitadores }}</h3>
                        <p>Capacitadores</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-chalkboard-teacher"></i> <!-- Nuevo icono para capacitadores -->
                    </div>
                    <a href="{{ route('usuarios.capacitadores') }}" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        
    </div>
@stop
