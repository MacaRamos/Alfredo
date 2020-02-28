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

      {{-- IF EN CURSO --}}
      @if (new DateTime(date('d-m-Y H:i', strtotime($index))) > new DateTime(date('d-m-Y H:i')))
      @switch($datos)
      {{--RESERVADO--}}
      @case("B")
      {{-- IF PARA AGREGAR BOTON AL FINAL --}}
      @if (!isset($semana[$key+1]["Age_AgeCod"]) || (isset($semana[$key+1]["Age_AgeCod"]) &&
      $semana[$key+1]["Age_AgeCod"] != $semana[$key]["Age_AgeCod"]))
      <td class="bg-gray text-center text-black"
        style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">RESERVADO
        {{-- BOTONES DROPDOWN OPCIONES --}}
        <div class="btn-group float-right">
          <button type="button" class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
            data-toggle="dropdown">
          </button>
          <div class="dropdown-menu" x-placement="bottom-start"
            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 194px;">
            <a class="btn btn-app">
              <i class="fas fa-edit"></i> Editar
            </a>
            <a class="btn btn-app confirmar" data-AgeCod="{{$semana[$key]["Age_AgeCod"]}}" title="Confirmar">
              <i class="fas fa-check"></i> Confirm
            </a>
            <a class="btn btn-app">
              <i class="fas fa-trash-alt"></i> Eliminar
            </a>
          </div>
        </div>
        {{-- FIN BOTONES DROPDOWN OPCIONES --}}
      </td>
      @else
      @if (!isset($semana[$key-1]["Age_AgeCod"]) || (isset($semana[$key-1]["Age_AgeCod"]) &&
      $semana[$key-1]["Age_AgeCod"] != $semana[$key]["Age_AgeCod"]))
      <td class="bg-gray text-center text-black"
        style="border-bottom: none; border-top-left-radius: 10px; border-top-right-radius: 10px;"></td>
      @else
      <td class="bg-gray text-center text-black" style="border-bottom: none;"></td>
      @endif

      @endif
      @break
      {{--CONFIRMADO--}}
      @case("C")
      @if (!isset($semana[$key+1]["Age_AgeCod"]) || (isset($semana[$key+1]["Age_AgeCod"]) &&
      $semana[$key+1]["Age_AgeCod"] != $semana[$key]["Age_AgeCod"]))
      <td class="bg-success text-center" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
        CONFIRMADO
        {{-- BOTONES DROPDOWN OPCIONES --}}
        <div class="btn-group float-right">
          <button type="button" class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
            data-toggle="dropdown">
          </button>
          <div class="dropdown-menu" x-placement="bottom-start"
            style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 130px">
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
      @else
      @if (!isset($semana[$key-1]["Age_AgeCod"]) || (isset($semana[$key-1]["Age_AgeCod"]) &&
      $semana[$key-1]["Age_AgeCod"] != $semana[$key]["Age_AgeCod"]))
      <td class="bg-success text-center"
        style="border-bottom: none; border-top-left-radius: 10px; border-top-right-radius: 10px;"></td>
      @else
      <td class="bg-success text-center" style="border-bottom: none;"></td>
      @endif
      @endif
      @break
      {{--DISPONIBLE--}}
      @case("A")
      <td data-fecha="{{$index}}" data-horainicio="{{date('H:i',strtotime($semana[$key]["HoraInicio"]))}}"
        data-horafin="{{date('H:i',strtotime($semana[$key]["HoraFin"]))}}" class="pointer text-center agendar"
        title="Agendar" data-toggle2="tooltip" data-placement="bottom" data-toggle="modal" data-target="#modalAgenda">
      </td>
      @break
      @default
      @if ($index == 'Hora')
      <td style="background-color: #fafafa;">{{$datos}}</td>
      @else
      <td>{{$datos}}</td>
      @endif
      @endswitch{{-- FIN SWITCH --}}

      @else
      @switch($datos)
      {{--RESERVADO--}}
      @case("B")
      <td class="bg-warning text-center text-black">SIN CONFIRMAR</td>
      @break
      {{--CONFIRMADO--}}
      @case("C")
      @if (new DateTime(date('d-m-Y H:i', strtotime($index))) >
      new DateTime(date('d-m-Y H:i', strtotime($semana[$key]["HoraFin"]))))
      <td class="bg-olive">EN CURSO</td>
      @else
      @if (!isset($semana[$key-1]["Age_AgeCod"]) || (isset($semana[$key-1]["Age_AgeCod"]) &&
      $semana[$key-1]["Age_AgeCod"] != $semana[$key]["Age_AgeCod"]))
      <td class="bg-black text-center"
        style="border-bottom: none; border-top-left-radius: 10px; border-top-right-radius: 10px;"></td>
      @else
      @if (!isset($semana[$key+1]["Age_AgeCod"]) || (isset($semana[$key+1]["Age_AgeCod"]) &&
      $semana[$key+1]["Age_AgeCod"] != $semana[$key]["Age_AgeCod"]))
      <td class="bg-black text-center" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
        FINALIZADO</td>
      @else
      <td class="bg-black text-center" style="border-bottom: none;"></td>
      @endif
      @endif

      @endif
      @break
      {{--DISPONIBLE--}}
      @case("A")
      <td class="bg-light disabled"></td>
      @break
      @default
      @if ($index == 'Hora')
      <td style="background-color: #fafafa;">{{$datos}}</td>
      @else
      <td>{{$datos}}</td>
      @endif
      @endswitch{{-- FIN SWITCH --}}
      @endif
      @endif{{-- FIN IF ($index != 'HoraInicio' && $index != 'HoraFin' && $index != 'Estado' && $index != 'Age_AgeCod')  --}}
      @endforeach
    </tr>
    @endforeach
  </tbody>
</table>