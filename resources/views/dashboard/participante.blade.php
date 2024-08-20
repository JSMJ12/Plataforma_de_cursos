@extends('adminlte::page')

@section('title', 'Dashboard del Participante')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <!-- Información Personal -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning text-white text-center">
                    <h3>Perfil</h3>
                </div>
                <div class="card-body">
                    <div class="profile-picture text-center mb-3">
                        <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="Foto de perfil" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="profile-info">
                        <h4 class="text-center">{{ Auth::user()->name }} {{ Auth::user()->name2 }} {{ Auth::user()->apellidop }} {{ Auth::user()->apellidom }}</h4>
                        <hr>
                        <p><strong>ID:</strong> {{ Auth::user()->dni }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Ciudad:</strong> {{ Auth::user()->ciudad }}</p>
                        <p><strong>Celular:</strong> {{ Auth::user()->celular }}</p>
                        <p><strong>Nivel de Estudio:</strong> {{ Auth::user()->nivel_estudio }}</p>
                    </div>
                </div>
            </div>
        </div>        

        <!-- Cursos Registrados y Ver Más Cursos -->
        <div class="col-md-8">
            <div class="row">
                <!-- Cursos Registrados -->
                <div class="col-lg-6 col-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $cursosRegistrados }}</h3>
                            <p>Cursos Registrados</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                        <a href="{{ route('cursos.registrados') }}" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Cursos Finalizados -->
                <div class="col-lg-6 col-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $cursosFinalizados }}</h3>
                            <p>Cursos Finalizados</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                        <a href="{{ route('cursos.finalizados') }}" class="small-box-footer">Más info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Ver Más Cursos -->
                <div class=" col-lg-6 col-12">
                    <div class="small-box bg-primary">
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

    .card-header h2, .card-header h3 {
        margin: 0;
    }
    </style>
@stop
