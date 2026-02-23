@extends('layouts.admin')

@section('title', 'Pedidos')
@section('breadcrumb')
    <li class="breadcrumb-item active">Pedidos</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Pedidos</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.pedidos.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Pedido
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filtros -->
                <form method="GET" action="{{ route('admin.pedidos.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="filtro_estado">Estado</label>
                            <select name="estado" id="filtro_estado" class="form-control form-control-sm">
                                <option value="">Todos los estados</option>
                                <option value="solicitado" {{ request('estado') == 'solicitado' ? 'selected' : '' }}>Solicitado</option>
                                <option value="recibido" {{ request('estado') == 'recibido' ? 'selected' : '' }}>Recibido</option>
                                <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                                <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filtro_expediente">Expediente</label>
                            <input type="text" name="expediente" id="filtro_expediente" class="form-control form-control-sm" value="{{ request('expediente') }}" placeholder="N° expediente">
                        </div>
                        <div class="col-md-3">
                            <label for="filtro_fecha">Fecha</label>
                            <input type="date" name="fecha" id="filtro_fecha" class="form-control form-control-sm" value="{{ request('fecha') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="filtro_area">Área Destino</label>
                            <select name="area_id" id="filtro_area" class="form-control form-control-sm">
                                <option value="">Todas las áreas</option>
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Expediente</th>
                            <th>Descripción</th>
                            <th>Solicitado Por</th>
                            <th>Fecha Solicitud</th>
                            <th>Área Destino</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->numero_expediente ?? '-' }}</td>
                            <td>{{ Str::limit($pedido->descripcion, 50) }}</td>
                            <td>{{ $pedido->solicitadoPorNombre }}</td>
                            <td>{{ $pedido->fecha_solicitud->format('d/m/Y') }}</td>
                            <td>{{ $pedido->areaDestino->nombre }}</td>
                            <td>
                                @switch($pedido->estado)
                                    @case('solicitado')
                                        <span class="badge badge-secondary">Solicitado</span>
                                        @break
                                    @case('recibido')
                                        <span class="badge badge-info">Recibido</span>
                                        @break
                                    @case('enviado')
                                        <span class="badge badge-warning">Enviado</span>
                                        @break
                                    @case('entregado')
                                        <span class="badge badge-success">Entregado</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pedidos.edit', $pedido) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($pedido->estado == 'solicitado')
                                        <button type="button" class="btn btn-success btn-sm" onclick="mostrarModalRecibir({{ $pedido->id }})">
                                            <i class="fas fa-check"></i> Recibir
                                        </button>
                                    @endif
                                    
                                    @if($pedido->estado == 'recibido')
                                        <button type="button" class="btn btn-warning btn-sm" onclick="mostrarModalEnviar({{ $pedido->id }})">
                                            <i class="fas fa-paper-plane"></i> Enviar
                                        </button>
                                    @endif
                                    
                                    @if($pedido->estado == 'enviado')
                                        <button type="button" class="btn btn-primary btn-sm" onclick="mostrarModalEntregar({{ $pedido->id }})">
                                            <i class="fas fa-box"></i> Entregar
                                        </button>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('admin.pedidos.destroy', $pedido) }}" style="display: inline;">
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
                            <td colspan="8" class="text-center">No hay pedidos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
