@extends('layouts.admin')

@section('title', 'Detalle Usuario')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">Detalle</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle del Usuario</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        <p><strong>Nombre:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Estado:</strong> 
                            @if($user->activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </p>
                        <p><strong>Oficina:</strong> {{ $user->oficina ? $user->oficina->nombre : 'No asignada' }}</p>
                        <p><strong>Fecha de Creación:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h5>Resumen de Actividad:</h5>
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <h4>{{ $user->pedidosSolicitados->count() }}</h4>
                            <p class="text-muted">Pedidos Solicitados</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h4>{{ $user->pedidosRecibidos->count() }}</h4>
                            <p class="text-muted">Pedidos Recibidos</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h4>{{ $user->pedidosEnviados->count() }}</h4>
                            <p class="text-muted">Pedidos Enviados</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <h4>{{ $user->pedidosRecibidosDestino->count() }}</h4>
                            <p class="text-muted">Pedidos Recibidos en Destino</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
