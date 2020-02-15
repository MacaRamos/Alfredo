<!-- Modal -->
<div class="modal fade" id="modalFechas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <form id="formModel">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFechasLongTitle">Indique periodo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Desde - Hasta</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="rangoFecha" name="rangoFecha" autocomplete="off">
                        </div>
                        <!-- /.input group -->
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary text-white" id="mostrarPDF">Mostrar
                        PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
