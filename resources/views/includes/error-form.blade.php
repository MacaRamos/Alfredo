{{-- @if ($errors->any())
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-exclamation-triangle"></i> El formulario contiene errores</h5>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif --}}
@if ($errors->any())
@foreach ($errors->all() as $error)
<script>

    var error = @json($error);
    toastr.options = {
                closeButton: true,
                newestOnTop: true,
                positionClass: 'toast-top-right',
                preventDuplicates: true,
                timeOut: '5000'
            };
    toastr.error(error,'Error');

</script>
@endforeach
@endif