<div class="modal fade" id="editItinerarioModal" tabindex="-1" role="dialog" aria-labelledby="editItinerarioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #041c48; color: #fff;">
                <h5 class="modal-title" id="editActivityModalLabel">Editar Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editActivityForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_activity_tema">Tema</label>
                        <input type="text" class="form-control" id="edit_activity_tema" name="tema" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_fecha">Fecha</label>
                        <input type="date" class="form-control" id="edit_fecha" name="fecha" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_hora_inicio">Hora Inicio</label>
                        <input type="time" class="form-control" id="edit_hora_inicio" name="hora_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_hora_fin">Hora Fin</label>
                        <input type="time" class="form-control" id="edit_hora_fin" name="hora_fin" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_link">Enlace de la clase</label>
                        <input type="url" class="form-control" id="edit_link" name="link" placeholder="https://example.com" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
