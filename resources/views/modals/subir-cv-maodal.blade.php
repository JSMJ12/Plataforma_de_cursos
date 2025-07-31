<div class="modal fade" id="uploadCVModal" tabindex="-1" role="dialog" aria-labelledby="uploadCVModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #041c48; color: #fff;">
                <h5 class="modal-title" id="uploadCVModalLabel">Sube tu Currículum Vitae</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <p>Para postularte a los trabajos, primero debes subir tu CV. Solo se aceptan archivos PDF o Word.</p>
                <form id="uploadCvForm" action="{{ route('user.upload.cv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="cv">Subir CV (PDF o Word)</label>
                        <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Subir CV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>