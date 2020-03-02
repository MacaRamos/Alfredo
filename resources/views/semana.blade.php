<table class="table table-bordered-calendar" id="tablaSemana">
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
      <th style="width: 236px; min-width: 236px;">{{$diaSemana[intval(date('w',strtotime($key)))]}}
        {{date('d-m',strtotime($key))}}</th>
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
      @if ($index == 'Hora')
      <td style="background-color: #fafafa;">{{$datos}}</td>
      @else
      @if ($datos == 'A')
      @if ((new DateTime(date('d-m-Y H:i', strtotime($index))) < new DateTime(date('d-m-Y H:i'))) ||
        ($diaSemana[intval(date('w',strtotime($index)))]=='Dom' ) ||
        ($diaSemana[intval(date('w',strtotime($index)))]=='Sáb' && new DateTime(date('d-m-Y H:i', strtotime($index)))>
        new DateTime(date('d-m-Y', strtotime($index)).' 14:00')))<td class="bg-gray-light disabled">
        </td>
        @else
        <td data-fecha="{{$index}}" data-horainicio="{{date('H:i',strtotime($semana[$key]["HoraInicio"]))}}"
          data-horafin="{{date('H:i',strtotime($semana[$key]["HoraFin"]))}}" class="pointer text-center agendar"
          title="Agendar" data-toggle2="tooltip" data-placement="bottom" data-toggle="modal" data-target="#modalAgenda">
        </td>
        @endif
        @else
        @if (!isset($semana[$key+1]["Age_AgeCod"]) || (isset($semana[$key+1]["Age_AgeCod"]) &&
        $semana[$key+1]["Age_AgeCod"] != $semana[$key]["Age_AgeCod"]))
        <td class="text-black"
          style="background-color: #{{explode('-',$datos)[1]}}; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
          {{-- BOTONES DROPDOWN OPCIONES --}}
          @switch(explode('-',$datos)[0])
          @case('B')
          <div class="btn-group float-right">
            <button type="button" class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
              data-toggle="dropdown">
            </button>
            <div class="dropdown-menu" x-placement="bottom-start"
              style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 260px;">
              <a class="btn btn-app">
                <i class="fas fa-edit"></i> Editar
              </a>
              <a class="btn btn-app confirmar" data-AgeCod="{{$semana[$key]["Age_AgeCod"]}}"
                title="Confirmar">{{-- C  confirmado --}}
                <i class="fas fa-check"></i> Confirm
              </a>
              <a class="btn btn-app confirmar" data-AgeCod="{{$semana[$key]["Age_AgeCod"]}}"
                title="Confirmar">{{-- D  sin respuesta --}}
                <i class="fas fa-phone-slash"></i> Sin Resp.
              </a>
              <a class="btn btn-app">
                <i class="fas fa-trash-alt"></i> Eliminar
              </a>
            </div>
          </div>
          @break
          @case('C')
          <div class="btn-group float-right">
            <button type="button" class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
              data-toggle="dropdown">
            </button>
            <div class="dropdown-menu" x-placement="bottom-start"
              style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 196px">
              <a class="btn btn-app">
                <i class="fas fa-edit"></i> Editar
              </a>
              <a class="btn btn-app">
                <i class="fas fa-check"></i> Asiste {{-- E  asiste --}}
              </a>
              <a class="btn btn-app">
                <i class="fas fa-times"></i> No Asiste {{-- F  no asiste --}}
              </a>
              <a class="btn btn-app">
                <i class="fas fa-trash-alt"></i> Eliminar
              </a>
            </div>
          </div>
          @break
          @default

          @endswitch
          {{-- FIN BOTONES DROPDOWN OPCIONES --}}
        </td>
        @else
        @if (!isset($semana[$key-1]["Age_AgeCod"]) || (isset($semana[$key-1]["Age_AgeCod"]) &&
        $semana[$key-1]["Age_AgeCod"] != $semana[$key]["Age_AgeCod"]))
        <td class="text-black"
          style="background-color: #{{explode('-',$datos)[1]}}; border-bottom: none; border-top-left-radius: 10px; border-top-right-radius: 10px;">
        </td>
        @else
        <td class="text-black" style="background-color: #{{explode('-',$datos)[1]}}; border-bottom: none;">
          {{$semana[$key]["Age_AgeCod"]}}</td>
        @endif
        @endif
        @endif
        @endif
        @endif{{-- FIN IF ($index != 'HoraInicio' && $index != 'HoraFin' && $index != 'Estado' && $index != 'Age_AgeCod')  --}}
        @endforeach
    </tr>
    @endforeach
  </tbody>
</table>