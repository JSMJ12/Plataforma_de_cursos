@extends('adminlte::page')

@section('title', 'Dashboard de Empresa')

@section('content_header')
    <h1 class="text-center">{{ $empresa->nombre }}</h1>
@stop

@section('content')
    <div class="container mt-4">  
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 company-card" style="background-color: #f8f9fa;">
                    <div class="card-body text-center">
                        <div class="company-image mb-3">
                            @if ($empresa->logo)
                                <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de {{ $empresa->nombre }}"
                                    class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                            @endif
                        </div>
                        <h2 class="font-weight-bold text-navy">{{ $empresa->nombre }}</h2>
                        <p class="text-muted">{{ $empresa->descripcion }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Teléfono:</strong> {{ $empresa->telefono }}</li>
                            <li class="list-group-item"><strong>Correo:</strong> {{ $empresa->email }}</li>
                            <li class="list-group-item"><strong>Dirección:</strong> {{ $empresa->direccion }}</li>
                        </ul>
                        <div class="mt-4">
                            <a href="#" class="btn btn-custom" data-toggle="modal"
                                data-target="#editCompanyModal">Editar Información</a>
                        </div>
                    </div>
                </div>
            </div>
            @include('modals.edit-empresa-modal')

            <!-- Postulaciones -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0" style="background-color: #e9ecef;">
                    <div class="card-header text-white" style="background-color: #003366;">
                        <h3 class="card-title">Postulaciones</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-around">
                            <div>
                                <p class="font-weight-bold">Pendientes:</p>
                                <span class="badge bg-dark">{{ $postulacionesPendientes }}</span>
                            </div>
                            <div>
                                <p class="font-weight-bold">Revisadas:</p>
                                <span class="badge bg-success">{{ $postulacionesRevisadas }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Trabajos creados -->
    </div>
@stop

@section('css')
    <link href="{{ asset('css/empresas.css') }}" rel="stylesheet">
@stop

