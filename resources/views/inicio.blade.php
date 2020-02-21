@extends("theme.$theme.layout")
@section('titulo')
Inicio
@endsection
@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Bootstrap Switch -->
<script src="{{asset("assets/$theme/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}"></script>
@include('includes.mensaje')
<script>
  $(function(){
    $('#modalAgenda').on('hidden.bs.modal', function (e) {
      $('.modal-body').find('input').val("");
      $('#tablaServicios').children('tbody').html("");
      $('#cliente-checkbox').bootstrapSwitch('state', false, false);
    })


    var mHorDur = 0;
    var mMinDur = 0;

    $('#especialistaOficial').text($('#especialista :selected').text());
    $("input[data-bootstrap-switch]").focus();
    $("#sede").change(function(){
        $('form#cambiarFiltros').submit();    
    });
    $("#especialista").change(function(){        
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
    
    $('#guardarReserva').click(function(){
      $('#accion').val('agendar');
      $('form#cambiarFiltros').submit();
    });

    $('.confirmar').click(function(e)
    {
        e.preventDefault();        
        $('#accion').val('confirmar');        
        $('#Age_AgeCod').val($(this).data('agecod'));
        $('form#cambiarFiltros').submit();
    });
    
    $('.agendar').click(function(){
      
      $('input[name=mfechaAgenda]').val($(this).parent().data('fecha'));
      $('#mHoraInicio').text($(this).parent().data('horainicio'));
      $('input[name=mHoraInicio]').val($('#mHoraInicio').text());
      $('#mHoraFin').text($(this).parent().data('horafin'));
      $('#mHoraFin').text($(this).parent().data('horafin'));

      console.log('Fecha: '+$('input[name=mfechaAgenda]').val());
      console.log($(this).parent().data('horainicio'));

      if ($('#especialista :selected').text() != 'Local'){
        $('#mEspecialista').html($('#especialista :selected').text());
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
                                id: Cliente.Cli_CodCli.trim()
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
      var duracionTotalReserva = new Date("1700-01-01 "+$('input[name=mHoraInicio]').val());
      $('input.hora').each(function(index, item)
      {
          var duracionServicioTd = new Date("1700-01-01 "+$(item).val());
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
      var duracionTotalReserva = new Date("1700-01-01 "+$('input[name=mHoraInicio]').val());
      $('input.hora').each(function(index, item)
      {
          var duracionServicioTd = new Date("1700-01-01 "+$(item).val());
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
        $('input[name=mHoraFin]').val($("#mHoraFin").text());
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
        $('input[name=mHoraFin]').val($("#mHoraFin").text());
       // console.log($("#mHoraFin").text());
      //$("#mHoraFin").text(duracionTotalReserva.getHours()+':'+duracionTotalReserva.getMinutes());
    }
    
    var servicio = 0
    $('#asignar').click(function(){
      if($('#Art_nom_externo').val() != '')
      {
        //mHorDur = parseInt($("#mHoraFin").text().substring(0,2))+mHorDur;
        //mMinDur = parseInt($("#mHoraFin").text().substring(3,5))+mMinDur;
        //$("#mHoraFin").text(mHorDur.toString()+':'+mMinDur.toString()); // save selected id to hidden input
        var duracionServicio = new Date('1700-01-01 '+mHorDur+':'+mMinDur);
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
  <input type="hidden" name="accion" id="accion" value="">
  <input type="hidden" name="Age_AgeCod" id="Age_AgeCod" value="">
  @include('modal')
  @csrf
  <div class="card">
    <div class="col-sm-6">
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
    <div class="col-sm-6">
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
            <div class="col-lg-5">
              @if ($fechaInicio->format('m') == $fechaTermino->format('m'))
              <p class="text-center p-0">{{ucwords(strftime("%h %d",$fechaInicio->getTimestamp()))}} -
                {{strftime("%d",$fechaTermino->getTimestamp())}}</p>
              @else
              <p class="text-center p-0">{{ucwords(strftime("%h %d",$fechaInicio->getTimestamp()))}} -
                {{ucwords(strftime("%h %d",$fechaTermino->getTimestamp()))}}</p>
              @endif
              <p class="text-center font-weight-bold p-0" id="especialistaOficial"></p>
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