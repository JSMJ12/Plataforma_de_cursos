@extends('adminlte::page')

@section('title', 'Dashboard de Empresa')

@section('content_header')
    <h1 class="text-center text-primary font-weight-bold">{{ $empresa->nombre }}</h1>
@stop

@section('content')
<div class="container mt-4">  
    <div class="row">
        <!-- Información de la Empresa -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 company-card bg-light">
                <div class="card-body text-center">
                    <div class="company-image mb-3">
                        @if ($empresa->logo)
                            <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de {{ $empresa->nombre }}"
                                 class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                        @endif
                    </div>
                    <h2 class="font-weight-bold text-dark">{{ $empresa->nombre }}</h2>
                    <p class="text-muted">{{ $empresa->descripcion }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Teléfono:</strong> {{ $empresa->telefono }}</li>
                        <li class="list-group-item"><strong>Correo:</strong> {{ $empresa->email }}</li>
                        <li class="list-group-item"><strong>Dirección:</strong> {{ $empresa->direccion }}</li>
                    </ul>
                    <div class="mt-4">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editCompanyModal">Editar Información</a>
                    </div>
                </div>
            </div>
        </div>
        @include('modals.edit-empresa-modal')

        <!-- Postulaciones -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-header text-white" style="background-color: #003366;">
                    <h3 class="card-title text-center">Postulaciones</h3>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-around">
                        <div>
                            <p class="font-weight-bold text-danger">Pendientes:</p>
                            <a href="#" class="badge bg-dark" style="font-size: 1.2rem;">
                                {{ $postulacionesPendientes }}
                            </a>
                        </div>
                        <div>
                            <p class="font-weight-bold text-success">Revisadas:</p>
                            <a href="#" class="badge bg-success" style="font-size: 1.2rem;">
                                {{ $postulacionesRevisadas }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link href="{{ asset('css/empresas.css') }}" rel="stylesheet">
@stop
