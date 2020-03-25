<div class="col-lg-8 mx-auto">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label for="Art_cod" class="requerido">Código</label>
                <input type="text" class="form-control" name="Art_cod" id="Art_cod"
                    value="{{old('Art_cod', $servicio->Art_cod ?? '')}}" style="text-transform: uppercase;"
                    maxlength="15" required />
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="Art_nom_externo" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="Art_nom_externo" id="Art_nom_externo"
                    value="{{old('Art_nom_externo', $servicio->Art_nom_externo ?? '')}}"
                    style="text-transform: uppercase;" maxlength="60" required />
            </div>
        </div>
        <div class="col-lg-6">
            <!-- select -->
            <div class="form-group">
                <label class="requerido">Familia</label>
                <select class="form-control" id="Gc_fam_cod" name="Gc_fam_cod" required>
                    @foreach ($familias as $familia)
                    <option value="{{old('Gc_fam_cod', $familia->Gc_fam_cod)}}">{{$familia->Gc_fam_desc}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <!-- select -->
            <div class="form-group">
                <label class="requerido">Clase</label>
                <select class="form-control" id="Gc_cla_cod" name="Gc_cla_cod" required>
                    @foreach ($clases as $clase)
                    <option value="{{old('Gc_cla_cod', $clase->Gc_cla_cod)}}">{{$clase->Gc_cla_desc}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" />
            </div>
        </div>
    </div>
    <div class="row divDuracion pt-5">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Duración General</label>
                <input type="text" class="form-control" name="duracion" id="duracion" value="00:00" />
            </div>
        </div>
        <!-- Editable table -->
        <div class="table-responsive p-1">
            <table class="table table-borderless">
                <thead class="border-bottom-3 border-black bg-gray-light">
                    <tr>
                        <th class="text-center">Especialista</th>
                        <th class="text-center">Duración</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($duracionEspecialistas as $duracionEspcialista)
                    <tr>
                        <td>
                        <input type="hidden" name="especialistas[]" value="{{$duracionEspcialista->Ve_cod_ven}}"/>
                        {{$duracionEspcialista->Ve_nombre_ven}}
                        </td>
                        <td class="text-center">
                            @if (isset($duracionEspcialista->duracion))
                            <input type="text" name="duraciones[]" class="form-control tdDuracion position-relative"
                            value="{{$duracionEspcialista->duracion}}">{{$duracionEspcialista->duracion}}    
                            @else
                            <input type="text" name="duraciones[]" class="form-control tdDuracion position-relative"/>
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Editable table -->
    </div>
</div>