@extends("theme.$theme.layout")
@section('titulo')
Roles
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/index.js")}}" type="text/javascript"></script>
@include('includes.mensaje')
@endsection

@section('contenido')
<div class="row">
  <div class="col-lg-12">
    <div class="card border-top border-info mt-2">
      <div class="card-header with-border">
        <h3 class="card-title">Roles</h3>
        <div class="card-tools pull-right">
          <a href="{{route('crear_rol')}}" class="btn btn-block btn-info btn-sm ">
            <i class="fas fa-plus-circle"></i> Crear Rol
          </a>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <table class="table table-condensed" id='tabla-data'>
          <thead>
            <tr>
              <th>Nombre</th>
              <th style="width: 100px"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($datas as $data)
            <tr>
              <td>{{$data->Rol_nombre}}</td>
              <td>
                <a href="{{route('editar_rol', ['Rol_codigo' => $data->Rol_codigo])}}"
                  class="btn-accion-tabla tooltipsC" title="Editar este registro">
                  <i class="far fa-edit"></i>
                </a>
                <form action="{{route('eliminar_rol', ['Rol_codigo' => $data->Rol_codigo])}}"
                  class="d-inline form-eliminar" method="POST">
                  @csrf @method("delete")
                  <button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro">
                    <i class="far fa-trash-alt text-danger"></i>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection