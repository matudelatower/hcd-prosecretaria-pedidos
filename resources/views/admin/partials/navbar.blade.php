<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Inicio</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
        </li> --}}
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown" style="max-width: 250px;">
                <div class="user-image img-circle elevation-2" style="background-color: #007bff; color: white; display: flex; align-items: center; justify-content: center; width: 35px; height: 35px; font-weight: bold; flex-shrink: 0;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <span class="d-none d-md-inline ml-2 text-truncate" style="flex: 1; min-width: 0;">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-primary">
                    <div class="img-circle elevation-2" style="background-color: white; color: #007bff; display: flex; align-items: center; justify-content: center; width: 90px; height: 90px; font-size: 36px; font-weight: bold; margin: 0 auto;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <p>
                        {{ Auth::user()->name }}
                        <small>{{ Auth::user()->email }}</small>
                    </p>
                </li>
                <li class="user-footer">
                    <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Perfil</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-default btn-flat">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
