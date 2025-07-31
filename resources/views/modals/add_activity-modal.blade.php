<!-- Modal para agregar actividad -->
<div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #041c48; color: #fff;">
                <h5 class="modal-title" id="addActivityModalLabel">Agregar Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addActivityForm" action="{{ route('itinerarios.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="curso_id" name="curso_id">

                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_inicio">Hora Inicio</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="hora_fin">Hora Fin</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tema">Tema</label>
                        <input type="text" name="tema" id="tema" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" name="link" id="link" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar Actividad</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Función para mostrar el modal de agregar actividad
        window.showCreateActivityModal = function(cursoId) {
            console.log('Curso ID:', cursoId); // Verificar que el ID se recibe correctamente
            $('#curso_id').val(cursoId); // Establecer el valor del campo oculto
            $('#addActivityModal').modal('show'); // Mostrar el modal
        };
    });
</script>

