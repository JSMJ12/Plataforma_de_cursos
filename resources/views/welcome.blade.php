@extends('layouts.app')

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
    .carousel-container {
        width: 100%;
        overflow: hidden;
        position: relative;
    }
    .carousel-inner {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }
    .carousel-item {
        flex: 0 0 auto;
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
    }
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        position: relative;
        margin-bottom: 20px;
    }
    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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
    .carousel-control-prev, .carousel-control-next {
        width: 5%;
    }
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
    }
</style>

<div class="container">
    <div class="header">
        <h1>Cursos en Línea Gratuitos</h1>
        <p>Nos enorgullece presentar nuestros cursos, una oportunidad única para impulsar tu carrera en el Área de Conocimiento con un enfoque distintivo en la excelencia académica y la aplicación práctica.</p>
    </div>

    <div class="carousel-container">
        @if($cursosActivos->isEmpty())
            <p>No hay cursos disponibles para registrarse en este momento.</p>
        @else
            <div id="cursosCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($cursosActivos->chunk(3) as $chunk)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="row">
                                @foreach($chunk as $curso)
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            @php
                                                $imageUrl = $curso->image 
                                                    ? asset('storage/' . $curso->image) 
                                                    : asset('storage/default-image.png');
                                            @endphp
                                            <img src="{{ $imageUrl }}" class="card-img-top" alt="{{ $curso->nombre }}">
                                            
                                            @if($curso->precio == 0)
                                                <div class="free-label">Gratis</div>
                                            @endif
                                            
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $curso->nombre }}</h5>
                                                <p class="card-text">{{ Str::limit($curso->descripcion, 100) }}</p>
                                                <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-info">Más Información</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#cursosCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#cursosCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>
        @endif
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const prevButton = document.querySelector('.carousel-control-prev');
        const nextButton = document.querySelector('.carousel-control-next');
        const carouselInner = document.querySelector('#cursosCarousel .carousel-inner');
        
        prevButton.addEventListener('click', function() {
            const activeItem = carouselInner.querySelector('.carousel-item.active');
            let prevItem = activeItem.previousElementSibling;
            if (!prevItem) {
                prevItem = carouselInner.lastElementChild;
            }
            carouselInner.style.transform = 'translateX(-' + prevItem.offsetLeft + 'px)';
            activeItem.classList.remove('active');
            prevItem.classList.add('active');
        });
        
        nextButton.addEventListener('click', function() {
            const activeItem = carouselInner.querySelector('.carousel-item.active');
            let nextItem = activeItem.nextElementSibling;
            if (!nextItem) {
                nextItem = carouselInner.firstElementChild;
            }
            carouselInner.style.transform = 'translateX(-' + nextItem.offsetLeft + 'px)';
            activeItem.classList.remove('active');
            nextItem.classList.add('active');
        });
    });
</script>
@endsection
@endsection
