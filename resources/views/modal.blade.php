<div class="modal fade bd-example-modal-lg" id="modalAgenda" tabindex="-1" role="dialog"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      {{-- <form id="formModel" action="{{route('agendar')}}"> --}}
      <div class="modal-header border-bottom-3 border-black py-2 pl-3">
        <h6 class="label-title modal-title" id="modalAgendaLongTitle">Agendar Hora</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-lg-3">
            <label class="label">Local</label>
            <div><span class="label" id="mSede"></span>
              <input type="hidden" name="mSede" value="" />
            </div>
          </div>
          <div class="col-lg-3">
            <label class="label requerido">Especialista</label>
            <div><span class="label" id="mEspecialista"></span>
              <select class="form-control" id="mOpcionEspecialista" name="mOpcionEspecialista"
                style="width: 10em; display: none;">
                @foreach ($especialistas as $especialista)
                @if (trim($especialista->Ve_cod_ven) == $request->especialista)
                <option value="{{$especialista->Ve_cod_ven}}" selected>{{$especialista->Ve_nombre_ven}}</option>
                @else
                <option value="{{$especialista->Ve_cod_ven}}">{{$especialista->Ve_nombre_ven}}</option>
                @endif
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-lg-3">
            <label class="label">Hora Inicio</label>
            <div><span class="label" id="mHoraInicio"></span>
              <input type="hidden" name="mHoraInicio" />
            </div>
          </div>
          <div class="col-lg-3">
            <label class="label">Hora Fin</label>
            <div><span class="label" id="mHoraFin"></span>
              <input type="hidden" name="mHoraFin" />
            </div>
            <input type="hidden" name="mfechaAgenda" />
          </div>
        </div>

        <div class="row pt-4">
          <div class="col-lg-6" id="viejoCliente">
            <label class="label mb-0 requerido">Cliente</label>
            <input type="hidden" class="form-control" name="Cli_CodCli" id="Cli_CodCli" value="">
            <input type="text" class="form-control" name="Cli_NomCli" id="Cli_NomCli" value="" />
          </div>
          <div class="col-lg-6" id="nuevoCliente" style="display: none;">
            <label class="label mb-0 requerido">Nombre cliente</label>
            <input type="text" class="form-control" name="cliente" id="cliente" value=""
              style="text-transform: uppercase;" />
            <div class="row pt-4">
              <div class="col-lg-6">
                <label class="label requerido">Celular</label>
                <input type="text" class="form-control" name="celular" id="celular" value="" placeholder="9-9999999"
                  style="width: 10em;" />
              </div>
              <div class="col-lg-6">
                <label class="label">Teléfono Fijo</label>
                <input type="text" class="form-control" name="fijo" id="fijo" value="" placeholder="41-9999999"
                  style="width: 10em;" />
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <label class="label mb-0">¿Cliente Nuevo?</label>
            <div><input class="switch bs-switch" type="checkbox" id="cliente-checkbox" name="cliente-checkbox"
                data-bootstrap-switch data-on-color="black" data-on-text="Sí" data-off-text="No">
            </div>
          </div>
        </div>
        <div class="row pt-4">
          <div class="col-lg-122">
            <legend class="label-title">Asignar servicios</legend>
          </div>
        </div>
        <div class="row pt-4">
          <div class="col-lg-5">
            <label class="label mb-0 requerido">Servicio</label>
            <input type="hidden" class="form-control" name="Art_cod" id="Art_cod" value="">
            <input type="text" class="form-control" name="Art_nom_externo" id="Art_nom_externo" value="" required />
          </div>
          <div class="col-lg-2 text-center">
            <button type="button" class="btn btn-default" id="asignar">Asignar</button>
          </div>
          <div class="col-lg-5">
            <table class="table table-bordered" id="tablaServicios">
              <thead>
                <th>Servicio</th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn bg-black text-white">Guardar</button>
      </div>
      {{-- </form> --}}
    </div>
  </div>
</div>