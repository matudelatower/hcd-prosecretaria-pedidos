@extends('layouts.admin')

@section('title', 'Nueva Oficina')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.oficinas.index') }}">Oficinas</a></li>
    <li class="breadcrumb-item active">Nueva</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Crear Nueva Oficina</h3>
            </div>
            <form method="POST" action="{{ route('admin.oficinas.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="edificio_id">Edificio <span class="text-danger">*</span></label>
                        <select class="form-control" id="edificio_id" name="edificio_id" required>
                            <option value="">Seleccione...</option>
                            @foreach($edificios as $edificio)
                            <option value="{{ $edificio->id }}" {{ old('edificio_id') == $edificio->id ? 'selected' : '' }}>
                                {{ $edificio->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar Oficina</button>
                    <a href="{{ route('admin.oficinas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
