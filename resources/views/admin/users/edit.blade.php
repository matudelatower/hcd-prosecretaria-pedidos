@extends('layouts.admin')

@section('title', 'Editar Usuario')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Usuario</h3>
            </div>
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Dejar en blanco para mantener la actual">
                        <small class="form-text text-muted">Complete solo si desea cambiar la contraseña</small>
                    </div>

                    <div class="form-group">
                        <label for="oficina_id">Oficina</label>
                        <select class="form-control" id="oficina_id" name="oficina_id">
                            <option value="">Seleccione...</option>
                            @foreach($oficinas as $oficina)
                            <option value="{{ $oficina->id }}" {{ old('oficina_id', $user->oficina_id) == $oficina->id ? 'selected' : '' }}>
                                {{ $oficina->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="roles">Roles <span class="text-danger">*</span></label>
                        @foreach($roles as $role)
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->id }}" 
                                   {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="role_{{ $role->id }}">
                                {{ ucfirst($role->name) }}
                                @if($role->description)
                                    <small class="text-muted">({{ $role->description }})</small>
                                @endif
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo', $user->activo) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="activo">Usuario Activo</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
