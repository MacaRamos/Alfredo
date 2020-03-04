<script>
  var mensaje = @json($notificacion["mensaje"]);
  console.log(mensaje);
  if(mensaje !== null){
    var tipo = @json($notificacion["tipo"]);
    var titulo = @json($notificacion["titulo"]);
    Insuval.notificaciones(mensaje, titulo, tipo);
  }
</script>