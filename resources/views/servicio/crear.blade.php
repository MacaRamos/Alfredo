@extends("theme.$theme.layout")
@section('titulo')
Crear Cliente
@endsection
@section('tituloContenido')
<h1 style="font-family: 'Khand', sans-serif;">Crear Cliente</h1>
@endsection


@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}"></script>
<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/inputmask/min/jquery.inputmask.bundle.min.js")}}"></script>
@include('includes.mensaje')
@include('includes.error-form')

<script>
    $("#Cli_NumCel").inputmask({
    mask: "[999999999]",
      placeholder: ''
  });
  $("#Cli_NumFij").inputmask({
    mask: "[999999999]",
      placeholder: ''
  });

</script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-3 border-black">
                <h3 class="card-title">Cliente</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('cliente')}}" class="btn btn-block bg-black btn-sm ">
                        <i class="fas fa-reply"></i> Volver a Clientes
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form action="{{route('guardar_cliente')}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf
                <div class="card-body">
                    @include('cliente.form')
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="col-lg-8 mx-auto">
                        <div class="row">
                            @include('includes.boton-form-crear')
                        </div>
                    </div>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@endsection