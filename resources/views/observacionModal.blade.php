<div class="modal fade" id="observacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="observacionModalLongTitle">Observación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-sm-12">
                    <!-- textarea -->
                    <div class="form-group">
                        <label>Observaciones:</label>
                        <input type="hidden" name="Rec_codigo" value="" />
                        <textarea id="observacion" name="Age_Observacion" class="form-control" rows="3"
                            placeholder="Observación ..." maxlength="100"></textarea>
                        <span id="maxCaracteres" class="float-right text-gray">100</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn bg-black" id="enviarObservacion">Enviar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>

        </div>
    </div>
</div>