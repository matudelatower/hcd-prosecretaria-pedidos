@extends('layouts.admin')

@section('title', 'Detalle Oficina')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.oficinas.index') }}">Oficinas</a></li>
    <li class="breadcrumb-item active">Detalle</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle de la Oficina</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $oficina->id }}</p>
                        <p><strong>Nombre:</strong> {{ $oficina->nombre }}</p>
                        <p><strong>Descripción:</strong> {{ $oficina->descripcion ?? 'No especificada' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Edificio:</strong> {{ $oficina->edificio->nombre }}</p>
                        <p><strong>Descripción del Edificio:</strong> {{ $oficina->edificio->descripcion ?? 'No especificada' }}</p>
                    </div>
                </div>
                
                @if($oficina->usuarios->count() > 0)
                <div class="mt-3">
                    <strong>Usuarios asignados:</strong>
                    <ul>
                        @foreach($oficina->usuarios as $usuario)
                        <li>{{ $usuario->name }} ({{ $usuario->email }})</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.oficinas.edit', $oficina) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('admin.oficinas.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
