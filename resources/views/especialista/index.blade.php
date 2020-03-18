@extends("theme.$theme.layout")
@section('titulo')
Funcionarios
@endsection
@section('tituloContenido')
<h1 style="font-family: 'Khand', sans-serif;">FUNCIONARIOS</h1>
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

  // $("#tabla-data").on('submit', '.form-eliminar', function (e) {
  //       e.preventDefault();
  //       const form = $(this);
  //       console.log(form);
  //       swal({
  //         title: '¿Está seguro que desea eliminar el especialista?',
  //           text: "Esta acción no se puede deshacer!",
  //           icon: 'error',
  //           buttons: {
  //               cancel: "Cancelar",
  //               confirm: "Aceptar"
  //           },
  //           dangerMode: true,
  //       }).then((value) => {
  //           if (value) {
  //             ajaxRequest(form);
  //           }
  //       });
  //   });

  //   function ajaxRequest(form) {
  //      console.log(form.attr('action'));
  //       $.ajax({
  //           url: form.attr('action'),
  //           type: 'POST',
  //           data: form.serialize(),
  //           success: function (respuesta) {
  //               if (respuesta.mensaje == "ok") {
  //                   form.parents('tr').remove();
  //                   Insuval.notificaciones('El registro fue eliminado correctamente', '', 'success');
  //               } else {
  //                   Insuval.notificaciones('El registro no pudo ser eliminado, hay recursos usandolo', '', 'error');
  //               }

  //           },
  //           error: function () {

  //           }
  //       });
  //   }
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