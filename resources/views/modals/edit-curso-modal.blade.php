<!-- Modal para editar curso -->

<div class="modal fade" id="editCursoModal" tabindex="-1" role="dialog" aria-labelledby="editCursoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #041c48; color: #fff;">
                <h5 class="modal-title" id="editCursoModalLabel">Editar Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCursoForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_tipo_curso">Tipo de Evento</label>
                        <input type="text" name="tipo_curso" id="edit_tipo_curso" class="form-control" placeholder="Curso, Seminario, Otros" required>
                    </div>  
                    <div class="form-group">
                        <label for="edit_nombre">Nombre</label>
                        <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_descripcion">Descripción</label>
                        <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_fecha_inicio">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="edit_fecha_inicio" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_fecha_fin">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="edit_fecha_fin" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_precio">Precio</label>
                        <input type="number" name="precio" id="edit_precio" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_horas_academicas">Horas Académicas</label>
                        <input type="number" name="horas_academicas" id="edit_horas_academicas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tipo">Creado por</label>
                        <select name="tipo" id="edit_tipo" class="form-control" required>
                            <option value="Instituto">Instituto</option>
                            <option value="Maestría">Maestría</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_capacitador">Capacitador</label>
                        <select name="capacitador_id" id="edit_capacitador" class="form-control" required>
                            <option value="">Seleccione un capacitador</option>
                            @foreach($capacitadores as $capacitador)
                                <option value="{{ $capacitador->id }}">{{ $capacitador->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="edit_nombre_maestria_container" style="display: none;">
                        <label for="edit_nombre_maestria">Nombre Maestría</label>
                        <input type="text" name="nombre_maestria" id="edit_nombre_maestria" class="form-control">
                    </div>
                    <div class="form-group" id="edit_coordinador_maestria_container" style="display: none;">
                        <label for="edit_coordinador_maestria">Nombre del Cordinador de la Maestría</label>
                        <input type="text" name="coordinador_maestria" id="edit_coordinador_maestria" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_image">Imagen Promocional</label>
                        <input type="file" name="image" id="edit_image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar Curso</button>
                </form>
            </div>
        </div>
    </div>
</div>