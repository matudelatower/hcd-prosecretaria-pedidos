@extends('layouts.admin')

@section('title', 'Detalle Solicitante')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.solicitantes.index') }}">Solicitantes</a></li>
    <li class="breadcrumb-item active">Detalle</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle del Solicitante</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $solicitante->id }}</p>
                        <p><strong>Nombre:</strong> {{ $solicitante->nombre }}</p>
                        <p><strong>Cargo:</strong> {{ $solicitante->cargo ?? 'No especificado' }}</p>
                        <p><strong>Dependencia:</strong> {{ $solicitante->dependencia ?? 'No especificada' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Estado:</strong> 
                            @if($solicitante->activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </p>
                        <p><strong>Fecha de Creación:</strong> {{ $solicitante->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                @if($solicitante->notas)
                <div class="mt-3">
                    <strong>Notas:</strong>
                    <p>{{ $solicitante->notas }}</p>
                </div>
                @endif

                <div class="mt-4">
                    <h5>Resumen de Actividad:</h5>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h4>{{ $solicitante->pedidosSolicitados->count() }}</h4>
                            <p class="text-muted">Pedidos Solicitados</p>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4>{{ $solicitante->pedidosRecibidosDestino->count() }}</h4>
                            <p class="text-muted">Pedidos Recibidos en Destino</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.solicitantes.edit', $solicitante) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('admin.solicitantes.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
