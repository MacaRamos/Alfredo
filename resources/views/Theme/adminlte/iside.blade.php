{{-- {{dd($menusComposer)}} --}}
<aside class="main-sidebar sidebar-light-blue elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('inicio')}}" class="brand-link bg-info d-flex" style="filter: brightness(0.9);">
    <img src="{{asset("assets/img/logo-blanco.png")}}" alt="AdminLTE Logo" class="brand-image">
    <span class="brand-text font-weight-light"> </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset("assets/img/Avatar.png")}}" class=" img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{session()->get('Usu_nombre')}}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-header">Menú principal</li>
        @foreach ($menusComposer as $item)
        @if ($item["Men_codigo"] != 0)
        @break
        @endif
        @include("theme.$theme.menu-item", ["item" => $item])
        @endforeach
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>