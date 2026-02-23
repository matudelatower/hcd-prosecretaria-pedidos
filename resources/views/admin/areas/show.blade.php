@extends('layouts.admin')

@section('title', 'Detalle Área')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.areas.index') }}">Áreas</a></li>
    <li class="breadcrumb-item active">Detalle</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle del Área</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $area->id }}</p>
                        <p><strong>Nombre:</strong> {{ $area->nombre }}</p>
                        <p><strong>Descripción:</strong> {{ $area->descripcion ?? 'No especificada' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Estado:</strong> 
                            @if($area->activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </p>
                        <p><strong>Total de Pedidos:</strong> {{ $area->pedidos->count() }}</p>
                    </div>
                </div>
                
                @if($area->pedidos->count() > 0)
                <div class="mt-4">
                    <h5>Pedidos asociados a esta área:</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($area->pedidos->take(5) as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>{{ Str::limit($pedido->descripcion, 40) }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($area->pedidos->count() > 5)
                    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-sm btn-info">Ver todos los pedidos</a>
                    @endif
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.areas.edit', $area) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('admin.areas.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
