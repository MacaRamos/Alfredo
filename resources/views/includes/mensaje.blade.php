@if (session()->get('notificacion'))
<script>
  console.log("1");
  var notificacion = @json(Session::get('notificacion'));
  var mensaje = notificacion.mensaje;
  var titulo = notificacion.titulo;
  var tipo = notificacion.tipo;

  toastr.options = {
                closeButton: true,
                newestOnTop: true,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                timeOut: '5000'
            };
    toastr.error(mensaje, titulo, tipo);
</script>
@endif 
@if (isset($notificacion))
<script>
  console.log("2");
  var notificacion = @json($notificacion));
  var mensaje = notificacion.mensaje;
  var titulo = notificacion.titulo;
  var tipo = notificacion.tipo;

  toastr.options = {
                closeButton: true,
                newestOnTop: true,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                timeOut: '5000'
            };
    toastr.error(mensaje, titulo, tipo);
</script>
@endif
