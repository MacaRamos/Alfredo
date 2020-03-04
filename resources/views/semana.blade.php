<table class="table table-bordered-calendar" id="tablaSemana">
  <thead style="background-color: #fafafa;">
    @php
    setlocale(LC_ALL, "es_CL.UTF-8", "es_CL", "esp", "ISO-8859-1","es_CL.UTF-8");
    $diaSemana = array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
    @endphp
    <tr>
      <th style="width: 150px;">Hora</th>
      @foreach ($semana[0]->dias as $key =>$item)
      <th style="width: 236px; min-width: 236px;">{{$diaSemana[intval(date('w',strtotime($key)))]}}
        {{date('d-m',strtotime($key))}}</th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($semana as $key => $horas)
    <tr>
      @foreach ($semana[$key] as $index => $datos)
      @if ($index == 'Hora')
      <td style="background-color: #fafafa;">{{$datos}}</td>
      @else
      @foreach ($semana[$key]->dias as $dia => $dato)

      @if ($dato->Age_Estado === "A")
      @if ((new DateTime(date('d-m-Y H:i', strtotime($dato->Age_Inicio))) < new DateTime(date('d-m-Y H:i'))) ||
        ($diaSemana[intval(date('w',strtotime($dato->Age_Inicio)))]=='Dom' ) ||
        ($diaSemana[intval(date('w',strtotime($dato->Age_Inicio)))]=='Sáb' && new DateTime(date('d-m-Y H:i',
        strtotime($dato->Age_Inicio)))>
        new DateTime(date('d-m-Y', strtotime($dato->Age_Inicio)).' 14:00')))
        <td class="bg-gray-light disabled">
        </td>
        @else
        <td data-fecha="{{$dato->Age_Inicio}}" data-horainicio="{{date('H:i',strtotime($dato->Age_Inicio))}}"
          data-horafin="{{date('H:i',strtotime($dato->Age_Fin))}}" class="pointer text-center agendar" title="Agendar"
          data-toggle2="tooltip" data-placement="bottom" data-toggle="modal" data-target="#modalAgenda">
        </td>
        @endif
        @else

        @if (!isset($semana[$key+1]->dias[$dia]->Age_AgeCod) || (isset($semana[$key+1]->dias[$dia]->Age_AgeCod) &&
        $semana[$key+1]->dias[$dia]->Age_AgeCod != $semana[$key]->dias[$dia]->Age_AgeCod))
        <td class="text-black"
          style="background-color: #{{trim($dato->estado["Color"])}}; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
          {{-- BOTONES DROPDOWN OPCIONES --}}
          @switch($dato->Age_Estado)
          @case('B')
          <div class="btn-group float-right">
            <button type="button" class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
              data-toggle="dropdown">
            </button>
            <div class="dropdown-menu" x-placement="bottom-start"
              style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 260px;">
              <a class="btn btn-app editar" data-key="{{$key}}" data-dia="{{$dia}}">
                <i class="fas fa-edit editar"></i> Editar
              </a>
              <a class="btn btn-app confirmar" data-AgeCod="{{$semana[$key]->dias[$dia]->Age_AgeCod}}"
                data-horainicio="{{date('H:i',strtotime($dato->Age_Inicio))}}"
                data-horafin="{{date('H:i',strtotime($dato->Age_Fin))}}" title="Confirmar">{{-- C  confirmado --}}
                <i class="fas fa-check"></i> Confirm
              </a>
              <a class="btn btn-app confirmar" data-AgeCod="{{$semana[$key]->dias[$dia]->Age_AgeCod}}"
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
              style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 260px;">
              <a class="btn btn-app editar" data-key="{{$key}}" data-dia="{{$dia}}" data-toggle="modal"
                data-horainicio="{{date('H:i',strtotime($dato->Age_Inicio))}}"
                data-horafin="{{date('H:i',strtotime($dato->Age_Fin))}}" data-target="#modalAgenda">
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
        @if (!isset($semana[$key-1]->dias[$dia]->Age_AgeCod) || (isset($semana[$key-1]->dias[$dia]->Age_AgeCod) &&
        $semana[$key-1]->dias[$dia]->Age_AgeCod != $semana[$key]->dias[$dia]->Age_AgeCod))
        <td class="text-black" style="background-color: #{{trim($dato->estado["Color"])}}; border-bottom: none; border-top-left-radius: 10px;
        border-top-right-radius: 10px;">
        </td>
        @else
        <td class="text-black" style="background-color: #{{trim($dato->estado["Color"])}}; border-bottom: none;">
          {{$semana[$key]->dias[$dia]->Age_AgeCod}}</td>
        @endif
        @endif

        @endif
        @endforeach
        @endif
        @endforeach
    </tr>
    @endforeach
  </tbody>
</table>