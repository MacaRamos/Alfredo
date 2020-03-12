@extends("theme.$theme.layout")
@section('titulo')
Crear Especialista
@endsection
@section('tituloContenido')
<h1 style="font-family: 'Khand', sans-serif;">Crear Especialista</h1>
@endsection


@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}"></script>
<link rel="stylesheet" href="{{asset("assets/$theme/plugins/daterangepicker/daterangepicker.css")}}">
<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("assets/$theme/plugins/inputmask/min/jquery.inputmask.bundle.min.js")}}"></script>
@include('includes.mensaje')
@include('includes.error-form')

<script>
    

    function checkRut() {
        var rut = $('#rut').val();
        var actual = rut.replace(/^0+/, "");
        if (actual != '' && actual.length > 1) {
            var sinPuntos = actual.replace(/\./g, "");
            var actualLimpio = sinPuntos.replace(/-/g, "");
            var inicio = actualLimpio.substring(0, actualLimpio.length - 1);
            var rutPuntos = "";
            var i = 0;
            var j = 1;
            for (i = inicio.length - 1; i >= 0; i--) {
                var letra = inicio.charAt(i);
                rutPuntos = letra + rutPuntos;
                if (j % 3 == 0 && j <= inicio.length - 1) {
                    rutPuntos = "." + rutPuntos;
                }
                j++;
            }
            var dv = actualLimpio.substring(actualLimpio.length - 1);
            $('#rut').val(rutPuntos + "-" + dv);
            $('#Ve_rut_ven').val(actualLimpio);
            $('#Ve_ven_dv').val(dv);    
        }
    }

    $(function(){
        
        $('#guardar').on('click', function(){
            $('#Ve_nombre_ven').val($('#nombre').val()+' '+$('#apellido').val());
        });
    });

</script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-3 border-black">
                <h3 class="card-title">Especialista</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('especialista')}}" class="btn btn-block bg-black btn-sm ">
                        <i class="fas fa-reply"></i> Volver a especialistas
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form action="{{route('guardar_especialista')}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf
                <div class="card-body">
                    @include('especialista.form')
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