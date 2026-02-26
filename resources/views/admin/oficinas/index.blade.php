@extends('layouts.admin')

@section('title', 'Oficinas')
@section('breadcrumb')
    <li class="breadcrumb-item active">Oficinas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Oficinas</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.oficinas.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Oficina
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Edificio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($oficinas as $oficina)
                        <tr>
                            <td>{{ $oficina->id }}</td>
                            <td>{{ $oficina->nombre }}</td>
                            <td>{{ $oficina->descripcion ?? '-' }}</td>
                            <td>{{ $oficina->edificio->nombre }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.oficinas.show', $oficina) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.oficinas.edit', $oficina) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.oficinas.destroy', $oficina) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay oficinas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
