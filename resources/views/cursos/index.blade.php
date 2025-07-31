@extends('adminlte::page')

@section('title', 'Cursos')

@section('content_header')
    <h1>Lista de Cursos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header text-white" style="background-color: #036f1b;">
            <h3 class="card-title">Lista de Cursos</h3>
            <div class="card-tools">
                <button class="btn btn-light text-black" data-toggle="modal" data-target="#createCursoModal">
                    <i class="fas fa-laptop-code"></i> Crear Curso
                </button>
            </div>
        </div>        

        <div class="card-body table-responsive">
            <table id="cursosTable" class="table table-bordered table-striped">
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
                        <th>Organizado Por</th>
                        <th>Nombre Maestría</th>
                        <th>Imagen</th>
                        <th>Actividades</th> <!-- Nueva columna para las actividades -->
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    

    @include('modals.create-curso-modal')
    @include('modals.edit-curso-modal')
    @include('modals.add_activity-modal')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Función para manejar la visibilidad del campo "Nombre Maestría"
            function toggleNombreMaestria(modalPrefix) {
                var tipo = $(`#${modalPrefix}_tipo`).val();
                if (tipo === 'Maestría') {
                    $(`#${modalPrefix}_nombre_maestria_container`).show();
                    $(`#${modalPrefix}_coordinador_maestria_container`).show();
                } else {
                    $(`#${modalPrefix}_nombre_maestria_container`).hide();
                    $(`#${modalPrefix}_coordinador_maestria_container`).hide();
                }
            }

            // Inicializa DataTable
            $('#cursosTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('cursos.index') }}",
                    type: 'GET'
                },
                columns: [
                    { data: 'capacitador_id', name: 'capacitador_id' },
                    { 
                        data: 'estado', // Columna añadida para mostrar el estado
                        name: 'estado',
                        render: function (data) {
                            return data ? 'Finalizado' : 'Activo'; // Cambia el texto basado en el valor booleano
                        }
                    },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'descripcion', name: 'descripcion' },
                    { data: 'fecha_inicio', name: 'fecha_inicio' },
                    { data: 'fecha_fin', name: 'fecha_fin' },
                    { data: 'precio', name: 'precio' },
                    { data: 'horas_academicas', name: 'horas_academicas' },
                    { data: 'tipo', name: 'tipo' },
                    { data: 'nombre_maestria', name: 'nombre_maestria' },
                    { 
                        data: 'image', 
                        name: 'image', 
                        orderable: false, 
                        searchable: false,
                    },
                    { 
                        data: 'actividades', 
                        name: 'actividades', 
                        orderable: false, 
                        searchable: false,
                    },
                    { 
                        data: 'actions', 
                        name: 'actions', 
                        orderable: false, 
                        searchable: false
                    }
                ],
                
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });

            // Manejo del cambio en el campo de tipo en el modal de creación
            $('#create_tipo').change(function() {
                toggleNombreMaestria('create');
            });

            // Manejo del cambio en el campo de tipo en el modal de edición
            $('#edit_tipo').change(function() {
                toggleNombreMaestria('edit');
            });

            window.editCurso = function(id) {
                $.get("{{ url('cursos') }}/" + id + "/edit", function(data) {
                    $('#editCursoForm').attr('action', "{{ url('cursos') }}/" + id);
                    $('#edit_coordinador_maestria').val(data.coordinador_maestria);
                    $('#edit_nombre').val(data.nombre);
                    $('#edit_tipo_curso').val(data.tipo_curso);
                    $('#edit_descripcion').val(data.descripcion);
                    $('#edit_fecha_inicio').val(data.fecha_inicio);
                    $('#edit_fecha_fin').val(data.fecha_fin);
                    $('#edit_precio').val(data.precio);
                    $('#edit_horas_academicas').val(data.horas_academicas);
                    $('#edit_tipo').val(data.tipo);
                    $('#edit_nombre_maestria').val(data.nombre_maestria);
                    $('#edit_capacitador').val(data.capacitador_id);

                    // Mostrar la imagen actual en el modal
                    if (data.image) {
                        var imageUrl = "{{ asset('storage') }}/" + data.image;
                        $('#current_image').attr('src', imageUrl).show();
                    }

                    // Llamar a la función para mostrar/ocultar el campo basado en el valor del tipo
                    toggleNombreMaestria('edit');

                    $('#editCursoModal').modal('show');
                }).fail(function() {
                    alert('No se pudo obtener la información del curso.');
                });
            }

            window.deleteCurso = function(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¡No podrás revertir esta acción!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            };


            window.showCreateActivityModal = function(cursoId) {
                console.log('Curso ID:', cursoId); // Verificar que el ID se recibe correctamente
                $('#curso_id').val(cursoId); // Establecer el valor del campo oculto
                $('#addActivityModal').modal('show'); // Mostrar el modal
            };

        });

        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar/ocultar el campo capacitador_id basado en el rol del usuario
            var isCapacitador = @json(Auth::user()->hasRole('Capacitador'));
            var container = document.getElementById('capacitador_id_container');
            if (container) {
                if (isCapacitador) {
                    container.style.display = 'none';
                } else {
                    container.style.display = 'block';
                }
            }
        });
    </script>
@stop

