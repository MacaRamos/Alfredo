
@extends("theme.$theme.layout")
@section('titulo')
Clientes
@endsection
@section('tituloContenido')
<h1 style="font-family: 'Khand', sans-serif;">CLIENTES</h1>
@endsection

@section("header")
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
@include('includes.mensaje')
<script>
  $(function(){
  var searchInput = $('#busqueda');


  $('#busqueda').on('input', function(){
    var newurl = "{{route('cliente')}}/";
    $.ajax({
        url: "{{route('filtrarCliente')}}/" + $('#busqueda').val(),
        success: function(result){
          $("#tabla-data").html(result);
          window.history.pushState({path:newurl},'',newurl);
        }
    });    
  });

});
</script>
@endsection

@section('contenido')
<div class="row">
  <div class="col-lg-12">
    <div class="row">
      <div class="col-lg-9">
        <div class="card-tools pull-right">
          <a href="{{route('crear_cliente')}}" class="btn btn-default">
            <i class="fas fa-plus-circle pr-2"></i>Nuevo
          </a>
          {{$notificacion['mensaje'] ?? ''}}
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group row">
          <label class="col-lg-2 col-form-label">Buscar</label>
          <div class="input-group col-lg-10">
            <input type="text" class="form-control" name="busqueda" id="busqueda" placeholder="Buscar"
              autocomplete="off" />
          </div>
        </div>
      </div>
      <!-- SIC y numero O/C -->
    </div>
    <div class="card mt-2" id='tabla-data'>
      <!-- /.card-header -->
      @include('cliente.table')

    </div>
    <!-- /.card -->
  </div>
</div>
@endsection