<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <i class="fas fa-boxes-stacked brand-image img-circle elevation-3" style="font-size: 24px; color: white; background-color: rgba(255,255,255,0.1); padding: 10px; opacity: .8;"></i>
        <span class="brand-text font-weight-light">Sistema Pedidos</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <div class="img-circle elevation-2" style="background-color: #6c757d; color: white; display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; font-weight: bold; flex-shrink: 0;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <div class="info" style="min-width: 0; flex: 1;">
                <a href="#" class="d-block text-white text-truncate" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.pedidos*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Pedidos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.pedidos.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Pedidos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pedidos.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Pedido</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Usuarios
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Usuario</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.areas*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>
                            Áreas
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.areas.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Áreas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.areas.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nueva Área</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.edificios*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Edificios
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.edificios.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Edificios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.edificios.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Edificio</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.oficinas*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-door-open"></i>
                        <p>
                            Oficinas
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.oficinas.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Oficinas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.oficinas.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nueva Oficina</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.solicitantes*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Solicitantes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.solicitantes.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar Solicitantes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.solicitantes.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nuevo Solicitante</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
