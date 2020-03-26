<div class="col-lg-8 mx-auto">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="Art_cod" class="requerido">Código</label>
                @if (isset($servicio))
                <input type="text" class="form-control" name="Art_cod" id="Art_cod" value="{{trim($servicio->Art_cod)}}"
                    style="text-transform: uppercase;" maxlength="15" required readonly />
                @else
                <input type="text" class="form-control" name="Art_cod" id="Art_cod" value="{{old('Art_cod')}}"
                    style="text-transform: uppercase;" maxlength="15" required />
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="Art_nom_externo" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="Art_nom_externo" id="Art_nom_externo"
                    value="{{old('Art_nom_externo', trim($servicio->Art_nom_externo  ?? ''))}}"
                    style="text-transform: uppercase;" maxlength="60" required />
            </div>
        </div>
        <div class="col-lg-6">
            <!-- select -->
            <div class="form-group">
                <label class="requerido">Familia</label>
                @if(isset($servicio))
                <select class="form-control" id="Gc_fam_cod" required disabled>
                    @else
                    <select class="form-control" id="Gc_fam_cod" name="Gc_fam_cod" required>
                        @endif
                        @foreach ($familias as $familia)
                        @if (isset($servicio->Gc_fam_cod) && $servicio->Gc_fam_cod == $familia->Gc_fam_cod)
                        <option value="{{old('Gc_fam_cod', $familia->Gc_fam_cod)}}" selected>{{$familia->Gc_fam_desc}}
                        </option>
                        @else
                        <option value="{{old('Gc_fam_cod', $familia->Gc_fam_cod)}}">{{$familia->Gc_fam_desc}}</option>
                        @endif
                        @endforeach
                    </select>
                    @if(isset($servicio))
                    <input type="hidden" name="Gc_fam_cod" value="{{$servicio->Gc_fam_cod}}" />
                    @endif
            </div>
        </div>
        <div class="col-lg-6">
            <!-- select -->
            <div class="form-group">
                <label class="requerido">Clase</label>
                <select class="form-control" id="Gc_cla_cod" name="Gc_cla_cod" required>
                    @foreach ($clases as $clase)
                    @if (isset($servicio) && $clase->Gc_cla_cod == $servicio->Gc_cla_cod)
                    <option value="{{old('Gc_cla_cod', $clase->Gc_cla_cod)}}" selected>{{$clase->Gc_cla_desc}}</option>
                    @else
                    <option value="{{old('Gc_cla_cod', $clase->Gc_cla_cod)}}">{{$clase->Gc_cla_desc}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Precio</label>
                @if (isset($servicio))
                <input type="text" class="form-control" id="precio" name="precio"
                    value="{{number_format($servicio->precio->Ve_lis_pesos, 0, ',', '.')}}" />
                @else
                <input type="text" class="form-control" id="precio" name="precio" value="{{old('precio')}}" />
                @endif
            </div>
        </div>
    </div>
    @if (!isset($servicio) || (isset($servicio) && $servicio->Gc_fam_cod == 1))
    <div class="row divDuracion pt-5">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Duración General</label>
                <span title="La duración se ingresa en Horas:Minutos" data-toggle="tooltip" data-placement="top">
                    <i class="far fa-question-circle text-gray"></i>
                </span>
                @if (isset($servicio))
                <input type="text" class="form-control input-group-addon" name="duracion" id="duracion"
                    value="{{$servicio->tiempoGeneral->Dur_HorDur}}:{{$servicio->tiempoGeneral->Dur_MinDur}}">
                @else
                <input type="text" class="form-control input-group-addon" name="duracion" id="duracion" value="00:15" />

                @endif

            </div>
        </div>
        <!-- Editable table -->
        <div class="table-responsive p-1">
            <table class="table table-bordered">
                <thead class="border-bottom-3 border-black bg-gray-light">
                    <tr>
                        <th class="text-center">Especialista</th>
                        <th class="text-center">Duración
                            <span title="La duración se ingresa en Horas:Minutos" data-toggle="tooltip" data-placement="top">
                                <i class="far fa-question-circle text-gray"></i>
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($duracionEspecialistas as $duracionEspcialista)
                    <tr>
                        <td>
                            <input type="hidden" name="especialistas[]" value="{{$duracionEspcialista->Ve_cod_ven}}" />
                            {{$duracionEspcialista->Ve_nombre_ven}}
                        </td>
                        <td class="text-center">
                            @if (isset($servicio) && isset($duracionEspcialista->duracion))
                            <input type="text" name="duraciones[]"
                                class="form-control tdDuracion position-relative text-center border-0"
                                value="{{$duracionEspcialista->duracion->Ser_HorDur}}:{{$duracionEspcialista->duracion->Ser_MinDur}}">
                            @else
                            <input type="text" name="duraciones[]"
                                class="form-control tdDuracion position-relative text-center border-0" value="00:00" />
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Editable table -->
    </div>
    @endif
</div>