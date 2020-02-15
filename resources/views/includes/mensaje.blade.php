<script>
    $(document).ready(function(){
      var mensaje = @json(Session::get('mensaje'));
      if(mensaje !== null){
        var tipo = @json(Session::get('tipo'));
        var titulo = @json(Session::get('titulo'));
        Insuval.notificaciones(mensaje, titulo, tipo);
      }
    });
</script>