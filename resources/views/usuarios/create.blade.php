@extends('layouts.app')

@section('title', 'Registrar Usuario - UPTEX')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="mb-3 mb-md-4 mt-2 d-flex justify-content-between align-items-start align-items-md-center flex-wrap gap-2">
        <div class="flex-grow-1">
            <h2 class="fw-bold mb-1 mb-md-2"><i class="bi bi-person-plus text-primary me-2"></i> Registrar Nuevo Usuario</h2>
            <p class="text-muted small mb-0">Crea un nuevo usuario para el sistema de tickets.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary fw-bold shadow-sm btn-sm">
            <i class="bi bi-arrow-left me-1"></i> <span class="d-none d-sm-inline">Volver</span>
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm border-top border-4 border-primary">
                <div class="card-body p-3 p-md-4">
                    <form action="{{ route('admin.usuarios.store') }}" method="POST">
                        @csrf
                        <div class="row g-2 g-md-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Nombre(s):</label>
                                <input type="text" name="nombre" class="form-control" required placeholder="Ej. Juan" style="min-height: 44px;">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Apellido(s):</label>
                                <input type="text" name="apellido" class="form-control" required placeholder="Ej. Pérez" style="min-height: 44px;">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted text-uppercase">Correo Electrónico:</label>
                                <input type="email" name="correo" class="form-control" required placeholder="usuario@correo.com" style="min-height: 44px;">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Contraseña:</label>
                                <input type="password" name="password" class="form-control" required placeholder="Mínimo 6 caracteres" style="min-height: 44px;">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Confirmar Contraseña:</label>
                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Repite la contraseña" style="min-height: 44px;">
                            </div>
                        </div>
                        <div class="mt-3 mt-md-4 pt-3 border-top">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-bold shadow-sm" style="padding: 12px 20px; font-size: 16px;">
                                    <i class="bi bi-save me-1"></i> Guardar Usuario
                                </button>
                                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary fw-bold" style="padding: 12px 20px; font-size: 16px;">
                                    <i class="bi bi-x me-1"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection