@extends("theme.$theme.layout")
@section("titulo")
Menú - Rol
@endsection

@section("scripts")
<script src="{{asset("assets/pages/scripts/admin/menuRol/index.js")}}" type="text/javascript"></script>
@endsection

@section('contenido')
<div class="row">    
    <div class="col-lg-12">        
        @include('includes.mensaje')
        <div class="card card-success">
            <div class="card-header with-border">
                <h3 class="card-title">Menús - Rol</h3>
            </div>
            <div class="card-body">
                @csrf
                <table class="table table-striped table-bordered table-hover" id="tabla-data">
                    <thead>
                        <tr>
                            <th>Menú</th>
                            @foreach ($rols as $id => $nombre)
                            <th class="text-center">{{$nombre}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>                        
                        @foreach ($menus as $key => $menu)
                        @if ($menu["Men_codigo"] != 0)
                            @break
                        @endif
                            <tr>
                                <td class="font-weight-bold"><i class="fa fa-arrows-alt"></i> {{$menu["Men_nombre"]}}</td>
                                @foreach($rols as $id => $nombre)
                                    <td class="text-center">
                                        <input
                                        type="checkbox"
                                        class="menu_rol"
                                        name="menu_rol[]"
                                        data-menuid={{$menu["Men_id"]}}                                        
                                        value="{{$id}}" {{in_array($id, array_column($menusRols[$menu["Men_id"]], "Rol_codigo"))? "checked" : ""}}>
                                    </td>
                                @endforeach
                            </tr>
                            @foreach($menu["submenu"] as $key => $hijo)
                                <tr>
                                    <td class="pl-20"><i class="fa fa-arrow-right"></i> {{ $hijo["Men_nombre"] }}</td>
                                    @foreach($rols as $id => $nombre)
                                        <td class="text-center">
                                            <input
                                            type="checkbox"
                                            class="menu_rol"
                                            name="menu_rol[]"
                                            data-menuid={{$hijo["Men_id"]}}
                                            value="{{$id}}" {{in_array($id, array_column($menusRols[$hijo["Men_id"]], "Rol_codigo"))? "checked" : ""}}>
                                        </td>
                                    @endforeach
                                </tr>
                                @foreach ($hijo["submenu"] as $key => $hijo2)
                                    <tr>
                                        <td class="pl-30"><i class="fa fa-arrow-right"></i> {{$hijo2["Men_nombre"]}}</td>
                                        @foreach($rols as $id => $nombre)
                                            <td class="text-center">
                                                <input
                                                type="checkbox"
                                                class="menu_rol"
                                                name="menu_rol[]"
                                                data-menuid={{$hijo2["Men_id"]}}
                                                value="{{$id}}" {{in_array($id, array_column($menusRols[$hijo2["Men_id"]], "Rol_codigo"))? "checked" : ""}}>
                                            </td>
                                        @endforeach
                                    </tr>
                                    @foreach ($hijo2["submenu"] as $key => $hijo3)
                                        <tr>
                                            <td class="pl-40"><i class="fa fa-arrow-right"></i> {{$hijo3["Men_nombre"]}}</td>
                                            @foreach($rols as $id => $nombre)
                                            <td class="text-center">
                                                <input
                                                type="checkbox"
                                                class="menu_rol"
                                                name="menu_rol[]"
                                                data-menuid={{$hijo3["Men_id"]}}
                                                value="{{$id}}" {{in_array($id, array_column($menusRols[$hijo3["Men_id"]], "Rol_codigo"))? "checked" : ""}}>
                                            </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 
@endsection 