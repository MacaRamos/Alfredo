<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-black">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link text-white" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="dropdown user user-menu">
      <a class="text-white" data-toggle="dropdown" href="#">
        <img src="{{asset("assets/img/Avatar.png")}}" class="img-circle hover-brightness" alt="User Image" width="36"
          height="36">
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
        <!-- User image -->
        <li class="user-header bg-black">
          <p style="font-size: 16px;">
            {{session()->get('Usu_nombre', 'Inivitado')}}
          </p>
          <p style="font-size: 12px;">{{session()->get('Rol_nombre', 'normal')}}</p>
        </li>
        <li>
          <button class="btn btn-default btn-block border-0 text-left"><i class="fas fa-sign-out-alt"></i>
            <a href="{{route('logout')}}" class="text-black-50">Salir</a>
          </button>
          {{-- <a href="{{route('logout')}}" class="btn btn-default border-0"><i class="fas fa-sign-out-alt"></i> Salir</a> --}}
        </li>
      </ul>
    </li>
    <!-- Control Sidebar Toggle Button -->
  </ul>
</nav>
<!-- /.navbar -->