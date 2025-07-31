@extends('adminlte::page')

@section('title', 'Cursos Registrados')

@section('content_header')
    <h1>Cursos Registrados</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Cursos en los que estás Registrado</h3>
        </div>
        <div class="card-body">
            @if($cursos->isEmpty())
                <p>No estás registrado en ningún curso.</p>
            @else
                <table class="table table-bordered" id="cursosTable">
                    <thead>
                        <tr>
                            <th>Capacitador</th>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Precio</th>
                            <th>Horas Académicas</th>
                            <th>Imagen</th>
                            <th>Itinerario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cursos as $curso)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $curso->capacitador->image) }}" class="img-fluid rounded-circle me-2" alt="{{ $curso->capacitador->getFullNameAttribute() }}" style="max-width: 50px; max-height: 50px;">
                                        {{ $curso->capacitador->getFullNameAttribute() }}
                                    </div>
                                </td>
                                <td>{{ $curso->finalizado ? 'Finalizado' : 'Activo' }}</td>
                                <td>{{ $curso->nombre }}</td>
                                <td>{{ $curso->descripcion }}</td>
                                <td>{{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}</td>
                                <td>{{ $curso->precio > 0 ? '$' . number_format($curso->precio, 2) : 'Gratis' }}</td>
                                <td>{{ $curso->horas_academicas }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $curso->image) }}" class="img-fluid" alt="{{ $curso->nombre }}" style="max-width: 100px;">
                                </td>
                                <td>
                                    <a href="{{ route('itinerarios.cursos', ['id' => $curso->id]) }}" class="btn btn-info">Ver Itinerario</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class=" col-lg-6 col-12">
        <div class="small-box bg-primary">
            <a href="{{ route('cursos.todos') }}" class="small-box-footer">Ver Más Cursos <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    @push('js')
    <script>
        $(document).ready(function() {
            $('#cursosTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });

    </script>
    @endpush
@stop
