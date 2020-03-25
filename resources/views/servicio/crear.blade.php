@extends("theme.$theme.layout")
@section('titulo')
Crear Servicio
@endsection
@section('tituloContenido')
<h1 style="font-family: 'Khand', sans-serif;">Crear Servicio</h1>
@endsection

@section('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
@endsection
@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}"></script>
<!-- InputMask -->
<script src="{{asset("assets/$theme/plugins/moment/moment.min.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
@include('includes.mensaje')
@include('includes.error-form')
<script>
    $(function(){
        
        $('#Gc_fam_cod').on('change', function(){
            $.ajax({
                url: "{{route('selectDinamico')}}/"+$(this).val(),
                success: function(clases){
                    console.log(clases);
                    $('#Gc_cla_cod').empty();
                    
                    clases.forEach(clase => {
                        $('#Gc_cla_cod').append('<option value="'+clase.Gc_cla_cod+'">'+clase.Gc_cla_desc+'</option>');
                    });                    
                }
            });
            if($(this).val() == 1){
                $('.divDuracion').css('display', 'block');
            }else{
                $('.divDuracion').css('display', 'none');
            }
        });
        // $('#duracion').on('change',function() {
        //     var duracion = $(this).val().split(":");
        //     var minutes = parseInt(duracion[1]);
        //     var redondeo = (Math.round(minutes/15) * 15) % 60;
        //     if(parseInt(duracion[0]) > 0){
        //         $(this).val(duracion[0]+':'+redondeo.toString());
        //     }
        // });
        $('#duracion').datetimepicker({
            format: 'HH:mm',
            //disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 5 })], [moment({ h: 6, m: 45 }), moment({ h: 24 })]],
            enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            stepping: 15,
            icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                next: 'fa fa-angle-right',
                previous: 'fa fa-angle-left'
            },
            tooltips: {
                close: 'cerrar',
                decrementHour: 'Hora anterior',
                incrementHour: 'Hora siguiente',
                decrementMinute: 'Quitar minutos',
                incrementMinute: 'Incrementar minutos',
                pickHour: 'Ver horas',
                pickMinute: 'Ver minutos'
            }
        });

        $('.form-control.tdDuracion').datetimepicker({
            format: 'HH:mm',
            //disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 5 })], [moment({ h: 6, m: 45 }), moment({ h: 24 })]],
            enabledHours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            stepping: 15,
            icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                next: 'fa fa-angle-right',
                previous: 'fa fa-angle-left'
            },
            tooltips: {
                close: 'cerrar',
                decrementHour: 'Hora anterior',
                incrementHour: 'Hora siguiente',
                decrementMinute: 'Quitar minutos',
                incrementMinute: 'Incrementar minutos',
                pickHour: 'Ver horas',
                pickMinute: 'Ver minutos'
            }
        });
        
    });
</script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-3 border-black">
                <h3 class="card-title">Servicio</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('servicio')}}" class="btn btn-block bg-black btn-sm ">
                        <i class="fas fa-reply"></i> Volver a servicios
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form action="{{route('guardar_servicio')}}" id="form-general" class="form-horizontal" method="POST"
                autocomplete="off">
                @csrf
                <div class="card-body">
                    @include('servicio.form')
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