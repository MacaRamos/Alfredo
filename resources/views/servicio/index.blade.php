@extends("theme.$theme.layout")
@section('titulo')
Servicios
@endsection
@section('tituloContenido')
<h1 style="font-family: 'Khand', sans-serif;">SERVICIOS</h1>
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
  $('#ProductosCheckbox').prop('checked', {{$productosCheckBox}});

  $('#busqueda').on('input', function(){
    var newurl = "{{route('servicio')}}/";
    if($('#busqueda').val() == ""){
      var url = "{{route('filtrarServicio')}}/" + $('#busqueda').val()+' /'+$('#ProductosCheckbox').prop('checked');
    }else{
      var url = "{{route('filtrarServicio')}}/" + $('#busqueda').val()+'/'+$('#ProductosCheckbox').prop('checked');
    }
    $.ajax({
        url: url,
        success: function(result){
          $("#tabla-data").html(result);
          window.history.pushState({path:newurl},'',newurl);
        }
    });
  });
 // el evento lo hace solito laravel

  $('#ProductosCheckbox').click(function (){
    var newurl = "{{route('servicio')}}/";
    if($('#busqueda').val() == ""){
      var url = "{{route('filtrarServicio')}}/" + $('#busqueda').val()+' /'+$('#ProductosCheckbox').prop('checked');
    }else{
      var url = "{{route('filtrarServicio')}}/" + $('#busqueda').val()+'/'+$('#ProductosCheckbox').prop('checked');
    }
    $.ajax({
        url: url,
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
      <div class="col-lg-6">
        <div class="card-tools pull-right">
          <a href="{{route('crear_servicio')}}" class="btn btn-default">
            <i class="fas fa-plus-circle pr-2"></i>Nuevo
          </a>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="ProductosCheckbox">
          <label for="ProductosCheckbox" class="custom-control-label">Productos</label>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group row">
          <label class="col-lg-2 col-form-label">Buscar</label>
          <div class="input-group col-lg-10">
            <input type="text" class="form-control" name="busqueda" id="busqueda" placeholder="Buscar"
              value="{{$Art_nom_externo}}" autocomplete="off" />
          </div>
        </div>
      </div>
      <!-- SIC y numero O/C -->
    </div>
    <div class="card mt-2" id='tabla-data'>
      <!-- /.card-header -->
      @include('servicio.table')

    </div>
    <!-- /.card -->
  </div>
</div>
@endsection