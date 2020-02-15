@extends("theme.$theme.layout")
@section('titulo')
Permisos
@endsection
@section('contenido')
<div class="row">
  <div class="col-lg-12">
    <div class="card border-top border-danger mt-2">
      <div class="card-header">
        <h3 class="card-title">Permisos</h3>
      </div>
      <!-- /.card-header -->

      <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Slug</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($permisos as $permiso)
            <tr>
              <td>{{$permiso->Per_codigo}}</td>
              <td>{{$permiso->Per_nombre}}</td>
              <td>{{$permiso->Per_slug}}</td>
              <td></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
          <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>
@endsection