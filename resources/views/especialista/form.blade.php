<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Especialista -->
        <div class="col-lg-4">
            <div class="form-group ">
                <label for="rut" class="requerido">RUT</label>
                @if ($especialista ?? '')
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()" maxlength="12"
                    value="{{number_format($especialista->Ve_rut_ven, 0, ",", ".").'-'.$especialista->Ve_ven_dv}}" required />
                @else
                <input type="text" class="form-control" id="rut" name="rut" oninput="checkRut()" maxlength="12"
                    value="{{old('rut')}}" required />
                @endif
                <input type="hidden" class="form-control" id="Ve_rut_ven" name="Ve_rut_ven"
                    value="{{old('Ve_rut_ven', $especialista->Ve_rut_ven ?? '')}}" />
                <input type="hidden" class="form-control" id="Ve_ven_dv" name="Ve_ven_dv"
                    value="{{old('Ve_ven_dv', $especialista->Ve_ven_dv ?? '')}}" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="nombre" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre"
                    value="{{old('nombre', $especialista->Ve_nombre_ven ?? '')}}" required />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="apellido" class="requerido">Apellido</label>
                <input type="text" class="form-control" name="apellido" id="apellido"
                    value="{{old('apellido', $especialista->Ve_nombre_ven ?? '')}}" required />
                    <input type="hidden" class="form-control" name="Ve_nombre_ven" id="Ve_nombre_ven"/>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        <div class="col-lg-4">
            @csrf
            <div class="form-group ">
                <label class="label requerido">Local</label>
                <select class="form-control" id="sede" name="Ve_ven_depto" required>
                    @foreach ($sedes as $sede)
                    @if (isset($especialista) && $sede->Mb_Sedecod == substr($especialista->Ve_ven_depto,1,1))
                    <option value="V{{$sede->Mb_Sedecod}}" selected>{{$sede->Mb_sedenom}}</option>
                    @else
                    <option value="V{{$sede->Mb_Sedecod}}">{{$sede->Mb_sedenom}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label class="label requerido">Tipo</label>
                <select class="form-control" id="sede" name="Ve_tipo_ven" required>
                    @if (isset($especialista->Ve_tipo_ven))
                    <option value="{{$especialista->Ve_tipo_ven}}" selected>{{$especialista->Ve_tipo_ven}}</option>
                    @else
                    <option value="P">PELUQUERO</option>
                    <option value="A">ASISTENTE</option>
                    <option value="B">BARBERO</option>
                    <option value="E">ENCARGADO LOCA</option>
                    <option value="B">GERENCIA</option>
                    @endif
                </select>
            </div>
        </div>
    </div>

</div>