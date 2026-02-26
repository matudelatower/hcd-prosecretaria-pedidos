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
                                <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
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

                <div class="table-responsive">
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
                                    @case('completado')
                                        <span class="badge badge-primary">Completado</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <div>
                                    <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($pedido->estado != 'entregado' && $pedido->estado != 'completado')
                                        <a href="{{ route('admin.pedidos.edit', $pedido) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                    
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
                                    @if($pedido->estado == 'entregado')
                                        <form method="POST" action="{{ route('admin.pedidos.completar', $pedido) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Está seguro de completar este pedido?')">
                                                <i class="fas fa-check-circle"></i> Completar
                                            </button>
                                        </form>
                                    @endif
                                
                                @if(auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('admin.pedidos.destroy', $pedido) }}" style="display: inline; margin-left: 5px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este pedido?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                                                    
                                    
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
    @endsection

@push('scripts')
<script>
function mostrarModalRecibir(pedidoId) {
    $('#recibirPedidoId').val(pedidoId);
    $('#recibirFecha').val(new Date().toISOString().split('T')[0]);
    $('#modalRecibir').modal('show');
}

function mostrarModalEnviar(pedidoId) {
    $('#enviarPedidoId').val(pedidoId);
    $('#enviarFecha').val(new Date().toISOString().split('T')[0]);
    $('#modalEnviar').modal('show');
}

function mostrarModalEntregar(pedidoId) {
    $('#entregarPedidoId').val(pedidoId);
    $('#entregarFecha').val(new Date().toISOString().split('T')[0]);
    $('#modalEntregar').modal('show');
}

$(document).ready(function() {
    $('#formRecibir').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action').replace(':pedidoId', $('#recibirPedidoId').val());
        
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#modalRecibir').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error al procesar la solicitud');
            }
        });
    });

    $('#formEnviar').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action').replace(':pedidoId', $('#enviarPedidoId').val());
        
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#modalEnviar').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error al procesar la solicitud');
            }
        });
    });

    $('#formEntregar').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action').replace(':pedidoId', $('#entregarPedidoId').val());
        
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#modalEntregar').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error al procesar la solicitud');
            }
        });
    });
});
</script>
@endpush

<!-- Modal Recibir -->
<div class="modal fade" id="modalRecibir" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recibir Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formRecibir" action="{{ route('admin.pedidos.recibir', ':pedidoId') }}" method="POST">
                @csrf
                <input type="hidden" id="recibirPedidoId" name="pedido_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recibido_por">Recibido Por</label>
                        <select name="recibido_por" id="recibido_por" class="form-control" required>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recibirFecha">Fecha Recepción</label>
                        <input type="date" name="fecha_recepcion" id="recibirFecha" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Recibir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Enviar -->
<div class="modal fade" id="modalEnviar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enviar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEnviar" action="{{ route('admin.pedidos.enviar', ':pedidoId') }}" method="POST">
                @csrf
                <input type="hidden" id="enviarPedidoId" name="pedido_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="enviado_por">Enviado Por</label>
                        <select name="enviado_por" id="enviado_por" class="form-control" required>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="enviarFecha">Fecha Envío</label>
                        <input type="date" name="fecha_envio" id="enviarFecha" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Entregar -->
<div class="modal fade" id="modalEntregar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Entregar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEntregar" action="{{ route('admin.pedidos.entregar', ':pedidoId') }}" method="POST">
                @csrf
                <input type="hidden" id="entregarPedidoId" name="pedido_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recibido_destino_por_usuario">Recibido Por (Usuario)</label>
                        <select name="recibido_destino_por_usuario" id="recibido_destino_por_usuario" class="form-control">
                            <option value="">Seleccionar usuario</option>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="entregarFecha">Fecha Entrega</label>
                        <input type="date" name="fecha_recibido_destino" id="entregarFecha" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Entregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
