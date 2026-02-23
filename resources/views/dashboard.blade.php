@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ \App\Models\Pedido::count() }}</h3>
                <p>Total Pedidos</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('admin.pedidos.index') }}" class="small-box-footer">
                Ver más <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ \App\Models\Pedido::where('estado', 'solicitado')->count() }}</h3>
                <p>Pedidos Solicitados</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('admin.pedidos.index', ['estado' => 'solicitado']) }}" class="small-box-footer">
                Ver más <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ \App\Models\Pedido::where('estado', 'enviado')->count() }}</h3>
                <p>Pedidos Enviados</p>
            </div>
            <div class="icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <a href="{{ route('admin.pedidos.index', ['estado' => 'enviado']) }}" class="small-box-footer">
                Ver más <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ \App\Models\Pedido::where('estado', 'entregado')->count() }}</h3>
                <p>Pedidos Entregados</p>
            </div>
            <div class="icon">
                <i class="fas fa-check"></i>
            </div>
            <a href="{{ route('admin.pedidos.index', ['estado' => 'entregado']) }}" class="small-box-footer">
                Ver más <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Últimos Pedidos</h3>
            </div>
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ultimosPedidos = \App\Models\Pedido::with(['solicitadoPor', 'areaDestino'])
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @forelse($ultimosPedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ Str::limit($pedido->descripcion, 30) }}</td>
                            <td>
                                @switch($pedido->estado)
                                    @case('solicitado')
                                        <span class="badge badge-warning">Solicitado</span>
                                        @break
                                    @case('recibido')
                                        <span class="badge badge-info">Recibido</span>
                                        @break
                                    @case('enviado')
                                        <span class="badge badge-primary">Enviado</span>
                                        @break
                                    @case('entregado')
                                        <span class="badge badge-success">Entregado</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $pedido->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay pedidos</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Estadísticas</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <h4>{{ \App\Models\User::count() }}</h4>
                        <p class="text-muted">Usuarios</p>
                    </div>
                    <div class="col-6 text-center">
                        <h4>{{ \App\Models\Area::count() }}</h4>
                        <p class="text-muted">Áreas</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6 text-center">
                        <h4>{{ \App\Models\Edificio::count() }}</h4>
                        <p class="text-muted">Edificios</p>
                    </div>
                    <div class="col-6 text-center">
                        <h4>{{ \App\Models\Oficina::count() }}</h4>
                        <p class="text-muted">Oficinas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
