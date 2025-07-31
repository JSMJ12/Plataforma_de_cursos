@extends('adminlte::page')

@section('title', 'Dashboard Capacitador')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <!-- Información Personal -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-header bg-success text-white text-center border-0">
                        <h3>Perfil</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="Foto de perfil" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <div class="text-center">
                            <h4 class="mb-3">{{ Auth::user()->name }} {{ Auth::user()->name2 }} {{ Auth::user()->apellidop }} {{ Auth::user()->apellidom }}</h4>
                            <p class="mb-1"><strong>ID:</strong> {{ Auth::user()->dni }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p class="mb-1"><strong>Ciudad:</strong> {{ Auth::user()->ciudad }}</p>
                            <p class="mb-1"><strong>Celular:</strong> {{ Auth::user()->celular }}</p>
                            <p class="mb-1"><strong>Especialidad:</strong> {{ Auth::user()->especialidad }}</p>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-8">
                <div class="row">
                    <!-- Cursos Registrados -->
                    <div class="col-lg-6 col-12">       
                        <div class="small-box bg-info text-white">
                            <div class="inner">
                                <h3>{{ $cursosRegistrados }}</h3>
                                <p>Cursos Registrados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <a href="{{ route('cursos.registrados') }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12"> 
                        <div class="small-box bg-success text-white">
                            <div class="inner">
                                <h3>{{ $cursosFinalizados }}</h3>
                                <p>Cursos Finalizados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <a href="{{ route('cursos.finalizados') }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12"> 
                        <div class="small-box bg-warning text-dark">
                            <div class="inner">
                                <h3>{{ $cursosCreados->count() }}</h3>
                                <p>Cursos Creados</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <a href="{{ route('cursos.index') }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12"> 
                        <div class="small-box bg-primary text-white">
                            <div class="inner">
                                <h3>Ver Más</h3>
                                <p>Explorar Cursos</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                            <a href="{{ route('cursos.todos') }}" class="small-box-footer">Ver Más Cursos <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
    .profile-picture img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .profile-info h4 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .card {
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff; /* Fondo blanco para las tarjetas */
    }

    .card-header {
        border-bottom: 1px solid #ddd;
        padding: 1rem;
    }

    .card-body {
        padding: 1rem;
    }

    .small-box {
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff; /* Fondo blanco para las small-box */
        color: #333; /* Color de texto por defecto */
    }

    .small-box .inner {
        padding: 10px;
    }

    .small-box .icon {
        color: #fff;
    }

    .small-box-footer {
        display: block;
        padding: 10px;
        color: #fff;
        text-align: center;
        background: rgba(0,0,0,0.1);
        border-top: 1px solid #ddd;
    }

    .small-box-footer:hover {
        background: rgba(0,0,0,0.2);
    }
    </style>
@stop
