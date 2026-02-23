@extends('layouts.admin')

@section('title', 'Edificios')
@section('breadcrumb')
    <li class="breadcrumb-item active">Edificios</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Edificios</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.edificios.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Edificio
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Oficinas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($edificios as $edificio)
                        <tr>
                            <td>{{ $edificio->id }}</td>
                            <td>{{ $edificio->nombre }}</td>
                            <td>{{ $edificio->descripcion ?? '-' }}</td>
                            <td>{{ $edificio->oficinas->count() }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.edificios.show', $edificio) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.edificios.edit', $edificio) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.edificios.destroy', $edificio) }}" style="display: inline;">
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
                            <td colspan="5" class="text-center">No hay edificios registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
