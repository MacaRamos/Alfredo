<div class="col-lg-8 mx-auto">
    <div class="row">
        <!-- Especialista -->
        @if (isset($especialista))
        <div class="col-lg-6">
        @else
        <div class="col-lg-4">
        @endif
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
        @if (!isset($especialista))
        <div class="col-lg-4">
            <div class="form-group">
                <label for="Ve_cod_ven" class="requerido">Código Usuario</label>
                <input type="text" class="form-control" name="Ve_cod_ven" id="Ve_cod_ven"
                    value="{{old('Ve_cod_ven', $especialista->Ve_cod_ven ?? '')}}" required />
            </div>
        </div>
        @endif
        @if (isset($especialista))
        <div class="col-lg-6">
        @else
        <div class="col-lg-4">
        @endif
            <div class="form-group">
                <label for="Ve_nombre_ven" class="requerido">Nombre</label>
                <input type="text" class="form-control" name="Ve_nombre_ven" id="Ve_nombre_ven"
                    value="{{old('Ve_nombre_ven', $especialista->Ve_nombre_ven ?? '')}}" required />
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Paciente, Cliente y Prescriptor -->
        @if (isset($especialista))
        <div class="col-lg-6">
        @else
        <div class="col-lg-4">
        @endif
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
        @if (isset($especialista))
        <div class="col-lg-6">
        @else
        <div class="col-lg-4">
        @endif
            <div class="form-group">
                <label class="label requerido">Cargo</label>
                <select class="form-control" id="sede" name="Ve_tipo_ven" required>
                    @if (isset($especialista->Ve_tipo_ven))
                    @switch($especialista->Ve_tipo_ven)
                        @case('P')
                            <option value="{{$especialista->Ve_tipo_ven}}" selected>PELUQUERO</option>
                            <option value="A">ASISTENTE</option>
                            <option value="B">BARBERO</option>
                            <option value="E">ENCARGADO LOCA</option>
                            <option value="B">GERENCIA</option>
                            @break
                        @case('A')
                            <option value="A">PELUQUERO</option>
                            <option value="{{$especialista->Ve_tipo_ven}}" selected>ASISTENTE</option>
                            <option value="B">BARBERO</option>
                            <option value="E">ENCARGADO LOCA</option>
                            <option value="B">GERENCIA</option>
                            @break 
                        @case('B')
                            <option value="A">PELUQUERO</option>
                            <option value="A">ASISTENTE</option>
                            <option value="{{$especialista->Ve_tipo_ven}}" selected>BARBERO</option>
                            <option value="E">ENCARGADO LOCA</option>
                            <option value="B">GERENCIA</option>
                            @break
                        @case('E')
                            <option value="A">PELUQUERO</option>
                            <option value="A">ASISTENTE</option>
                            <option value="B">BARBERO</option>
                            <option value="{{$especialista->Ve_tipo_ven}}" selected>ENCARGADO LOCA</option>
                            <option value="B">GERENCIA</option>
                            @break
                        @case('G')
                            <option value="A">PELUQUERO</option>
                            <option value="A">ASISTENTE</option>
                            <option value="B">BARBERO</option>
                            <option value="E">ENCARGADO LOCA</option>
                            <option value="{{$especialista->Ve_tipo_ven}}" selected>GERENCIA</option>
                            @break
                    @endswitch                    
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