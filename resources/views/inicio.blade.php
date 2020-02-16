@extends("theme.$theme.layout")
@section('titulo')
Inicio
@endsection

@section('contenido')
<div class="card">
  <div class="col-sm-6">
    <!-- select -->
    <div class="form-group p-2">
      <span class="label">Local</span>
      <select class="form-control">
        <option>option 1</option>
        <option>option 2</option>
        <option>option 3</option>
        <option>option 4</option>
        <option>option 5</option>
      </select>
    </div>
  </div>
</div>
<!-- /.card -->
<div class="row">
  <div class="col-12">
    <!-- Custom Tabs -->
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-lg-3">
            <button type="button" class="btn btn-default btn-flat"><i class="fas fa-chevron-left"></i></button>
            <button type="button" class="btn btn-default btn-flat"><i class="fas fa-chevron-right"></i></button>
          </div>
          <div class="col-lg-5">
            <p class="text-center">Febrero</p>
          </div>
          <div class="col-lg-4 mb-n1">
            <ul class="nav nav-pills float-right">
              <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Mes</a></li>
              <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Semana</a></li>
              <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Día</a></li>
            </ul>
          </div>
        </div>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">

          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_2">
            <table class="table table-border-none">
              <thead>
                <tr>
                  @foreach ($semana[0] as $key =>$item)
                  @if ($key == "Hora")
                  <th style="width: 150px;">{{$key}}</th>
                  @else
                  <th>{{$key}}</th>
                  @endif
                  @endforeach
                </tr>
              </thead>
              <tbody>
                @foreach ($semana as $key => $horas)
                <tr>
                  @foreach ($semana[$key] as $index => $datos)
                    @switch($datos)
                        @case("Ocupado")
                            <td class="">{{$datos}}</td>
                            @break
                        @case("Disponible")
                            <td class="">{{$datos}}</td>
                            @break
                        @default
                          <td>{{$datos}}</td>
                    @endswitch
                  @endforeach
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_3">

          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
    </div>
    <!-- ./card -->
  </div>
  <!-- /.col -->
</div>
@endsection