@extends('layouts.admin')

@section('title', 'Editar Pedido')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pedidos.index') }}">Pedidos</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Pedido #{{ $pedido->id }}</h3>
            </div>
            <form method="POST" action="{{ route('admin.pedidos.update', $pedido) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="numero_expediente">Número de Expediente</label>
                        <input type="text" class="form-control" id="numero_expediente" name="numero_expediente" value="{{ old('numero_expediente', $pedido->numero_expediente) }}">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $pedido->descripcion) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_solicitud">Fecha de Solicitud <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" value="{{ old('fecha_solicitud', $pedido->fecha_solicitud->format('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="solicitado_por_texto">Solicitado Por <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="solicitado_por_texto" name="solicitado_por_texto" value="{{ old('solicitado_por_texto', $pedido->solicitado_por_texto) }}" required>
                        <small class="form-text text-muted">Ej: Concejal Cardozo, Prosecretaría Legislativa, etc.</small>
                    </div>

                    <div class="form-group">
                        <label for="area_destino_id">Área Destino <span class="text-danger">*</span></label>
                        <select class="form-control" id="area_destino_id" name="area_destino_id" required>
                            <option value="">Seleccione...</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_destino_id', $pedido->area_destino_id) == $area->id ? 'selected' : '' }}>
                                {{ $area->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_recepcion">Fecha de Recepción</label>
                                <input type="date" class="form-control" id="fecha_recepcion" name="fecha_recepcion" value="{{ old('fecha_recepcion', $pedido->fecha_recepcion ? $pedido->fecha_recepcion->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="recibido_por">Recibido Por</label>
                                <select class="form-control" id="recibido_por" name="recibido_por">
                                    <option value="">Seleccione...</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('recibido_por', $pedido->recibido_por) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_envio">Fecha de Envío</label>
                                <input type="date" class="form-control" id="fecha_envio" name="fecha_envio" value="{{ old('fecha_envio', $pedido->fecha_envio ? $pedido->fecha_envio->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="enviado_por">Enviado Por</label>
                                <select class="form-control" id="enviado_por" name="enviado_por">
                                    <option value="">Seleccione...</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('enviado_por', $pedido->enviado_por) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="recibido_destino_por_texto">Recibido en Destino Por</label>
                        <input type="text" class="form-control" id="recibido_destino_por_texto" name="recibido_destino_por_texto" value="{{ old('recibido_destino_por_texto', $pedido->recibido_destino_por_texto) }}">
                        <small class="form-text text-muted">Persona que recibe en el área de destino (firma "recibo conforme")</small>
                    </div>

                    <div class="form-group">
                        <label for="fecha_recibido_destino">Fecha de Recibido en Destino</label>
                        <input type="date" class="form-control" id="fecha_recibido_destino" name="fecha_recibido_destino" value="{{ old('fecha_recibido_destino', $pedido->fecha_recibido_destino ? $pedido->fecha_recibido_destino->format('Y-m-d') : '') }}">
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado <span class="text-danger">*</span></label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="solicitado" {{ old('estado', $pedido->estado) == 'solicitado' ? 'selected' : '' }}>Solicitado</option>
                            <option value="recibido" {{ old('estado', $pedido->estado) == 'recibido' ? 'selected' : '' }}>Recibido</option>
                            <option value="enviado" {{ old('estado', $pedido->estado) == 'enviado' ? 'selected' : '' }}>Enviado</option>
                            <option value="entregado" {{ old('estado', $pedido->estado) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $pedido->observaciones) }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
                    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
