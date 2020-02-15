@extends("theme.$theme.layout")
@section('titulo')
    Roles
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/crear.js")}}" type="text/javascript"></script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.error-form')
        @include('includes.mensaje')
        <div class="card border-top border-danger mt-2">
            <div class="card-header with-border">
                <h3 class="card-title">Editar Rol</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('rol')}}" class="btn btn-block btn-info btn-sm">
                        <i class="fas fa-reply"></i> Volver al listado
                    </a>
                </div>
            </div>
            <form action="{{route('actualizar_rol', ['Rol_codigo' => $data->Rol_codigo])}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                @csrf @method("put")
                <div class="card-body">
                    @include('admin.rol.form')
                </div>
                <div class="card-footer">
                    <div class="col-lg-8 mx-auto">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-8">
                                @include('includes.boton-form-editar')
                            </div>
                        </div>
                    </div>    
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div> 
@endsection 