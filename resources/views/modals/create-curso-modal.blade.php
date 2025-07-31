<!-- Modal para crear curso -->
<div class="modal fade" id="createCursoModal" tabindex="-1" role="dialog" aria-labelledby="createCursoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #041c48; color: #fff;">
                <h5 class="modal-title" id="createCursoModalLabel">Crear Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createCursoForm" action="{{ route('cursos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="tipo_curso">Tipo de Evento</label>
                        <input type="text" name="tipo_curso" id="tipo_curso" class="form-control" placeholder="Curso, Seminario, Otros" required>
                    </div>                    
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" name="precio" id="precio" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="horas_academicas">Horas Académicas</label>
                        <input type="number" name="horas_academicas" id="horas_academicas" class="form-control" required>
                    </div>
                    @php
                        $user = Auth::user();
                    @endphp

                    @if($user && $user->hasRole('Capacitador'))
                        <input type="hidden" name="capacitador_id" value="{{ $user->id }}">
                    @else
                        <div id="capacitador_id_container" class="form-group">
                            <label for="capacitador_id">Capacitador</label>
                            <select name="capacitador_id" id="capacitador_id" class="form-control" required>
                                <option value="">Seleccione un capacitador</option>
                                @foreach($capacitadores as $capacitador)
                                    <option value="{{ $capacitador->id }}">
                                        {{ $capacitador->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <label for="create_tipo">Creado por</label>
                        <select name="tipo" id="create_tipo" class="form-control" required>
                            <option value="Instituto">Instituto</option>
                            <option value="Maestría">Maestría</option>
                            
                        </select>
                    </div>
                    <div class="form-group" id="create_nombre_maestria_container" style="display: none;">
                        <label for="create_nombre_maestria">Nombre Maestría</label>
                        <input type="text" name="nombre_maestria" id="create_nombre_maestria" class="form-control">
                    </div>

                    <div class="form-group" id="create_coordinador_maestria_container" style="display: none;">
                        <label for="create_coordinador_maestria">Nombre del Cordinador de la Maestría</label>
                        <input type="text" name="coordinador_maestria" id="create_coordinador_maestria" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="image">Imagen Promocinal</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Curso</button>
                </form>
            </div>
        </div>
    </div>
</div>