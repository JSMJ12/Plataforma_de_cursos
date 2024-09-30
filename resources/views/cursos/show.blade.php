@extends('adminlte::page')

@section('title', $curso->nombre)

@section('content_header')
    <h1>{{ $curso->nombre }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Detalles del Curso</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('storage/' . $curso->image) }}" class="img-fluid" alt="{{ $curso->nombre }}">
                </div>
                <div class="col-md-8">
                    <p><strong>Descripción:</strong> {{ $curso->descripcion }}</p>
                    <p><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}</p>
                    <p><strong>Precio:</strong> {{ $curso->precio > 0 ? '$' . number_format($curso->precio, 2) : 'Gratis' }}</p>
                    
                    @if($curso->precio <= 0)
                        <!-- Mostrar botón de registro si el curso es gratuito -->
                        @if(!$userRegistered)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registroModal">
                                Registrarse
                            </button>
                        @endif
                    @elseif($paymentCompleted)
                        @if(!$userRegistered)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registroModal">
                                Registrarse
                            </button>
                        @endif
                    @else
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pagoModal">
                            Realizar Pago
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Itinerarios del Curso</h3>
        </div>
        <div class="card-body">
            @if($itinerarios->isEmpty())
                <p>No hay itinerarios disponibles para este curso.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Tema</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itinerarios as $itinerario)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($itinerario->hora_inicio)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($itinerario->hora_fin)->format('H:i') }}</td>
                                <td>{{ $itinerario->tema }}</td>
                                <td>
                                    @if($userRegistered)
                                        <a href="{{ $itinerario->link }}" target="_blank">Ir al enlace</a>
                                    @else
                                        No registrado
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @include('modals.pago-modal')
    @include('modals.registro-curso-modal')
@stop
