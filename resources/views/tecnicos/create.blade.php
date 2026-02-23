@extends('layouts.app')

@section('title', 'Registrar Técnico - UPTEX')

@section('content')
<div class="container-fluid px-2 px-md-4 py-2 py-md-4">
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4 flex-wrap gap-2">
        <h2 class="fw-bold text-primary" style="font-size: clamp(1.5rem, 5vw, 2rem);">
            <i class="bi bi-person-badge me-2"></i>Nuevo Personal Técnico
        </h2>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary fw-bold py-2 py-md-3 px-3 px-md-4" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 0.95rem);">
            Volver
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-2 p-md-4 p-lg-5">
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Corrige los errores:</strong>
                <ul class="mb-0 mt-2 small">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('admin.tecnicos.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_rol" value="2">

                <div class="row g-2 g-md-3 g-lg-4">
                    <div class="col-12 col-md-6 mb-2 mb-md-3 mb-lg-4">
                        <label class="form-label fw-bold small mb-2" style="font-size: 0.85rem;">Nombre(s):</label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               name="nombre" 
                               value="{{ old('nombre') }}"
                               required
                               style="min-height: 44px; font-size: 0.95rem; border-radius: 8px;">
                        @error('nombre')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12 col-md-6 mb-2 mb-md-3 mb-lg-4">
                        <label class="form-label fw-bold small mb-2" style="font-size: 0.85rem;">Apellido(s):</label>
                        <input type="text" 
                               class="form-control @error('apellido') is-invalid @enderror" 
                               name="apellido" 
                               value="{{ old('apellido') }}"
                               required
                               style="min-height: 44px; font-size: 0.95rem; border-radius: 8px;">
                        @error('apellido')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12 mb-2 mb-md-3 mb-lg-4">
                        <label class="form-label fw-bold small mb-2" style="font-size: 0.85rem;">Correo Institucional:</label>
                        <input type="email" 
                               class="form-control @error('correo') is-invalid @enderror" 
                               name="correo" 
                               value="{{ old('correo') }}"
                               required
                               style="min-height: 44px; font-size: 0.95rem; border-radius: 8px;">
                        @error('correo')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12 col-md-6 mb-2 mb-md-3 mb-lg-4">
                        <label class="form-label fw-bold small mb-2" style="font-size: 0.85rem;">Contraseña:</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               required
                               style="min-height: 44px; font-size: 0.95rem; border-radius: 8px;">
                        @error('password')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12 col-md-6 mb-3 mb-md-4 mb-lg-5">
                        <label class="form-label fw-bold small mb-2" style="font-size: 0.85rem;">Confirmar Contraseña:</label>
                        <input type="password" 
                               class="form-control" 
                               name="password_confirmation" 
                               required
                               style="min-height: 44px; font-size: 0.95rem; border-radius: 8px;">
                    </div>
                </div>

                <hr style="margin: 1.5rem 0;">

                <div class="d-flex gap-2 gap-md-3 flex-wrap justify-content-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary fw-bold py-2 py-md-3 px-3 px-md-4" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 0.95rem);">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary fw-bold py-2 py-md-3 px-3 px-md-5" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 0.95rem);">
                        <i class="bi bi-check-circle me-2"></i>Registrar Técnico
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection