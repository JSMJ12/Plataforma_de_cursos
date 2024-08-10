<!-- Modal para Registro -->
<div class="modal fade" id="registroModal" tabindex="-1" role="dialog" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #041c48; color: #fff;">
                <h5 class="modal-title" id="editCursoModalLabel">Registrarse al Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('registro.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="curso_id" value="{{ $curso->id }}">

                    <!-- Selección del Tipo de Participante -->
                    <div class="form-group">
                        <label for="tipo_participante">Tipo de Participante:</label>
                        <select class="form-control" id="tipo_participante" name="tipo_participante" required>
                            <option value="Estudiantes de pregrado">Estudiantes de pregrado</option>
                            <option value="Estudiantes de posgrado">Estudiantes de posgrado</option>
                            <option value="Profesional">Profesional</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-fw fa-user-plus"></i> Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>