@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="m-0"><i class="bi bi-pencil-square"></i> Editar Usuario</h2>
    <a href="{{ route('usuarios.show', $usuario['id_usuario']) }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Volver</span>
    </a>
</div>

<div class="row g-2 g-md-3 g-lg-4">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header bg-light">
                <i class="bi bi-person-badge"></i> Información del Usuario
            </div>
            <div class="card-body">
                <form action="{{ route('usuarios.update', $usuario['id_usuario']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="nombre" class="form-label fw-semibold">Nombre *</label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $usuario['nombre']) }}"
                                   required
                                   style="min-height: 44px;">
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="apellido" class="form-label fw-semibold">Apellido *</label>
                            <input type="text" 
                                   class="form-control @error('apellido') is-invalid @enderror" 
                                   id="apellido" 
                                   name="apellido" 
                                   value="{{ old('apellido', $usuario['apellido']) }}"
                                   required
                                   style="min-height: 44px;">
                            @error('apellido')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3 mb-md-4">
                        <label for="correo" class="form-label fw-semibold">Correo Electrónico *</label>
                        <input type="email" 
                               class="form-control @error('correo') is-invalid @enderror" 
                               id="correo" 
                               name="correo" 
                               value="{{ old('correo', $usuario['correo']) }}"
                               required
                               style="min-height: 44px;">
                        @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="password" class="form-label fw-semibold">Nueva Contraseña</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   placeholder="Dejar en blanco para no cambiar"
                                   style="min-height: 44px;">
                            <small class="text-muted d-block mt-1">Solo completa si deseas cambiar</small>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="id_rol" class="form-label fw-semibold">Rol *</label>
                            <select class="form-select @error('id_rol') is-invalid @enderror" 
                                    id="id_rol" 
                                    name="id_rol" 
                                    required
                                    style="min-height: 44px;">
                                @foreach($roles ?? [] as $rol)
                                <option value="{{ $rol['id_rol'] }}" 
                                        {{ (old('id_rol', $usuario['rol']['id_rol']) == $rol['id_rol']) ? 'selected' : '' }}>
                                    {{ $rol['nombre'] }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_rol')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3 mb-md-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="activo" 
                                   name="activo" 
                                   value="1"
                                   {{ old('activo', $usuario['activo']) ? 'checked' : '' }}
                                   style="width: 44px; height: 24px; cursor: pointer;">
                            <label class="form-check-label" for="activo">
                                Usuario activo
                            </label>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" style="padding: 12px 20px; font-size: 16px;">
                            <i class="bi bi-check-circle"></i> Guardar Cambios
                        </button>
                        <a href="{{ route('usuarios.show', $usuario['id_usuario']) }}" class="btn btn-secondary" style="padding: 12px 20px; font-size: 16px;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-4">
        <div class="card sticky-top" style="top: max(90px, clamp(1rem, 5vh, 2rem));">
            <div class="card-header bg-light">
                <i class="bi bi-info-circle"></i> Información
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <small class="text-muted d-block">Usuario ID:</small>
                    <strong>#{{ $usuario['id_usuario'] }}</strong>
                </p>
                
                <p class="mb-2">
                    <small class="text-muted d-block">Creado:</small>
                    <small>{{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y H:i') }}</small>
                </p>
                
                <p class="mb-0">
                    <small class="text-muted d-block">Última actualización:</small>
                    <small>{{ \Carbon\Carbon::parse($usuario['updated_at'])->format('d/m/Y H:i') }}</small>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection