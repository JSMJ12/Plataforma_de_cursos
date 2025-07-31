<div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyModalLabel">Editar Datos de la Empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form action="{{ route('empresas.update', $empresa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nombre">Nombre de la Empresa</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input type="text" name="nombre" class="form-control" value="{{ $empresa->nombre }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" name="direccion" class="form-control" value="{{ $empresa->direccion }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" name="telefono" class="form-control" value="{{ $empresa->telefono }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email_contacto">Email de Contacto</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ $empresa->email_contacto }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sitio_web">Sitio Web</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                            <input type="url" name="sitio_web" class="form-control" value="{{ $empresa->sitio_web }}" placeholder="https://example.com">
                        </div>
                        <small class="form-text text-muted">Por favor, ingrese una URL válida.</small>
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" name="logo" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">Solo se permiten imágenes (JPG, PNG, GIF).</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Actualizar Empresa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
