@extends('layouts.app')

@section('title', 'Trabajos Disponibles')

@section('content')

    @include('modals.subir-cv-maodal')

    <div class="container mt-4">
        <h2 class="text-center mb-4">Encuentra tu trabajo ideal</h2>

        <div class="row mb-4">
            <div class="col-md-12">
                <input type="text" id="jobSearch" class="form-control" placeholder="Buscar por cualquier aspecto...">
            </div>
        </div>

        <div class="row" id="jobCards">
            @if ($trabajos->isEmpty())
                <div class="col-md-12">
                    <div class="alert alert-warning text-center" role="alert">
                        No hay trabajos disponibles para postularte en este momento. Verifica el estado de tus postulaciones o espera a que se publiquen nuevos trabajos.
                    </div>
                </div>
            @else
                @foreach ($trabajos as $trabajo)
                    <div class="col-md-4 mb-4 job-card">
                        <div class="card shadow-sm border-0" style="transition: transform 0.3s; border-radius: 15px;">
                            <div class="card-header text-center" style="background-color: #f8f9fa;">
                                @if ($trabajo->empresa->logo)
                                    <img src="{{ asset('storage/' . $trabajo->empresa->logo) }}"
                                        alt="Logo de {{ $trabajo->empresa->nombre }}" class="img-fluid rounded-circle"
                                        style="width: 100px; height: 100px;">
                                @endif
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-navy text-center font-weight-bold">{{ $trabajo->empresa->nombre }}</h5>
                                <h5 class="card-title text-navy text-center font-weight-bold">{{ $trabajo->titulo }}</h5>
                                <p class="card-text">{{ $trabajo->descripcion }}</p>
                                <ul class="list-unstyled">
                                    <li><strong>Ubicación:</strong> {{ $trabajo->ubicacion }}</li>
                                    <li><strong>Tipo de Contrato:</strong> {{ ucfirst($trabajo->tipo_contrato) }}</li>
                                    <li><strong>Salario:</strong> {{ $trabajo->salario }}</li>
                                    <li><strong>Fecha de Publicación:</strong>
                                        {{ \Carbon\Carbon::parse($trabajo->fecha_publicacion)->format('d-m-Y') }}</li>
                                    <li><strong>Fecha de Limite:</strong>
                                        {{ \Carbon\Carbon::parse($trabajo->fecha_limite)->format('d-m-Y') }}</li>
                                </ul>
                            </div>

                            @if (is_null($user->cv))
                                <div class="card-footer text-center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#uploadCVModal">
                                        Subir CV
                                    </button>
                                </div>
                            @else
                                <div class="card-footer text-center">
                                    <form id="postulateForm-{{ $trabajo->id }}"
                                        action="{{ route('postulaciones.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="trabajo_id" value="{{ $trabajo->id }}">
                                        <button type="submit" class="btn btn-primary btn-postularse"
                                            data-id="{{ $trabajo->id }}">
                                            Postularse
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Filtro de trabajos
            $('#jobSearch').on('input', function() {
                var value = $(this).val().toLowerCase();
                $('#jobCards .job-card').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
@endsection

@section('css')
    <style>
        .job-card .card {
            border-radius: 15px;
        }

        .job-card:hover .card {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>
@endsection
