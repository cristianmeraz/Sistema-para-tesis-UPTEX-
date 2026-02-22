@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle"></i> Corrige los errores:
    <ul class="mb-0 mt-2 small">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
    <h2 style="font-size: clamp(1.5rem, 5vw, 2rem); font-weight: 700;" class="m-0"><i class="bi bi-person-circle"></i> Mi Perfil</h2>
</div>

<div class="row g-2 g-md-3 g-lg-4">
    <div class="col-12 col-lg-4">
        <!-- Tarjeta Perfil -->
        <div class="card border-0 shadow-lg h-100" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
            <div class="card-body text-center p-3 p-md-4 p-lg-5">
                <div class="mb-3 mb-md-4">
                    <i class="bi bi-person-circle" style="font-size: clamp(3rem, 20vw, 6rem); color: #0d6efd;"></i>
                </div>
                <h3 class="fw-bold mb-2" style="font-size: clamp(1.1rem, 3vw, 1.4rem);">{{ $usuario['nombre'] }} {{ $usuario['apellido'] }}</h3>
                <p class="text-muted mb-3 mb-md-4 small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">{{ $usuario['correo'] }}</p>
                
                @if($usuario['rol']['nombre'] == 'Administrador')
                    <span class="badge bg-danger px-2 px-md-3 py-1 py-md-2" style="font-size: clamp(0.75rem, 1.5vw, 0.95rem);">{{ $usuario['rol']['nombre'] }}</span>
                @elseif($usuario['rol']['nombre'] == 'Técnico')
                    <span class="badge bg-warning px-2 px-md-3 py-1 py-md-2" style="font-size: clamp(0.75rem, 1.5vw, 0.95rem); color: #000;">{{ $usuario['rol']['nombre'] }}</span>
                @else
                    <span class="badge bg-secondary px-2 px-md-3 py-1 py-md-2" style="font-size: clamp(0.75rem, 1.5vw, 0.95rem);">{{ $usuario['rol']['nombre'] }}</span>
                @endif
            </div>
        </div>
        
        <!-- Tarjeta Información -->
        <div class="card border-0 shadow-lg mt-2 mt-md-3 mt-lg-4" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-2 py-md-3">
                <h6 class="mb-0 fw-bold small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">
                    <i class="bi bi-clock-history me-2"></i> 
                    <span class="d-none d-md-inline">Información</span> de Cuenta
                </h6>
            </div>
            <div class="card-body p-2 p-md-3 p-lg-4 small">
                <div class="mb-3">
                    <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">Miembro desde:</p>
                    <p class="mb-0 fw-bold" style="font-size: clamp(0.9rem, 2vw, 1rem);">{{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y') }}</p>
                </div>
                
                <div>
                    <p class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 600;">
                        @if(str_contains(session('usuario_rol'), 'Técnico'))
                            Último acceso:
                        @else
                            Última actualización:
                        @endif
                    </p>
                    <p class="mb-0 fw-bold" style="font-size: clamp(0.9rem, 2vw, 1rem);">
                        @if(str_contains(session('usuario_rol'), 'Técnico'))
                            @if($usuario['last_login'])
                                {{ \Carbon\Carbon::parse($usuario['last_login'])->setTimezone('America/Mexico_City')->format('d/m/Y H:i') }}
                            @else
                                Sin acceso aún
                            @endif
                        @else
                            {{ \Carbon\Carbon::parse($usuario['updated_at'])->diffForHumans() }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-8">
        <!-- Tarjeta Edición -->
        <div class="card border-0 shadow-lg h-100" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-2 py-md-3">
                <h6 class="mb-0 fw-bold small" style="font-size: clamp(0.95rem, 2vw, 1.1rem);">
                    <i class="bi bi-pencil-square me-2"></i> <span class="d-none d-sm-inline">Editar</span> Información
                </h6>
            </div>
            <div class="card-body p-2 p-md-4 p-lg-5">
                <form action="{{ route('perfil.update') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="nombre" class="form-label fw-600 mb-2 small" style="font-size: 0.85rem;">Nombre</label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $usuario['nombre']) }}"
                                   autocomplete="off"
                                   style="min-height: 44px; font-size: 0.95rem; border-radius: 8px; border: 1px solid #dee2e6;">
                            @error('nombre')
                            <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="apellido" class="form-label fw-600 mb-2 small" style="font-size: 0.85rem;">Apellido</label>
                            <input type="text" 
                                   class="form-control @error('apellido') is-invalid @enderror" 
                                   id="apellido" 
                                   name="apellido" 
                                   value="{{ old('apellido', $usuario['apellido']) }}"
                                   autocomplete="off"
                                   style="min-height: 44px; font-size: 0.95rem; border-radius: 8px; border: 1px solid #dee2e6;">
                            @error('apellido')
                            <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3 mb-md-4">
                        <label for="correo" class="form-label fw-600 mb-2 small" style="font-size: 0.85rem;">Correo Electrónico</label>
                        <input type="email" 
                               class="form-control @error('correo') is-invalid @enderror" 
                               id="correo" 
                               name="correo" 
                               value="{{ old('correo', $usuario['correo']) }}"
                               autocomplete="off"
                               style="min-height: 44px; font-size: 0.95rem; border-radius: 8px; border: 1px solid #dee2e6;">
                        @error('correo')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <hr style="margin: 1.5rem 0;">
                    
                    <h6 class="fw-bold mb-3 mb-md-4 small" style="font-size: clamp(0.95rem, 2vw, 1.1rem);">Cambiar Contraseña</h6>
                    
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="password" class="form-label fw-600 mb-2 small" style="font-size: 0.85rem;">Nueva Contraseña</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   autocomplete="off"
                                   style="min-height: 44px; font-size: 0.95rem; border-radius: 8px; border: 1px solid #dee2e6;">
                            @error('password')
                            <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="password_confirmation" class="form-label fw-600 mb-2 small" style="font-size: 0.85rem;">Confirmar Contraseña</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   autocomplete="off"
                                   style="min-height: 44px; font-size: 0.95rem; border-radius: 8px; border: 1px solid #dee2e6;">
                        </div>
                    </div>
                    
                    <hr style="margin: 1.5rem 0;">
                    
                    <button type="submit" class="btn btn-primary fw-bold w-100 py-2 py-md-3" style="font-size: clamp(0.95rem, 2vw, 1rem); border-radius: 8px; min-height: 44px;">
                        <i class="bi bi-check-circle me-2"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection