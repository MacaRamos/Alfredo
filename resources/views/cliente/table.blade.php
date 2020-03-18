<div class="card-body table-responsive p-0">
    <table class="table table-condensed table-hover" id="tabla-data">
        <thead class="border-bottom-3 border-black">
            <tr>
                <th>Cliente</th>
                <th>Célular</th>
                <th>Fijo</th>
                <th style="width: 100px"></th>
            </tr>
        </thead>
        <tbody class="border-bottom">
            @foreach ($clientes as $cliente)
            <tr>
                <td>{{$cliente->Cli_NomCli}}</td>
                <td>{{$cliente->Cli_NumCel}}</td>
                <td>{{$cliente->Cli_NumFij}}</td>
                <td>
                    <a href="{{route('editar_cliente', ['Cli_CodCli' => rtrim($cliente->Cli_CodCli)])}}"
                        class="btn-accion-tabla editar tooltipsC" title="Editar este registro">
                        <i class="fas fa-pencil-alt icon-circle bg-gray"></i>
                    </a>
                    <form
                        action="{{route('eliminar_cliente', ['Cli_CodCli' => rtrim($cliente->Cli_CodCli)])}}"
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
        {{$clientes->links("pagination::bootstrap-4")}}
    </div>
</div>
<!-- /.card-footer-->