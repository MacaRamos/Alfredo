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
<script>
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
</script>
@endsection

@section('contenido')
@include('modal')
<form class="form-horizontal" id="cambiarFiltros" method="POST" action="{{route('inicio')}}">
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
          @foreach ($especialistas as $especialista)
          @if ($especialista->Ve_cod_ven == $request->especialista)
          <option value="{{$especialista->Ve_cod_ven}}" selected>{{$especialista->Ve_nombre_ven}}</option>
          @else
          <option value="{{$especialista->Ve_cod_ven}}">{{$especialista->Ve_nombre_ven}}</option>
          @endif
          @endforeach
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
              <input type="hidden" name="accion" id="accion" value="">
              <input type="hidden" name="fechaInicio" value="{{$fechaInicio->format('d-m-Y')}}">
              <input type="hidden" name="fechaTermino" value="{{$fechaTermino->format('d-m-Y')}}">
              <button type="button" id="anterior" class="btn btn-default btn-flat"><i
                  class="fas fa-chevron-left"></i></button>
              <button type="button" id="siguiente" class="btn btn-default btn-flat"><i
                  class="fas fa-chevron-right"></i></button>
            </div>
            <div class="col-lg-5">
              @if ($fechaInicio->format('m') == $fechaTermino->format('m'))
              <p class="text-center">{{ucwords(strftime("%h",$fechaInicio->getTimestamp()))}}</p>
              @else
              <p class="text-center">{{ucwords(strftime("%h %d",$fechaInicio->getTimestamp()))}} -
                {{ucwords(strftime("%h %d",$fechaTermino->getTimestamp()))}}</p>
              @endif
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
              <table class="table table-bordered">
                <thead>
                  <tr>
                    @foreach ($semana[0] as $key =>$item)
                    @if ($key == "Hora")
                    <th style="width: 150px;">{{$key}}</th>
                    @else
                    <th>{{$key}}</th>
                    @endif
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @foreach ($semana as $key => $horas)
                  <tr>
                    @foreach ($semana[$key] as $index => $datos)
                    @switch($datos)
                    @case("Ocupado")
                    <td class="bg-warning opacity">
                      {{$datos}}
                      <a href="" class="btn-accion-tabla tooltipsC pl-2" title="Confirmar">
                        <i class="fas fa-check icon-circle-small bg-success"></i>
                      </a>
                    </td>
                    @break
                    @case("Disponible")
                    <td class="">{{$datos}}
                      <a class="btn-accion-tabla tooltipsC pl-2" title="Agendar" data-toggle="modal" data-target="#modalAgenda">
                        <i class="fas fa-calendar-check icon-circle-small bg-info"></i>
                      </a>
                    </td>
                    @break
                    @default
                    <td>{{$datos}}</td>
                    @endswitch
                    @endforeach
                  </tr>
                  @endforeach
                </tbody>
              </table>
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