@extends('adminlte::page')

@section('title', 'Dashboard de Empresa')

@section('content_header')
    <h1 class="text-center">{{ $empresa->nombre }} Trabajos</h1>
@stop

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white" style="background-color: #1b026a;">
                        <h3 class="card-title">Listado de Trabajos</h3>
                        <div class="card-tools">
                            <a href="{{ route('trabajos.create') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-plus"></i> Crear Nuevo Trabajo
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($trabajos->isEmpty())
                            <p>No has creado ningún trabajo todavía.</p>
                        @else
                            <div class="table-responsive">
                                <table id="trabajosTable" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr style="background-color: #08691f; color: white;">
                                            <th>Título</th>
                                            <th>Ubicación</th>
                                            <th>Tipo de Contrato</th>
                                            <th>Salario</th>
                                            <th>Fecha de Publicación</th>
                                            <th>Postulaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trabajos as $trabajo)
                                            <tr class="table-row">
                                                <td>{{ $trabajo->titulo }}</td>
                                                <td>{{ $trabajo->ubicacion }}</td>
                                                <td>{{ ucfirst($trabajo->tipo_contrato) }}</td>
                                                <td>{{ $trabajo->salario }}</td>
                                                <td>{{ \Carbon\Carbon::parse($trabajo->fecha_publicacion)->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    @if ($trabajo->postulaciones->count() > 0)
                                                        <button class="btn btn-warning" data-toggle="modal"
                                                            data-target="#postulacionesModal"
                                                            data-trabajo="{{ $trabajo->id }}"
                                                            onclick="loadPostulaciones({{ $trabajo->id }})">
                                                            {{ $trabajo->postulaciones->where('estado', '!=', 'rechazado')->count() }}
                                                        </button>
                                                    @else
                                                        <p>No hay postulaciones aún</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Botón de Editar -->
                                                    <a href="{{ route('trabajos.edit', $trabajo->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>

                                                    <!-- Botón de Eliminar -->
                                                    <form action="{{ route('trabajos.destroy', $trabajo->id) }}"
                                                        method="POST" class="d-inline-block delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm delete-button">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modals.ver-postulaciones-modal')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Inicialización de DataTable
            $('#trabajosTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-MX.json"
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": 5
                    },
                    {
                        "searchable": false,
                        "targets": 5
                    }
                ]
            });

            $('.delete-button').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminarlo!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Si el usuario confirma, se envía el formulario
                    }
                });
            });
        });
    </script>
    <script>
        // Función para cargar las postulaciones de un trabajo específico
        function loadPostulaciones(trabajoId) {
            $.ajax({
                url: '/trabajos/' + trabajoId + '/postulaciones', // Ruta para obtener las postulaciones
                type: 'GET',
                success: function(response) {
                    $('#postulacionesContent').empty();

                    // Filtrar postulaciones rechazadas
                    const filteredPostulaciones = response.filter(postulacion => postulacion.estado !==
                        'rechazado');

                    if (filteredPostulaciones.length > 0) {
                        filteredPostulaciones.forEach(function(postulacion) {
                            const isRevisado = postulacion.estado ===
                                'revisado';
                            const imagen = postulacion.user.imagen ?
                                `<img src="/storage/${postulacion.user.imagen}" alt="${postulacion.user.name}" 
                             style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">` :
                                '';
                            $('#postulacionesContent').append(`
                        <tr>
                            <td>
                                ${imagen} ${postulacion.user.name}
                            </td>
                            <td>
                                <a href="/storage/${postulacion.cv}" target="_blank" class="btn btn-info" onclick="event.stopPropagation();">Ver CV</a>
                            </td>
                            <td>
                                <button class="btn btn-success" onclick="marcarRevisado(${postulacion.id}, this)" ${isRevisado ? 'disabled' : ''}>
                                    <i class="fas fa-check"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="rechazarPostulacion(${postulacion.id})" ${isRevisado ? 'disabled' : ''}>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                        });
                    } else {
                        $('#postulacionesContent').append(
                            '<tr><td colspan="4">No hay postulaciones para este trabajo</td></tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener las postulaciones:', error);
                    $('#postulacionesContent').append(
                        '<tr><td colspan="4">Error al cargar postulaciones.</td></tr>'
                    );
                }
            });
        }


        // Función para marcar la postulación como revisada
        function marcarRevisado(postulacionId, button) {
            var url = '{{ route('postulaciones.update', ':id') }}';
            url = url.replace(':id', postulacionId);

            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    estado: 'revisado', // Aquí indicamos que es para marcar como "revisado"
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Postulación marcada como revisada.',
                    }).then(() => {
                        // Cerrar el modal
                        $('#postulacionesModal').modal('hide');
                    });
                    // Cambiar el estado del botón a deshabilitado y de color gris
                    $(button).prop('disabled', true).css('background-color', 'gray').text('Revisado');
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el estado de la postulación.',
                    });
                    console.error('Error al actualizar el estado:', error);
                }
            });
        }

        // Función para rechazar la postulación
        function rechazarPostulacion(postulacionId) {
            var url = '{{ route('postulaciones.update', ':id') }}';
            url = url.replace(':id', postulacionId);

            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    estado: 'rechazado',
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Postulación rechazada.',
                    }).then(() => {
                        // Cerrar el modal
                        $('#postulacionesModal').modal('hide');
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo rechazar la postulación.',
                    });
                    console.error('Error al actualizar el estado:', error);
                }
            });
        }
    </script>
@stop
