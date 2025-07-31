@extends('adminlte::page')

@section('title', 'Mis Postulaciones')

@section('content_header')
    <h1>Mis Postulaciones</h1>
@stop

@section('content')

    @if ($postulaciones->isEmpty())
        <div class="alert alert-info text-center">
            <h4>No tienes postulaciones activas.</h4>
            <p>Revisa los trabajos disponibles y postúlate a aquellos que te interesen.</p>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Postulaciones</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="postulacionesTable" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Empresa</th>
                                <th>Título del Trabajo</th>
                                <th>Estado</th>
                                <th>Fecha de Postulación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($postulaciones as $postulacion)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $postulacion->trabajo->empresa->logo) }}" alt="Logo" width="50" class="img-fluid" style="border-radius: 50%;">
                                        {{ $postulacion->trabajo->empresa->nombre }}
                                    </td>                                    
                                    <td>{{ $postulacion->trabajo->titulo }}</td>
                                    <td>
                                        @if ($postulacion->estado == 'pendiente')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> Pendiente
                                            </span>
                                        @elseif ($postulacion->estado == 'revisado')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Revisado
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Rechazado
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($postulacion->created_at)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .badge {
            font-size: 14px;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#postulacionesTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                responsive: true, 
                lengthChange: true,
                autoWidth: false,
                order: [[3, 'desc'], [0, 'asc']], 
            });
        });
    </script>
@stop
