@extends('adminlte::page')

@section('title', 'Asistencias')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center font-weight-bold text-success">
        Registro de Asistencias
    </h1>

    <form id="asistencias-form" method="POST" action="{{ route('asistencias.store') }}">
        @csrf
        <input type="hidden" name="curso_id" value="{{ $curso->id }}">

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white text-center">
                        <h3 class="card-title font-weight-bold">{{ $curso->nombre }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="asistencias-table">
                                <thead style="background-color: #e9f7ef;">
                                    <tr>
                                        <th>Usuario</th>
                                        @foreach($curso->itinerarios as $itinerario)
                                            <th>{{ \Carbon\Carbon::parse($itinerario->fecha)->format('d/m/Y') }}</th>
                                        @endforeach
                                        <th>Aprobado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($curso->registros as $registro)
                                        <tr>
                                            <td>
                                                {{ $registro->usuario->name }} {{ $registro->usuario->name2 }} {{ $registro->usuario->apellidop }} {{ $registro->usuario->apellidom }}
                                            </td>
                                            @php
                                                $totalAsistencias = $curso->itinerarios->count();
                                                $asistenciasCompletadas = 0;
                                            @endphp
                                            @foreach($curso->itinerarios as $itinerario)
                                                <td class="text-center">
                                                    @php
                                                        $asistenciasUsuario = $asistencias->get($registro->usuario_id, collect());
                                                        $asistencia = $asistenciasUsuario->firstWhere('itinerario_id', $itinerario->id);
                                                        if ($asistencia && $asistencia->asistio) {
                                                            $asistenciasCompletadas++;
                                                        }
                                                    @endphp

                                                    <div class="form-group">
                                                        <input 
                                                            type="checkbox" 
                                                            name="asistencias[{{ $registro->usuario_id }}][{{ $itinerario->id }}]" 
                                                            value="1"
                                                            {{ $asistencia && $asistencia->asistio ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                            @endforeach
                                            <td class="text-center">
                                                @if($asistenciasCompletadas === $totalAsistencias)
                                                    <button type="button" class="btn btn-outline-success aprobar-curso" 
                                                            data-registro-id="{{ $registro->id }}"
                                                            {{ $registro->aprobado ? 'disabled' : '' }}>
                                                        <i class="fas fa-check"></i> Aprobado
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save"></i> Guardar Asistencias
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.aprobar-curso').forEach(function(button) {
        button.addEventListener('click', function() {
            let registroId = this.getAttribute('data-registro-id');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, aprobar curso!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('{{ route("aprobacion") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ registro_id: registroId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            Swal.fire(
                                'Aprobado!',
                                data.message,
                                'success'
                            );

                            // Recargar la página
                            setTimeout(() => {
                                location.reload();
                            }, 1000); // Esperar un segundo antes de recargar
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            'No se pudo aprobar el curso.',
                            'error'
                        );
                        console.error('Error:', error);
                    });
                }
            });
        });
    });
});


</script>
@stop
