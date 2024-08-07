$(document).ready(function() {
    // Función para manejar la visibilidad del campo "Nombre Maestría"
    function toggleNombreMaestria(modalPrefix) {
        var tipo = $(`#${modalPrefix}_tipo`).val();
        if (tipo === 'Maestría') {
            $(`#${modalPrefix}_nombre_maestria_container`).show();
        } else {
            $(`#${modalPrefix}_nombre_maestria_container`).hide();
        }
    }

    // Inicializa DataTable
    $('#cursosTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: cursosIndexUrl,
        columns: [
            { data: 'nombre', name: 'nombre' },
            { data: 'descripcion', name: 'descripcion' },
            { data: 'fecha_inicio', name: 'fecha_inicio' },
            { data: 'fecha_fin', name: 'fecha_fin' },
            { data: 'precio', name: 'precio' },
            { data: 'horas_academicas', name: 'horas_academicas' },
            { data: 'tipo', name: 'tipo' },
            { data: 'nombre_maestria', name: 'nombre_maestria' },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'actividades', name: 'actividades', orderable: false, searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
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
        $.get(cursosEditUrl.replace(':id', id), function(data) {
            $('#editCursoForm').attr('action', cursosUpdateUrl.replace(':id', id));
            $('#edit_nombre').val(data.nombre);
            $('#edit_descripcion').val(data.descripcion);
            $('#edit_fecha_inicio').val(data.fecha_inicio);
            $('#edit_fecha_fin').val(data.fecha_fin);
            $('#edit_precio').val(data.precio);
            $('#edit_horas_academicas').val(data.horas_academicas);
            $('#edit_tipo').val(data.tipo);
            $('#edit_nombre_maestria').val(data.nombre_maestria);
            
            // Mostrar la imagen actual en el modal
            var imageUrl = storagePath.replace(':file', data.image);
            $('#edit_image').siblings('img').attr('src', imageUrl).show();
            
            // Llamar a la función para mostrar/ocultar el campo basado en el valor del tipo
            toggleNombreMaestria('edit'); 
            
            $('#editCursoModal').modal('show');
        });
    }

    window.deleteCurso = function(id) {
        if (confirm('¿Está seguro de que desea eliminar este curso?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // Función para editar actividades
    window.editActivity = function(activityId) {
        $.get(itinerariosEditUrl.replace(':id', activityId), function(data) {
            $('#editActivityForm').attr('action', itinerariosUpdateUrl.replace(':id', activityId));
            $('#edit_activity_name').val(data.name);
            $('#edit_activity_description').val(data.description);
            $('#editActivityModal').modal('show');
        });
    }

    window.showActivities = function(cursoId) {
        $.get(cursosActivitiesUrl.replace(':id', cursoId), function(data) {
            // Mostrar actividades en la vista
            var activitiesList = '';
            data.forEach(function(activity) {
                activitiesList += `<li>
                    <span>${activity.name}</span>
                    <button class="btn btn-info btn-sm" onclick="editActivity(${activity.id})">Editar</button>
                </li>`;
            });
            $('#activitiesList').html(activitiesList);
            $('#activitiesModal').modal('show');
        });
    }
});
