<div class="card-body table-responsive p-0">
<table class="table table-bordered-calendar" id="tablaSemana">
  <thead style="background-color: #fafafa;">
    @php
    setlocale(LC_ALL, "es_CL.UTF-8", "es_CL", "esp", "ISO-8859-1","es_CL.UTF-8");
    $diaSemana = array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
    @endphp
    <tr>
      <th style="min-width: 100px; white-space: pre;">Hora</th>
      @foreach ($dia[0]->espe as $key =>$item)
      <th style="min-width: 100px;">
        {{explode(' ',$key)[0]}}
    </th>
      @endforeach
    </tr>
  </thead>
  <tbody>
    @foreach ($dia as $key => $horas)
    <tr>
      @foreach ($dia[$key] as $index => $datos)
      @if ($index == 'Hora')
      <td style="background-color: #fafafa;">{{$datos}}</td>
      @else
      @foreach ($dia[$key]->espe as $keyEspe => $dato)

      @if ($dato->Age_Estado == "A")
      @if ((new DateTime(date('d-m-Y H:i', strtotime($dato->Age_Inicio))) < new DateTime(date('d-m-Y H:i'))) ||
        ($diaSemana[intval(date('w',strtotime($dato->Age_Inicio)))]=='Dom' ) ||
        ($diaSemana[intval(date('w',strtotime($dato->Age_Inicio)))]=='Sáb' && new DateTime(date('d-m-Y H:i',
        strtotime($dato->Age_Inicio)))>
        new DateTime(date('d-m-Y', strtotime($dato->Age_Inicio)).' 14:00')))
        <td class="bg-gray-light disabled">
        </td>
        @else
        <td></td>
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
        @if (!isset($dia[$key+1]->espe[$keyEspe]->Age_AgeCod) || (isset($dia[$key+1]->espe[$keyEspe]->Age_AgeCod) &&
        $dia[$key+1]->espe[$keyEspe]->Age_AgeCod != $dia[$key]->espe[$keyEspe]->Age_AgeCod))
        <td class="{{trim($dato->estado["Clase"])}}"
          style="border-top: none !important; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
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
        </td>
        @else
        @if (!isset($dia[$key-1]->espe[$keyEspe]->Age_AgeCod) || (isset($dia[$key-1]->espe[$keyEspe]->Age_AgeCod) &&
        $dia[$key-1]->espe[$keyEspe]->Age_AgeCod != $dia[$key]->espe[$keyEspe]->Age_AgeCod))
        <td class="{{trim($dato->estado["Clase"])}}" style="border-bottom: none; border-top-left-radius: 10px;
        border-top-right-radius: 10px;">
        </td>
        @else
        <td class="{{trim($dato->estado["Clase"])}}" style="border-bottom: none; border-top: none !important; ">
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