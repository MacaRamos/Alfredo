@extends("theme.$theme.layout")
@section('titulo')
Especialistas
@endsection
@section('tituloContenido')
<h1 style="font-family: 'Khand', sans-serif;">ESPECIALISTAS</h1>
@endsection

@section("header")
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css")}}">
@endsection

@section("scripts")
@include('includes.mensaje')
<script>
  $(function(){
  var searchInput = $('#busqueda');

// Multiply by 2 to ensure the cursor always ends up at the end;
// Opera sometimes sees a carriage return as 2 characters.
  // var strLength = searchInput.val().length * 2;
  // searchInput.focus();
  // searchInput[0].setSelectionRange(strLength, strLength);

  $('#busqueda').on('input', function(){
    $.ajax({
        url: "{{route('filtrarEspecialistas')}}/" + $('#busqueda').val(),
        success: function(result){
          $("#tabla-data").html(result);
        }
    });        
  });

  $('.eliminar').click(function(e){
        e.preventDefault();  
        swal({
          title: '¿Está seguro que desea eliminar el especialista?',
            text: "Esta acción no se puede deshacer!",
            icon: 'error',
            buttons: {
                cancel: "Cancelar",
                confirm: "Aceptar"
            },
            dangerMode: true,
        }).then((value) => {
            if (value) {
              $('#accion').val('eliminar');        
              $('#Age_AgeCod').val($(this).data('agecod'));
              $('form#cambiarFiltros').submit();
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
          <a href="{{route('crear_especialista')}}" class="btn btn-default">
            <i class="fas fa-plus-circle pr-2"></i>Nuevo
          </a>
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
      @include('especialista.table')

    </div>
    <!-- /.card -->
  </div>
</div>
@endsection