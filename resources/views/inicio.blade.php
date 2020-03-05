@extends("theme.$theme.layout")
@section('titulo')
Inicio
@endsection
@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
<!-- Bootstrap Switch -->
<script src="{{asset("assets/$theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}"></script>
<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/inputmask/min/jquery.inputmask.bundle.min.js")}}"></script>
@include('includes.mensaje')

@section('styles')
<style>
  .tooltip.show p {
    text-align: left;
  }
</style>
@endsection

<script>
  $("#celular").inputmask({
    mask: "[9-99999999]",
      placeholder: ''
  });
  $("#fijo").inputmask({
    mask: "[41-2196134]",
      placeholder: ''
  });
  $(function(){
    
    var semana = @json($semana);
    console.log(semana);
    
    $('[data-toggle2="tooltip"]').tooltip()

    $('#modalAgenda').on('hidden.bs.modal', function (e) {
      $('.modal-body').find('input').val("");
      $('#tablaServicios').children('tbody').html("");
      $('#cliente-checkbox').bootstrapSwitch('state', false, false);
    })

    var servicio = 0
    var mHorDur = 0;
    var mMinDur = 0;

    $('#especialistaOficial').text($('#especialista :selected').text());
    $("input[data-bootstrap-switch]").focus();
    $("#sede").change(function(){
        $('form#cambiarFiltros').submit();    
    });
    $("#especialista").change(function(){        
        $('#accion').val('');
        $('form#cambiarFiltros').submit();
    });
    $('#anterior').click(function(){
      $('#accion').val('anterior');
      $('form#cambiarFiltros').submit();
    });
    $('#siguiente').click(function(){
      $('#accion').val('siguiente');
      $('form#cambiarFiltros').submit();
    });
    $('#mSede').text($('#sede :selected').text());
    $('input[name=mSede]').val($('#sede :selected').val());
    
    // $('#guardarReserva').click(function(){
    //   $('#accion').val('agendar');
    //   $('form#cambiarFiltros').submit();
    // });

    $('.confirmar').click(function(e)
    {
        e.preventDefault();        
        $('#accion').val('confirmar');        
        $('#Age_AgeCod').val($(this).data('agecod'));
        $('form#cambiarFiltros').submit();
    });

    $('.eliminar').click(function(e)
    {
        e.preventDefault();        
        $('#accion').val('eliminar');        
        $('#Age_AgeCod').val($(this).data('agecod'));
        $('form#cambiarFiltros').submit();
    });

    $('.editar').click(function(e)
    {
      $('#accion').val('editar');
        e.preventDefault();
        if ($('#especialista :selected').text() != 'Local'){
          $('#mEspecialista').text($('#especialista :selected').text());
        }else{
          $('#mEspecialista').css('display', 'none');
          $('#mOpcionEspecialista').css('display', 'block');
        }
        
        $('#Age_AgeCod').val(semana[$(this).data('key')].dias[$(this).data('dia')]["Age_AgeCod"]);
        $("#Cli_NomCli").val(semana[$(this).data('key')].dias[$(this).data('dia')].cliente["Cli_NomCli"]);
        $("#Cli_CodCli").val(semana[$(this).data('key')].dias[$(this).data('dia')].cliente["Cli_CodCli"]);
        $('input[name=mfechaAgenda]').val($(this).data('fecha'));
        $('#Age_Estado').val(semana[$(this).data('key')].dias[$(this).data('dia')]["Age_Estado"]);
        $('#mHoraInicio').text($(this).data('horainicio'));
        $('input[name=mHoraInicio]').val(semana[$(this).data('key')].dias[$(this).data('dia')]["Age_Inicio"]);
        $('#mHoraFin').text($(this).data('horafin'));
        $('input[name=mHoraFin]').val(semana[$(this).data('key')].dias[$(this).data('dia')]["Age_Fin"]);

        
        
        var lineasDetalle = semana[$(this).data('key')].dias[$(this).data('dia')].lineasDetalle;
        $.each(lineasDetalle, function(index, linea) {
          if (linea.articulo.tiempoEspecialista != null){
            mHorDur = linea.articulo.tiempoEspecialista["Ser_HorDur"];
            mMinDur = linea.articulo.tiempoEspecialista["Ser_MinDur"];
          }else{
            mHorDur = linea.articulo.tiempoGeneral["Dur_HorDur"];
            mMinDur = linea.articulo.tiempoGeneral["Dur_MinDur"];
          }
          $('#Art_cod').val(linea.articulo.Art_cod);
          $('#Art_nom_externo').val(linea.articulo.Art_nom_externo);
          $('#tablaServicios').children('tbody').append('<tr><td>'+$('#Art_nom_externo').val()+'<input type="hidden" name="servicios['+index+']" value="'+$('#Art_cod').val()+'"/><input class="hora" style="display: none;" name="mDuracion['+index+']" value="'+mHorDur+':'+mMinDur+'"/><a class="btn-accion-tabla float-right quitarServicio"><i class="fas fa-times icon-circle-small bg-danger"></i></a></td></tr>');
          servicio = index+1;
        });
        
    });
    
    $('.agendar').click(function(){
      $('#accion').val('agendar');
      $('input[name=mSede]').val($('#sede :selected').val());
      $('input[name=mfechaAgenda]').val($(this).data('fecha'));
      $('#mHoraInicio').text($(this).data('horainicio'));
      $('input[name=mHoraInicio]').val($('input[name=mfechaAgenda]').val()+' '+$('#mHoraInicio').text());
      $('#mHoraFin').text($(this).data('horafin'));
      $('input[name=mHoraFin]').val($('input[name=mfechaAgenda]').val()+' '+$('#mHoraFin').text());

      console.log('Fecha: '+$('input[name=mfechaAgenda]').val());
      console.log('Hora inicio'+$(this).data('horainicio'));

      if ($('#especialista :selected').text() != 'Local'){
        $('#mEspecialista').text($('#especialista :selected').text());
      }else{
        $('#mEspecialista').css('display', 'none');
        $('#mOpcionEspecialista').css('display', 'block');
      }
    });
    var switchSelector = 'input[data-bootstrap-switch]';
  
    // Convert all checkboxes with className `bs-switch` to switches. 
    $(switchSelector).bootstrapSwitch();

    // Attach `switchChange` event to all switches.
    $(switchSelector).on('switchChange.bootstrapSwitch', function(event, state) {
      // console.log(this);  // DOM element
      // console.log(event); // jQuery event
      // console.log(state); // true | false

      if (state){
        $('#viejoCliente').css('display', 'none');
        $('#nuevoCliente').css('display', 'block');
      }else{
        $('#viejoCliente').css('display', 'block');
        $('#nuevoCliente').css('display', 'none');
      }
    });
    $("#Cli_NomCli").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarCliente')}}",
                data: {
                    term : request.term
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(Cliente){
                        return {
                                label: Cliente.Cli_NomCli.trim(),
                                id: Cliente.Cli_CodCli
                            };
                    }); 
                    response(resp);
                }
            });
        },
        select: function (event, ui) {
            $("#Cli_NomCli").val(ui.item.label); // display the selected text
            $("#Cli_CodCli").val(ui.item.id); // save selected id to hidden input
        },
        minLength: 1
    });

    $("#Art_nom_externo").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('buscarServicio')}}",
                data: {
                    term : request.term,
                    especialista : $("#mOpcionEspecialista :selected").val().trim()
                },
                dataType: "json",
                success: function(data){
                  console.log(data);
                    response(data);
                }
            });
        },
        select: function (event, ui) {
          console.log(ui.item.horDur);
          console.log(ui.item.minDur);
            $("#Art_nom_externo").val(ui.item.label); // display the selected text
            $("#Art_cod").val(ui.item.id); // save selected id to hidden input
            mHorDur = parseInt(ui.item.horDur);
            mMinDur = parseInt(ui.item.minDur);
            console.log(mMinDur);
        },
        minLength: 1
    });
    //recibe un date
    function verificarHoraFinal(duracionServicio)
    {
      var duracionTotalReserva = new Date($('input[name=mfechaAgenda]').val()+' '+$('#mHoraInicio').text());
      console.log('hola '+duracionTotalReserva);
      $('input.hora').each(function(index, item)
      {
          var duracionServicioTd = new Date($('input[name=mfechaAgenda]').val()+' '+$(item).val());
          //establesco la nueva duración total de la reserva usando milisegundos
          duracionTotalReserva.setTime(duracionTotalReserva.getTime() +  //obtiene los milisegundos de la fecha actual
                                       (duracionServicioTd.getHours()*60*60*1000) + //obtiene la hora y la convierte en milisegundos
                                        (duracionServicioTd.getMinutes()*60*1000)); //obtiene los minutos y los convierte en milisegundos
          
      });
      duracionTotalReserva.setTime(duracionTotalReserva.getTime() +  //obtiene los milisegundos de la fecha actual
                                       (duracionServicio.getHours()*60*60*1000) + //obtiene la hora y la convierte en milisegundos
                                        (duracionServicio.getMinutes()*60*1000)); //obtiene los minutos y los convierte en milisegundos
      return duracionTotalReserva;
    }
    function calculaHoraFinal()
    {
      var duracionTotalReserva = new Date($('input[name=mfechaAgenda]').val()+' '+$('#mHoraInicio').text());
      $('input.hora').each(function(index, item)
      {
          var duracionServicioTd = new Date($('input[name=mfechaAgenda]').val()+' '+$(item).val());
          //establesco la nueva duración total de la reserva usando milisegundos
          duracionTotalReserva.setTime(duracionTotalReserva.getTime() +  //obtiene los milisegundos de la fecha actual
                                       (duracionServicioTd.getHours()*60*60*1000) + //obtiene la hora y la convierte en milisegundos
                                        (duracionServicioTd.getMinutes()*60*1000)); //obtiene los minutos y los convierte en milisegundos
          
      });
      var date = duracionTotalReserva;
      if (date.getHours() < 10){
            if (date.getMinutes() < 10){
              $("#mHoraFin").text('0'+date.getHours()+':0'+date.getMinutes());
            }else{
              $("#mHoraFin").text('0'+date.getHours()+':'+date.getMinutes());
            }
        }else{
            if (date.getMinutes() < 10){
              $("#mHoraFin").text(date.getHours()+':0'+date.getMinutes());
            }else{
              $("#mHoraFin").text(date.getHours()+':'+date.getMinutes());
            }
        }
        $('input[name=mHoraFin]').val($('input[name=mfechaAgenda]').val()+' '+$('#mHoraFin').text());
       // console.log($("#mHoraFin").text());
      //$("#mHoraFin").text(duracionTotalReserva.getHours()+':'+duracionTotalReserva.getMinutes());
    }

    //recibe un date
    function estableceHoraFinal(duracionTotalReserva)
    {
      var date = duracionTotalReserva;
      if (date.getHours() < 10){
            if (date.getMinutes() < 10){
              $("#mHoraFin").text('0'+date.getHours()+':0'+date.getMinutes());
            }else{
              $("#mHoraFin").text('0'+date.getHours()+':'+date.getMinutes());
            }
        }else{
            if (date.getMinutes() < 10){
              $("#mHoraFin").text(date.getHours()+':0'+date.getMinutes());
            }else{
              $("#mHoraFin").text(date.getHours()+':'+date.getMinutes());
            }
        }
        $('input[name=mHoraFin]').val($('input[name=mfechaAgenda]').val()+' '+$('#mHoraFin').text());
       // console.log($("#mHoraFin").text());
      //$("#mHoraFin").text(duracionTotalReserva.getHours()+':'+duracionTotalReserva.getMinutes());
    }
    
    
    $('#asignar').click(function(){
      if($('#Art_nom_externo').val() != '')
      {
        //mHorDur = parseInt($("#mHoraFin").text().substring(0,2))+mHorDur;
        //mMinDur = parseInt($("#mHoraFin").text().substring(3,5))+mMinDur;
        //$("#mHoraFin").text(mHorDur.toString()+':'+mMinDur.toString()); // save selected id to hidden input
        var duracionServicio = new Date($('input[name=mfechaAgenda]').val()+' '+mHorDur+':'+mMinDur);
        var duracionTotalServicios = verificarHoraFinal(duracionServicio);
        if(duracionTotalServicios.getHours()*60+duracionTotalServicios.getMinutes()  <= 19*60)
        {        
          $('#tablaServicios').children('tbody').append('<tr><td>'+$('#Art_nom_externo').val()+'<input type="hidden" name="servicios['+servicio+']" value="'+$('#Art_cod').val()+'"/><input class="hora" style="display: none;" name="mDuracion['+servicio+']" value="'+mHorDur+':'+mMinDur+'"/><a class="btn-accion-tabla float-right quitarServicio"><i class="fas fa-times icon-circle-small bg-danger"></i></a></td></tr>');
          servicio++;
          $('a.quitarServicio').click(function(){
            event.preventDefault();
            $(this).closest('tr').remove();
            calculaHoraFinal();  
          });
          estableceHoraFinal(duracionTotalServicios);      
        }else{
          //#TODO: poner mensaje de error si se pasa de las 19 de la tarde
        }
      }      
    });
    
  });
</script>

@endsection

@section('contenido')
<form class="form-horizontal" id="cambiarFiltros" method="POST" action="{{route('inicio')}}">
  <input type="hidden" name="ficha" value="{{ ($request->ficha ?? session()->get("ficha")) + 1  }}" />
  <input type="hidden" name="accion" id="accion" value="">
  <input type="hidden" name="Age_AgeCod" id="Age_AgeCod" value="">
  <input type="hidden" name="Age_Estado" id="Age_Estado" value="">
  @include('modal')
  @csrf
  <div class="card">
    <div class="row">
      <div class="col-sm-3">
        <!-- select -->
        <div class="form-group p-2">
          <span class="label">Local</span>
          <select class="form-control" id="sede" name="sede">
            @foreach ($sedes as $sede)
            @if ($sede->Mb_Sedecod == $request->sede)
            <option value="{{$sede->Mb_Sedecod}}" selected>{{$sede->Mb_sedenom}}</option>
            @else
            <option value="{{$sede->Mb_Sedecod}}">{{$sede->Mb_sedenom}}</option>
            @endif
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-sm-3">
        <!-- select -->
        <div class="form-group p-2">
          <span class="label">Especialista</span>
          <select class="form-control" id="especialista" name="especialista">
            @if (!$request->especialista)
            <option value="" selected>Local</option>
            @foreach ($especialistas as $especialista)
            <option value="{{$especialista->Ve_cod_ven}}">{{$especialista->Ve_nombre_ven}}</option>
            @endforeach
            @else
            <option value="">Local</option>
            @foreach ($especialistas as $especialista)
            @if (trim($especialista->Ve_cod_ven) == $request->especialista)
            <option value="{{$especialista->Ve_cod_ven}}" selected>{{$especialista->Ve_nombre_ven}}</option>
            @else
            <option value="{{$especialista->Ve_cod_ven}}">{{$especialista->Ve_nombre_ven}}</option>
            @endif
            @endforeach
            @endif
          </select>
        </div>
      </div>
    </div>

  </div>
  <!-- /.card -->
  <div class="row">
    <div class="col-12">
      <!-- Custom Tabs -->
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-3">
              <input type="hidden" name="fechaInicio" value="{{$fechaInicio->format('d-m-Y')}}">
              <input type="hidden" name="fechaTermino" value="{{$fechaTermino->format('d-m-Y')}}">
              <button type="button" id="anterior" class="btn btn-default btn-flat tooltipsC" title="Anterior"><i
                  class="fas fa-chevron-left"></i></button>
              <button type="button" id="siguiente" class="btn btn-default btn-flat tooltipsC" title="Siguiente"><i
                  class="fas fa-chevron-right"></i></button>
            </div>
            <div class="col-lg-5 mt-n2">
              @if ($fechaInicio->format('m') == $fechaTermino->format('m'))
              <p class="text-center p-0">{{ucwords(strftime("%h %d",$fechaInicio->getTimestamp()))}} -
                {{strftime("%d",$fechaTermino->getTimestamp())}}</p>
              @else
              <p class="text-center p-0">{{ucwords(strftime("%h %d",$fechaInicio->getTimestamp()))}} -
                {{ucwords(strftime("%h %d",$fechaTermino->getTimestamp()))}}</p>
              @endif
              <p class="text-center font-weight-bold mt-n3" id="especialistaOficial" style="font-size: 15px;"></p>
              <div class="row mx-auto">
                @if (isset($request->especialista))
                  <div class="col-sm-2">
                    <div class="bg-white border border-black" style="width: 80px; height: 10px"></div>
                    Disponible
                  </div>
                  <div class="col-sm-2">
                    <div class="bg-gray border border-black" style="width: 80px; height: 10px"></div>
                    Reservado
                  </div>
                  <div class="col-sm-2">
                    <div class="bg-success border border-black" style="width: 80px; height: 10px"></div>
                    Confirmado
                  </div>
                  <div class="col-sm-2">
                    <div class="bg-olive border border-black" style="width: 80px; height: 10px"></div>
                    En curso
                  </div>
                  <div class="col-sm-2">
                    <div class="bg-warning border border-black" style="width: 80px; height: 10px"></div>
                    Sin respuesta
                  </div>
                  <div class="col-sm-2">
                    <div class="bg-danger border border-black" style="width: 80px; height: 10px"></div>
                    No asiste
                  </div>
                {{-- @else
                  <div class="col-sm-3">
                    <div class="bg-white border border-black" style="width: 80px; height: 10px"></div>
                    Disponible
                  </div>
                  <div class="col-sm-3">
                    <div class="bg-warning border border-black" style="width: 80px; height: 10px"></div>
                    Medianamente ocupado
                  </div>
                  <div class="col-sm-3">
                    <div class="bg-orange border border-black" style="width: 80px; height: 10px"></div>
                    Casi ocupado
                  </div>
                  <div class="col-sm-3">
                    <div class="bg-danger border border-black" style="width: 80px; height: 10px"></div>
                    Full ocupado
                  </div> --}}
                @endif
              </div>
            </div>
            <div class="col-lg-4 mb-n1">
              <ul class="nav nav-pills float-right">
                <li class="nav-item"><a class="nav-link" href="#tab_1" data-toggle="tab">Mes</a></li>
                <li class="nav-item"><a class="nav-link active" href="#tab_2" data-toggle="tab">Semana</a></li>
                <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Día</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane" id="tab_1">

            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane active" id="tab_2">
              @include('semana')
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">

            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- ./card -->
    </div>
    <!-- /.col -->
  </div>
</form>
@endsection