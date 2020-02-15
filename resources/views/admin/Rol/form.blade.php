<div class="form-group">
    <label for="Rol_nombre" class="col-lg-3 control-label requerido">Nombre</label>
    <div class="col-lg-8">
    <input type="text" name="Rol_nombre" id="Rol_nombre" class="form-control" value="{{old('Rol_nombre', $data->Rol_nombre ?? '')}}" required/>
    </div>
</div>