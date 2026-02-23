@extends('layouts.admin')

@section('title', 'Detalle Pedido')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pedidos.index') }}">Pedidos</a></li>
    <li class="breadcrumb-item active">Detalle</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle del Pedido #{{ $pedido->id }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $pedido->id }}</p>
                        <p><strong>Número de Expediente:</strong> {{ $pedido->numero_expediente ?? 'No aplica' }}</p>
                        <p><strong>Descripción:</strong> {{ $pedido->descripcion }}</p>
                        <p><strong>Fecha de Solicitud:</strong> {{ $pedido->fecha_solicitud->format('d/m/Y') }}</p>
                        <p><strong>Solicitado Por:</strong> {{ $pedido->solicitado_por_nombre }}</p>
                        <p><strong>Área Destino:</strong> {{ $pedido->areaDestino->nombre }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Estado:</strong> 
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
                        </p>
                        
                        @if($pedido->fecha_recepcion)
                        <p><strong>Fecha de Recepción:</strong> {{ $pedido->fecha_recepcion->format('d/m/Y') }}</p>
                        <p><strong>Recibido Por:</strong> {{ $pedido->recibidoPor->name }}</p>
                        @endif
                        
                        @if($pedido->fecha_envio)
                        <p><strong>Fecha de Envío:</strong> {{ $pedido->fecha_envio->format('d/m/Y') }}</p>
                        <p><strong>Enviado Por:</strong> {{ $pedido->enviadoPor->name }}</p>
                        @endif
                        
                        @if($pedido->recibido_destino_por_nombre != 'No especificado')
                        <p><strong>Recibido en Destino Por:</strong> {{ $pedido->recibido_destino_por_nombre }}</p>
                        @if($pedido->fecha_recibido_destino)
                        <p><strong>Fecha de Recibido en Destino:</strong> {{ $pedido->fecha_recibido_destino->format('d/m/Y') }}</p>
                        @endif
                        @endif
                    </div>
                </div>
                
                @if($pedido->observaciones)
                <div class="mt-3">
                    <strong>Observaciones:</strong>
                    <p>{{ $pedido->observaciones }}</p>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.pedidos.edit', $pedido) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary">Volver</a>
                
                @if($pedido->estado == 'solicitado')
                    <a href="{{ route('admin.pedidos.recibir', $pedido) }}" class="btn btn-success">
                        <i class="fas fa-check"></i> Recibir Pedido
                    </a>
                @endif
                
                @if($pedido->estado == 'recibido')
                    <a href="{{ route('admin.pedidos.enviar', $pedido) }}" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Enviar Pedido
                    </a>
                @endif
                
                @if($pedido->estado == 'enviado')
                    <a href="{{ route('admin.pedidos.entregar', $pedido) }}" class="btn btn-success">
                        <i class="fas fa-check-double"></i> Entregar Pedido
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
