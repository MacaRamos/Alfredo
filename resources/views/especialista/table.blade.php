<div class="card-body table-responsive p-0">
    <table class="table table-condensed">
        <thead class="border-bottom-3 border-black">
            <tr>
                <th>Funcionario</th>
                <th>Cargo</th>
                <th>Sede</th>
                <th style="width: 100px"></th>
            </tr>
        </thead>
        <tbody class="border-bottom">
            @foreach ($especialistas as $especialista)
            <tr>
                <td>{{$especialista->Ve_nombre_ven}}</td>
                @switch($especialista->Ve_tipo_ven)
                @case('P')
                <td>PELUQUERO</td>
                @break
                @case('A')
                <td>ASISTENTE</td>
                @break
                @case('B')
                <td>BARBERO</td>
                @break
                @case('E')
                <td>ENCARGADO LOCA</td>
                @break
                @case('G')
                <td>GERENCIA</td>
                @break
                @endswitch
                <td>{{substr($especialista->Ve_ven_depto,1,2)}}</td>
                <td>
                    <a href="{{route('editar_especialista', ['Ve_cod_ven' => rtrim($especialista->Ve_cod_ven)])}}"
                        class="btn-accion-tabla editar tooltipsC" title="Editar este registro">
                        <i class="fas fa-pencil-alt icon-circle bg-gray"></i>
                    </a>
                    <form
                        action="{{route('eliminar_especialista', ['Ve_cod_ven' => rtrim($especialista->Ve_cod_ven)])}}"
                        class="d-inline form-eliminar" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar registro">
                            <i class="far fa-trash-alt icon-circle bg-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- /.card-body -->
<div class="card-footer bg-white">
    <div class="dataTables_paginate paging_simple_numbers float-right">
        {{$especialistas->links("pagination::bootstrap-4")}}
    </div>
</div>
<!-- /.card-footer-->