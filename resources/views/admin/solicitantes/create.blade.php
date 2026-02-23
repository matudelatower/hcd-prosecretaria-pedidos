@extends('layouts.admin')

@section('title', 'Nuevo Solicitante')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.solicitantes.index') }}">Solicitantes</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Crear Nuevo Solicitante</h3>
            </div>
            <form method="POST" action="{{ route('admin.solicitantes.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        <small class="form-text text-muted">Nombre completo del solicitante o dependencia</small>
                    </div>

                    <div class="form-group">
                        <label for="cargo">Cargo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" value="{{ old('cargo') }}">
                        <small class="form-text text-muted">Ej: Concejal, Secretario, Jefe de Departamento, etc.</small>
                    </div>

                    <div class="form-group">
                        <label for="dependencia">Dependencia</label>
                        <input type="text" class="form-control" id="dependencia" name="dependencia" value="{{ old('dependencia') }}">
                        <small class="form-text text-muted">Ej: Honorable Concejo Deliberante, Municipalidad, etc.</small>
                    </div>

                    <div class="form-group">
                        <label for="notas">Notas</label>
                        <textarea class="form-control" id="notas" name="notas" rows="3">{{ old('notas') }}</textarea>
                        <small class="form-text text-muted">Información adicional relevante</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="activo">Solicitante Activo</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar Solicitante</button>
                    <a href="{{ route('admin.solicitantes.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
