@if ($item["submenu"] == [])
<li class="dd-item dd3-item" data-id="{{$item["Men_id"]}}">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content {{$item["Men_url"] == "javascript:;" ? "font-weight-bold" : ""}}">
        <a href="{{route('editar_menu', ['Men_id' => $item["Men_id"]])}}">{{$item["Men_nombre"] . " | Url -> " . $item["Men_url"]}} Icono -> <i style="font-size:20px;" class="fa fa-fw {{isset($item["Men_icono"]) ? $item["Men_icono"] : ""}}"></i></a>
        {{-- <a href="{{route('eliminar_menu', ['Men_id' => $item["Men_id"]])}}" class="eliminar-menu pull-right tooltipsC" title="Eliminar este menú"><i class="text-danger fa fa-trash-o"></i></a> --}}
    </div>
</li>
@else
<li class="dd-item dd3-item" data-id="{{$item["Men_id"]}}">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content {{$item["Men_url"] == "javascript:;" ? "font-weight-bold" : ""}}">
        <a href="{{route("editar_menu", ['Men_id' => $item["Men_id"]])}}">{{ $item["Men_nombre"] . " | Url -> " . $item["Men_url"]}} Icono -> <i style="font-size:20px;" class="fa fa-fw {{isset($item["Men_icono"]) ? $item["Men_icono"] : ""}}"></i></a>
        {{-- <a href="{{route('eliminar_menu', ['Men_id' => $item["Men_id"]])}}" class="eliminar-menu pull-right tooltipsC" title="Eliminar este menú"><i class="text-danger fa fa-trash-o"></i></a> --}}
    </div>
    <ol class="dd-list">
        @foreach ($item["submenu"] as $submenu)
        @include("admin.menu.menu-item",[ "item" => $submenu ])
        @endforeach
    </ol>
</li>
@endif