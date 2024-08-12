@extends('adminlte::page')

@section('title', 'Cursos Disponibles')


@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Roboto', sans-serif;
    }
    .main-content {
        margin-top: 20px;
    }
    .header {
        background: linear-gradient(to right, #1c7a24, #0b541b);
        color: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
    }

    .header h1 {
        margin-bottom: 15px;
        font-size: 2.8em;
        font-weight: bold;
    }

    .header p {
        font-size: 1.2em;
        margin-bottom: 0;
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        background-color: #fff;
        position: relative;
        margin-bottom: 20px;
    }

    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .card img {
        width: 100%;
        height: auto;
        object-fit: cover;
        object-position: center;
    }

    .card-body {
        padding: 20px;
        text-align: center;
    }

    .card-title {
        font-size: 1.5em;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .card-text {
        color: #6c757d;
        font-size: 1em;
        margin-bottom: 15px;
    }

    .btn-info {
        background-color: #2b80e8;
        border: none;
        color: white;
        border-radius: 50px;
        padding: 10px 20px;
        transition: background-color 0.3s;
        text-transform: uppercase;
        font-weight: bold;
    }

    .btn-info:hover {
        background-color: #4264f0;
    }

    .free-label {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: #f4590c;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9em;
        font-weight: bold;
        z-index: 1;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
</style>

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
