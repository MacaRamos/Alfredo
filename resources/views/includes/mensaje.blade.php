{{-- {{dd(session()->all())}} --}}
<script>
  var mensaje = @json(session()->get('mensaje') ?? $notificacion['mensaje'] ?? '');
  var tipo = @json(session()->get('tipo') ?? $notificacion['tipo'] ?? '');
  var titulo = @json(session()->get('titulo') ?? $notificacion['titulo'] ?? '');
  Alfredo.notificaciones(mensaje, titulo, tipo);
</script>