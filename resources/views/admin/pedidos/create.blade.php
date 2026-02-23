@extends('layouts.admin')

@section('title', 'Nuevo Pedido')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.pedidos.index') }}">Pedidos</a></li>
    <li class="breadcrumb-item active">Nuevo</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Crear Nuevo Pedido</h3>
            </div>
            <form method="POST" action="{{ route('admin.pedidos.store') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="numero_expediente">Número de Expediente</label>
                        <input type="text" class="form-control" id="numero_expediente" name="numero_expediente" value="{{ old('numero_expediente') }}">
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="fecha_solicitud">Fecha de Solicitud <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" value="{{ old('fecha_solicitud', now()->format('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="solicitado_por_id">Solicitado Por <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-control select2" id="solicitado_por_id" name="solicitado_por_id" required>
                                <option value="">Seleccione un solicitante...</option>
                                @if(old('solicitado_por_id'))
                                <option value="{{ old('solicitado_por_id') }}" selected>{{ old('solicitado_por_nombre') }}</option>
                                @endif
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#modalNuevoSolicitante">
                                    <i class="fas fa-plus"></i> Nuevo
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Busque por nombre, cargo o dependencia. Si no encuentra, haga clic en "Nuevo"</small>
                    </div>

                    <div class="form-group">
                        <label for="area_destino_id">Área Destino <span class="text-danger">*</span></label>
                        <select class="form-control" id="area_destino_id" name="area_destino_id" required>
                            <option value="">Seleccione...</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ old('area_destino_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Guardar Pedido</button>
                    <a href="{{ route('admin.pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para nuevo solicitante -->
<div class="modal fade" id="modalNuevoSolicitante" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Solicitante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formNuevoSolicitante">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modal_nombre">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="modal_cargo">Cargo</label>
                        <input type="text" class="form-control" id="modal_cargo" name="cargo">
                    </div>
                    <div class="form-group">
                        <label for="modal_dependencia">Dependencia</label>
                        <input type="text" class="form-control" id="modal_dependencia" name="dependencia">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Configurar CSRF token para AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Inicializar Select2 para solicitantes
    $('#solicitado_por_id').select2({
        theme: 'bootstrap4',
        dropdownParent: $('#modalNuevoSolicitante').length ? $('#modalNuevoSolicitante').parent() : $(document.body),
        ajax: {
            url: "{{ route('admin.solicitantes.search') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                console.log('Buscando:', params.term);
                return {
                    q: params.term,
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                console.log('Resultados:', data);
                params.page = params.page || 1;
                
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.nombre,
                            nombre: item.nombre,
                            cargo: item.cargo,
                            dependencia: item.dependencia
                        };
                    })
                };
            },
            cache: true,
            error: function(xhr, status, error) {
                console.error('Error en AJAX:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
                
                // Si es error de autenticación, mostrar mensaje claro
                if (xhr.status === 401) {
                    console.error('Error de autenticación - verifica que estés logueado');
                }
            }
        },
        placeholder: 'Busque un solicitante...',
        allowClear: true,
        minimumInputLength: 2,
        language: 'es',
        templateResult: function(item) {
            if (item.loading) {
                return 'Buscando...';
            }
            
            // Solo mostrar el nombre, sin HTML
            return item.nombre;
        },
        templateSelection: function(item) {
            // Solo mostrar el nombre en el select seleccionado
            return item.nombre || item.text;
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });

    // Formulario para nuevo solicitante
    $('#formNuevoSolicitante').submit(function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        console.log('Enviando formulario:', formData);
        
        $.ajax({
            url: "{{ route('admin.solicitantes.storeQuick') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                console.log('Respuesta exitosa:', response);
                if (response.success) {
                    // Crear nueva opción para Select2
                    var newOption = new Option(response.solicitante.nombre, response.solicitante.id, true, true);
                    $('#solicitado_por_id').append(newOption).trigger('change');
                    
                    // Cerrar modal y limpiar formulario
                    $('#modalNuevoSolicitante').modal('hide');
                    $('#formNuevoSolicitante')[0].reset();
                    
                    // Mostrar mensaje de éxito
                    alert('Solicitante creado correctamente');
                }
            },
            error: function(xhr) {
                console.error('Error al crear solicitante:', xhr);
                var errorMessage = 'Error al crear solicitante';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                }
                alert(errorMessage);
            }
        });
    });
});
</script>
@endpush
@endsection
