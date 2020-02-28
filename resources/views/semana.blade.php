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
        {{-- BOTONES DROPDOWN OPCIONES --}}
        <div class="btn-group float-right">
          <button type="button" class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
            data-toggle="dropdown">
          </button>
          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 194px;">
            <a class="btn btn-app">
              <i class="fas fa-edit"></i> Editar
            </a>
            <a class="btn btn-app" data-AgeCod="{{$semana[$key]["Age_AgeCod"]}}" title="Confirmar">
              <i class="fas fa-check"></i> Confirm
            </a>
            <a class="btn btn-app">
              <i class="fas fa-trash-alt"></i> Eliminar
            </a>
          </div>
        </div>
        {{-- FIN BOTONES DROPDOWN OPCIONES --}}
      </td>
      @break
      @case("C"){{--CONFIRMADO--}}
      <td class=" bg-warning text-center">CONFIRMADO
        {{-- BOTONES DROPDOWN OPCIONES --}}
        <div class="btn-group float-right">
          <button type="button" class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
            data-toggle="dropdown">
          </button>
          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 130px">
            <a class="btn btn-app">
              <i class="fas fa-edit"></i> Editar
            </a>
            <a class="btn btn-app">
              <i class="fas fa-trash-alt"></i> Eliminar
            </a>
          </div>
        </div>
        {{-- FIN BOTONES DROPDOWN OPCIONES --}}
      </td>
      @break
      @case("A"){{--DISPONIBLE--}}
      @if (new DateTime(date('d-m-Y H:i', strtotime($index))) > new DateTime(date('d-m-Y H:i')))
      <td data-fecha="{{$index}}" data-horainicio="{{date('H:i',strtotime($semana[$key]["HoraInicio"]))}}"
        data-horafin="{{date('H:i',strtotime($semana[$key]["HoraFin"]))}}" class="pointer text-center agendar"
        title="Agendar" data-toggle2="tooltip" data-placement="bottom" data-toggle="modal" data-target="#modalAgenda">

      </td>
      @else
      <td class="bg-light disabled color-palette"></td>
      @endif
      @break
      @default
      @if ($index == 'Hora')
      <td style="background-color: #fafafa;">{{$datos}}</td>
      @else
      <td>{{$datos}}</td>
      @endif{{-- FIN IF ($index == 'Hora') --}}
      @endswitch{{-- FIN SWITCH --}}
      @endif{{-- FIN IF ($index != 'HoraInicio' && $index != 'HoraFin' && $index != 'Estado' && $index != 'Age_AgeCod')  --}}
      @endforeach
    </tr>
    @endforeach
  </tbody>
</table>