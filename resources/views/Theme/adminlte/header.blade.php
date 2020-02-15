<nav class="main-header navbar navbar-expand bg-info">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link text-white" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    
  </ul>

  <!-- SEARCH FORM -->
  {{-- <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form> --}}

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    {{-- <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="{{asset("assets/$theme/dist/img/user1-128x128.jpg")}}" alt="User Avatar"
              class="img-size-50 mr-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Brad Diesel
                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">Call me whenever you can...</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="{{asset("assets/$theme/dist/img/user8-128x128.jpg")}}" alt="User Avatar"
              class="img-size-50 img-circle mr-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                John Pierce
                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">I got your message bro</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="{{asset("assets/$theme/dist/img/user3-128x128.jpg")}}" alt="User Avatar"
              class="img-size-50 img-circle mr-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Nora Silvester
                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">The subject goes here</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
      </div>
    </li> --}}
    <!-- Notifications Dropdown Menu -->
    {{-- <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li> --}}

    {{-- <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fas fa-user-cog"></i>
      </a> --}}

      <li class="dropdown user user-menu">
        <a class="nav-link text-white" data-toggle="dropdown" href="#">
          <img src="{{asset("assets/img/Avatar.png")}}" class="img-circle hover-brightness" alt="User Image" width="36" height="36">
        </a>


      <ul class="dropdown-menu dropdown-menu-right">
        <!-- User image -->
        <li class="user-header bg-info">
          <p style="font-size: 16px;">
            {{session()->get('Usu_nombre', 'Inivitado')}}
          </p>
          <p style="font-size: 12px;">{{session()->get('Rol_nombre', 'normal')}}</p>
        </li>
        <!-- Menu Body -->
        {{-- <li class="user-body">
          <div class="row">
            @if(session()->get("roles") && count(session()->get("roles")) > 1)
            <div class="col-xs-6 text-center">
              <a href="#" class="cambiar-rol">Cambiar Rol</a>
            </div>
            @endif
          </div>
        </li> --}}
        <!-- Menu Footer-->

        <li>
          <a href="{{route('logout')}}" class="btn btn-default border-0"><i class="fas fa-sign-out-alt"></i> Salir</a>
        </li>
        {{-- <li class="user-footer">
          <div class="pull-left">
            @guest
            <a href="{{route('login')}}" class="btn btn-default btn-flat">Login</a>
        @endguest
        </div>
        <div class="pull-right">
          <a href="{{route('logout')}}" class="btn btn-default btn-flat">Salir</a>
        </div>
    </li> --}}
  </ul>
  </li>
  <!-- Control Sidebar Toggle Button -->


  </ul>
</nav>
<!-- /.navbar -->