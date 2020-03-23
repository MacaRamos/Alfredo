<div class="card-body table-responsive p-0">
    <table class="table table-condensed table-hover" id="tabla-data">
        <thead class="border-bottom-3 border-black">
            <tr>
                <th>Nombre</th>
                {{-- <th>Duración</th> --}}
                <th>Precio</th>
                <th style="width: 100px"></th>
            </tr>
        </thead>
        <tbody class="border-bottom">
            @foreach ($servicios as $servicio)
            <tr>
                <td>{{$servicio->Art_nom_externo}}</td>
                {{-- @if (isset($servicio->tiempoGeneral->Dur_HorDur))
                <td>{{date('H:i:s', strtotime($servicio->tiempoGeneral->Dur_HorDur.':'.$servicio->tiempoGeneral->Dur_MinDur.':00'))}}</td>
                @else
                <td>00:00:00</td>
                @endif --}}
                @if (isset($servicio->precio->Ve_lis_pesos))
                <td><span class="text-right">{{"$".number_format($servicio->precio->Ve_lis_pesos, 0, ',', '.')}}</span></td>
                @else
                <td></td>
                @endif
                <td>
                    <a href="{{route('editar_servicio', ['Art_cod' => rtrim($servicio->Art_cod)])}}"
                        class="btn-accion-tabla editar tooltipsC" title="Editar este registro">
                        <i class="fas fa-pencil-alt icon-circle bg-gray"></i>
                    </a>
                    <form
                        action="{{route('eliminar_servicio', ['Art_cod' => rtrim($servicio->Art_cod)])}}"
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
        {{$servicios->links("pagination::bootstrap-4")}}
    </div>
</div>
<!-- /.card-footer-->