@extends('adminlte::page')

@section('title', 'Actividades del Curso')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between bg-success text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-tasks me-2"></i> Actividades del Curso: <span class="fw-bold">{{ $curso->nombre }}</span>
            </h3>
            @if(auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Capacitador'))
                <button class="btn btn-light btn-sm d-flex align-items-center gap-2" onclick="showCreateActivityModal({{ $curso->id }})">
                  Crear Actividad
                </button>
            @endif
        </div>
        
        <div class="card-body table-responsive">
            <table id="itinerariosTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Tema</th>
                        <th>Link</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se llenarán automáticamente con DataTables -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para editar actividad -->
    @include('modals.edit-activity-modal')
    @include('modals.add_activity-modal')
@stop

@section('js')
<script>
$(document).ready(function() {
    var table = $('#itinerariosTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("itinerarios.data", $curso->id) }}',
        columns: [
            { data: 'fecha', name: 'fecha' },
            { data: 'hora_inicio', name: 'hora_inicio' },
            { data: 'hora_fin', name: 'hora_fin' },
            { data: 'tema', name: 'tema' },
            { data: 'link', name: 'link' },
            { 
                data: 'acciones', 
                name: 'acciones',
                orderable: false,
                searchable: false,
            }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });

    // Función para abrir el modal y cargar los datos para editar
    window.editItinerario = function(id) {
        $.get(`/itinerarios/${id}/edit`, function(data) {
            $('#editActivityForm').attr('action', `/itinerarios/${id}`);
            $('#edit_curso_id').val(data.curso_id);
            $('#edit_activity_tema').val(data.tema);
            $('#edit_fecha').val(data.fecha);
            $('#edit_hora_inicio').val(data.hora_inicio);
            $('#edit_hora_fin').val(data.hora_fin);
            $('#edit_link').val(data.link);

            $('#editItinerarioModal').modal('show');
        }).fail(function(xhr) {
            Swal.fire('Error!', 'No se pudieron obtener los datos para editar.', 'error');
        });
    };

    // Manejar la sumisión del formulario de edición
    $('#editActivityForm').submit(function(event) {
        event.preventDefault();

        let formData = $(this).serialize();
        let url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'PUT',
            data: formData,
            success: function(response) {
                $('#editItinerarioModal').modal('hide');
                table.ajax.reload(); // Recargar los datos de la tabla
                Swal.fire('Actualizado!', response.success, 'success');
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                Swal.fire('Error!', xhr.responseJSON.error || 'No se pudo actualizar el itinerario.', 'error');
            }
        });
    });

    // Función para confirmar la eliminación con SweetAlert
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.deleteItinerario = function(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("itinerarios") }}/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire('Eliminado!', response.success, 'success');
                        table.ajax.reload(); // Recargar los datos de la tabla
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        Swal.fire('Error!', xhr.responseJSON.error || 'No se pudo eliminar el itinerario.', 'error');
                    }
                });
            }
        });
    };

    window.showCreateActivityModal = function(cursoId) {
        console.log('Curso ID:', cursoId); // Verificar que el ID se recibe correctamente
        $('#curso_id').val(cursoId); // Establecer el valor del campo oculto
        $('#addActivityModal').modal('show'); // Mostrar el modal
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar el campo capacitador_dni basado en el rol del usuario
        var isCapacitador = @json(Auth::user()->hasRole('Capacitador'));
        
        if (isCapacitador) {
            document.getElementById('capacitador_dni_container').style.display = 'none';
        } else {
            document.getElementById('capacitador_dni_container').style.display = 'block';
        }
    });
});
</script>
@stop
