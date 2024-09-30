@extends('adminlte::page')

@section('title', 'Cursos Disponibles')


@section('content')

<div class="container">
    <div class="header">
        <h1>Cursos en Línea Gratuitos</h1>
        <p>Nos enorgullece presentar nuestros cursos, una oportunidad única para impulsar tu carrera en el Área de Conocimiento con un enfoque distintivo en la excelencia académica y la aplicación práctica.</p>
    </div>

    <!-- Formulario de Búsqueda -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="{{ route('cursos.todos') }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por nombre, descripción o capacitador" value="{{ request()->input('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Cursos -->
    <div class="card-container">
        @forelse($cursosActivos as $curso)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @php
                        $imageUrl = $curso->image 
                            ? asset('storage/' . $curso->image) 
                            : asset('storage/default-image.png');
                    @endphp
                    <a href="{{ route('cursos.show', $curso->id) }}">
                        <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $curso->nombre }}">
                    </a>
                    
                    @if($curso->precio == 0)
                        <div class="free-label">Gratis</div>
                    @endif
                    
                    <div class="card-body">
                        <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-info">Más Información</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-warning">
                    No se encontraron cursos disponibles para registrarse en este momento.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/cursos_todos.css') }}" rel="stylesheet">
@stop