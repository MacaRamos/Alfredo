@extends("theme.$theme.layout")
@section('titulo')
    Crear Menu
@endsection

@section('scripts')
<script src="{{asset("assets/pages/scripts/admin/menu/crear.js")}}"></script>
@endsection

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @include('includes.error-form')
        @include('includes.mensaje')
        <div class="card border-top border-info mt-2">
            <div class="card-header with-border">
                <h3 class="card-title">Crear Menús</h3>
                <div class="card-tools pull-right">
                    <a href="{{route('menu')}}" class="btn btn-block btn-info btn-sm ">
                        <i class="fas fa-reply"></i> Volver a Menús 
                    </a>
                </div>
            </div>
            <!-- form start -->
            <form action="{{route('guardar_menu')}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                @csrf
                <div class="card-body">
                 @include('admin.menu.form')
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="col-lg-8 mx-auto">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-8">
                                @include('includes.boton-form-crear')
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
