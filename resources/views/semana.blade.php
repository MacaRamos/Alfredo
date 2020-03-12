<div class="card-body table-responsive p-0">
  <table class="table table-bordered-calendar" id="tablaSemana">
    <thead style="background-color: #fafafa;">
      @php
      setlocale(LC_ALL, "es_CL.UTF-8", "es_CL", "esp", "ISO-8859-1","es_CL.UTF-8");
      $diaSemana = array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
      @endphp
      <tr>
        <th style="padding-left: -1.5rem; min-width: 100px; white-space: pre;">Hora</th>
        @foreach ($semana[0]->dias as $key =>$item)
        <th style="min-width: 236px;">{{$diaSemana[intval(date('w',strtotime($key)))]}}
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

        @if ($dato->Age_Estado == "A")
        @if ((new DateTime(date('d-m-Y H:i', strtotime($dato->Age_Inicio))) < new DateTime(date('d-m-Y H:i'))) ||
          ($diaSemana[intval(date('w',strtotime($dato->Age_Inicio)))]=='Dom' ) ||
          ($diaSemana[intval(date('w',strtotime($dato->Age_Inicio)))]=='Sáb' && new DateTime(date('d-m-Y H:i',
          strtotime($dato->Age_Inicio)))>
          new DateTime(date('d-m-Y', strtotime($dato->Age_Inicio)).' 14:00')))
          <td class="bg-gray-light disabled">
          </td>
          @else
          <td data-fecha="{{date('Y-m-d', strtotime($dato->Age_Inicio))}}"
            data-horainicio="{{date('H:i',strtotime($dato->Age_Inicio))}}"
            data-horafin="{{date('H:i',strtotime($dato->Age_Fin))}}" class="pointer text-center agendar" title="Agendar"
            data-toggle2="tooltip" data-placement="bottom" data-toggle="modal" data-target="#modalAgenda">
          </td>
          @endif
          @else
          @if ($dato->Age_Estado == "Z")
          @php

          @endphp
          <td class="{{trim($dato->estado["Clase"])}}" style="border-radius: 10px;" data-toggle2="tooltip"
            data-html="true" title='<p>DISPONIBLES: <br>
          @foreach ($dato->disponibles as $especialistaDisponible)
          - {{$especialistaDisponible}}
          @if(!$loop->last)
          <br>
          @endif
          @endforeach
        </p>'>{{trim($dato->estado["Nombre"])}}
          </td>
          @else
          @if (!isset($semana[$key+1]->dias[$dia]->Age_AgeCod) || (isset($semana[$key+1]->dias[$dia]->Age_AgeCod) &&
          $semana[$key+1]->dias[$dia]->Age_AgeCod != $semana[$key]->dias[$dia]->Age_AgeCod))
          <td class="{{trim($dato->estado["Clase"])}}"
            style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
            @php
            $altura = ((((strtotime($dato->Age_Fin) - strtotime($dato->Age_Inicio))/60)/15)-1)*36;
            @endphp

            <div style="height: {{$altura}}px; margin-top: -{{$altura}}px;">
              {{trim($dato->cliente["Cli_NomCli"])}} ({{$dato->cliente["Cli_NumCel"]}})<br>
              @foreach ($dato->lineasDetalle as $linea)
              {{$linea->articulo->Art_nom_externo}}
              @if(!$loop->last)
              <br>
              @endif
              @endforeach
            </div>
            {{-- BOTONES DROPDOWN OPCIONES --}}
            @switch($dato->Age_Estado)
            @case('B')
            <div class="btn-group float-right">
              <button type="button"
                class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
                data-toggle="dropdown">
              </button>
              <div class="dropdown-menu" x-placement="bottom-start"
                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 260px;">
                <a class="btn btn-app editar" data-key="{{$key}}" data-dia="{{$dia}}" data-toggle="modal"
                  data-fecha="{{date('Y-m-d',strtotime($dato->Age_Fecha))}}"
                  data-horainicio="{{date('H:i',strtotime($dato->Age_Inicio))}}"
                  data-horafin="{{date('H:i',strtotime($dato->Age_Fin))}}" data-target="#modalAgenda">
                  <i class="fas fa-edit"></i> Editar
                </a>
                <a class="btn btn-app confirmar" data-AgeCod="{{$semana[$key]->dias[$dia]->Age_AgeCod}}">{{-- C  confirmado --}}
                  <i class="fas fa-check"></i> Confirm
                </a>
                <a class="btn btn-app sinRespuesta" data-AgeCod="{{$semana[$key]->dias[$dia]->Age_AgeCod}}"
                  title="Sin respuesta">{{-- D  sin respuesta --}}
                  <i class="fas fa-phone-slash"></i> Sin Resp.
                </a>
                <a class="btn btn-app eliminar" data-AgeCod="{{$semana[$key]->dias[$dia]->Age_AgeCod}}">
                  <i class="fas fa-trash-alt"></i> Eliminar
                </a>
              </div>
            </div>
            @break
            @case('C')
            <div class="btn-group float-right">
              <button type="button"
                class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
                data-toggle="dropdown">
              </button>
              <div class="dropdown-menu" x-placement="bottom-start"
                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 260px;">
                <a class="btn btn-app editar" data-key="{{$key}}" data-dia="{{$dia}}" data-toggle="modal"
                  data-fecha="{{date('Y-m-d',strtotime($dato->Age_Fecha))}}"
                  data-horainicio="{{date('H:i',strtotime($dato->Age_Inicio))}}"
                  data-horafin="{{date('H:i',strtotime($dato->Age_Fin))}}" data-target="#modalAgenda">
                  <i class="fas fa-edit"></i> Editar
                </a>
                {{-- <a class="btn btn-app">
                  <i class="fas fa-check"></i> Asiste <!-- E  asiste -->
                </a> --}}
                <a class="btn btn-app noAsiste">
                  <i class="fas fa-times"></i> No Asiste {{-- F  no asiste --}}
                </a>
                <a class="btn btn-app eliminar" data-AgeCod="{{$semana[$key]->dias[$dia]->Age_AgeCod}}">
                  <i class="fas fa-trash-alt"></i> Eliminar
                </a>
              </div>
            </div>
            @break
            @case('E')
            <div class="btn-group float-right">
              <button type="button"
                class="btn-accion-tabla icon-circle-small bg-gray-light dropdown-toggle dropdown-icon"
                data-toggle="dropdown">
              </button>
              <div class="dropdown-menu" x-placement="bottom-start"
                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); min-width: 133px;">
                <a class="btn btn-app noAsiste" data-toggle="modal" data-target="#modalAgenda">
                  <i class="fas fa-times"></i> No Asiste <!-- F  no asiste -->
                </a>
                <a class="btn btn-app eliminar" data-AgeCod="{{$semana[$key]->dias[$dia]->Age_AgeCod}}">
                  <i class="fas fa-trash-alt"></i> Eliminar
                </a>
              </div>
            </div>
            @break
            @default
            @break
            @endswitch
            {{-- FIN BOTONES DROPDOWN OPCIONES --}}
          </td>
          @else
          @if (!isset($semana[$key-1]->dias[$dia]->Age_AgeCod) || (isset($semana[$key-1]->dias[$dia]->Age_AgeCod) &&
          $semana[$key-1]->dias[$dia]->Age_AgeCod != $semana[$key]->dias[$dia]->Age_AgeCod))
          <td class="{{trim($dato->estado["Clase"])}}" style="border-bottom: none; border-top-left-radius: 10px;
        border-top-right-radius: 10px;">
          </td>
          @else
          <td class="{{trim($dato->estado["Clase"])}}" style="border-bottom: none;">
          </td>
          @endif
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
</div>