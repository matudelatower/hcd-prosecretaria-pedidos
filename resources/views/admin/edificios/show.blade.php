@extends('layouts.admin')

@section('title', 'Detalle Edificio')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.edificios.index') }}">Edificios</a></li>
    <li class="breadcrumb-item active">Detalle</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle del Edificio</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> {{ $edificio->id }}</p>
                        <p><strong>Nombre:</strong> {{ $edificio->nombre }}</p>
                        <p><strong>Descripción:</strong> {{ $edificio->descripcion ?? 'No especificada' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total de Oficinas:</strong> {{ $edificio->oficinas->count() }}</p>
                    </div>
                </div>
                
                @if($edificio->oficinas->count() > 0)
                <div class="mt-4">
                    <h5>Oficinas en este edificio:</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($edificio->oficinas as $oficina)
                                <tr>
                                    <td>{{ $oficina->id }}</td>
                                    <td>{{ $oficina->nombre }}</td>
                                    <td>{{ $oficina->descripcion ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.edificios.edit', $edificio) }}" class="btn btn-warning">Editar</a>
                <a href="{{ route('admin.oficinas.create') }}" class="btn btn-info">Agregar Oficina</a>
                <a href="{{ route('admin.edificios.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection
