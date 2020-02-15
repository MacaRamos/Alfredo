<div class="col-lg-8 mx-auto">
    <div class="form-group row">
        <label for="Men_nombre" class="col-lg-3 col-form-label requerido">Nombre</label>
        <div class="col-lg-8">
        <input type="text" name="Men_nombre" class="form-control" id="Men_nombre" value="{{old('Men_nombre', $data->Men_nombre ?? '')}}" required/>
        </div>
    </div>
    <div class="form-group row">
        <label for="Men_url" class="col-lg-3 col-form-label requerido">Url</label>
        <div class="col-lg-8">
        <input type="text" name="Men_url" class="form-control" id="Men_url" value="{{old('Men_url', $data->Men_url ?? '')}}" required/>
        </div>
    </div>
    <div class="form-group row">
        <label for="Men_icono" class="col-lg-3 col-form-label">icono</label>
        <div class="col-lg-8">
        <input type="text" name="Men_icono" class="form-control" id="Men_icono" value="{{old('Men_icono', $data->Men_icono ?? '')}}" >
        </div>
        <div class="col-lg-1">
            <i id="mostrar-icono" class="{{old("icono")}} pt-2"></i>
        </div>
    </div>

</div>