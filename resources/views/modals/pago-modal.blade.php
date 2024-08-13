<div class="modal fade" id="pagoModal" tabindex="-1" role="dialog" aria-labelledby="pagoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #041c48; color: #fff;">
                <h5 class="modal-title" id="editCursoModalLabel">Pagar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Imagen de las cuentas bancarias -->
                <div class="text-center mb-4">
                    <img src="{{ asset('images/numero_cuenta.jpeg') }}" alt="Cuentas Bancarias" class="img-fluid">
                </div>

                <form action="{{ route('pagos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="curso_id" value="{{ $curso->id }}">

                    <!-- Campo de monto ajustable según la modalidad -->
                    <div class="form-group">
                        <label for="monto">Monto a Pagar:</label>
                        <input type="number" class="form-control" id="monto" name="monto" step="0.01" value="{{ $curso->precio }}" readonly>
                    </div>

                    <!-- Fecha de pago -->
                    <div class="form-group">
                        <label for="fecha_pago">Fecha de Pago:</label>
                        <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Subir comprobante -->
                    <div class="form-group">
                        <label for="archivo_comprobante">Subir Comprobante:</label>
                        <input type="file" class="form-control" id="archivo_comprobante" name="archivo_comprobante" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-fw fa-dollar-sign"></i> Pagar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
