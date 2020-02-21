<table class="table table-bordered table-bordered-calendar td-radius" id="tablaSemana">
  <thead style="background-color: #fafafa;">
    @php
    setlocale(LC_ALL, "es_CL.UTF-8", "es_CL", "esp", "ISO-8859-1","es_CL.UTF-8");
    $diaSemana = array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
    @endphp
    <tr>
      @foreach ($semana[0] as $key =>$item)
      @if ($key != 'HoraInicio' && $key != 'HoraFin' && $key != 'Estado' && $key != 'Age_AgeCod')
      @if ($key == "Hora")
      <th style="width: 150px;">{{$key}}</th>
      @else
      <th>{{$diaSemana[intval(date('w',strtotime($key)))]}} {{date('d-m',strtotime($key))}}</th>
      @endif
      @endif
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($semana as $key => $horas)
    <tr>
      @foreach ($semana[$key] as $index => $datos)
      @if ($index != 'HoraInicio' && $index != 'HoraFin' && $index != 'Estado' && $index != 'Age_AgeCod')
      @switch($datos)
      @case("B"){{--RESERVADO--}}
      <td class="bg-gray text-center text-black">RESERVADO
        <div class="btn-group float-right">
          <button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
          </button>
          <div class="dropdown-menu" x-placement="bottom-start"
            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
            <a class="tooltipsC agendar" title="Agendar" data-toggle="modal"
              data-target="#modalAgenda">
              <i class="fas fa-times text-gray icon-circle-small bg-danger"></i>
            </a>
            <a href="#" data-AgeCod="{{$semana[$key]["Age_AgeCod"]}}" class="tooltipsC
                confirmar" title="Confirmar">
              <i class="fas fa-check icon-circle-small bg-success"></i>
            </a>
          </div>
        </div>

      </td>
      @break
      @case("C"){{--CONFIRMADO--}}
      <td class=" bg-warning text-center">CONFIRMADO
        <a class="btn-accion-tabla tooltipsC float-right agendar" title="Agendar" data-toggle="modal"
          data-target="#modalAgenda">
          <i class="fas fa-times text-gray icon-circle-small bg-danger"></i>
        </a>
      </td>
      @break
      @case("A"){{--DISPONIBLE--}}
      <td data-fecha="{{$index}}" data-horainicio="{{date('H:i',strtotime($semana[$key]["HoraInicio"]))}}"
        data-horafin="{{date('H:i',strtotime($semana[$key]["HoraFin"]))}}" class=" text-center">--

        <a class="btn-accion-tabla tooltipsC float-right agendar" title="Agendar" data-toggle="modal"
          data-target="#modalAgenda">
          <i class="fas fa-calendar-check text-gray icon-circle-small bg-info"></i>
        </a>
        {{-- 
          <div class="btn-group float-right">
            <button type="button" class="btn btn-default" data-toggle="dropdown" aria-expanded="false">
            </button>
            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
              <a class="btn-accion-tabla tooltipsC float-right agendar" title="Agendar" data-toggle="modal"
            data-target="#modalAgenda">
            <i class="fas fa-times text-gray icon-circle-small bg-danger"></i>
          </a>
          <a href="#"  data-AgeCod= "{{$semana[$key]["Age_AgeCod"]}}" class="btn-accion-tabla tooltipsC float-right
        confirmar" title="Confirmar">
        <i class="fas fa-check icon-circle-small bg-success"></i>
        </a>
        </div>
        </div> --}}

      </td>
      @break
      @default
      @if ($index == 'Hora')
      <td style="background-color: #fafafa;">{{$datos}}</td>
      @else
      <td>{{$datos}}</td>
      @endif
      @endswitch
      @endif
      @endforeach
    </tr>
    @endforeach
  </tbody>
</table>