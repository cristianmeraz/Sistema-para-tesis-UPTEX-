@extends('layouts.app')

@section('title', 'Panel de Administración - UPTEX')

@section('content')
<style>
    .card { transition: transform 0.2s; border-radius: 12px; }
    .card:hover { transform: translateY(-3px); }
    .animate-pulse { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { opacity: 0.5; } 50% { opacity: 1; } 100% { opacity: 0.5; } }
</style>

<div class="container-fluid px-2 px-md-4 py-2 py-md-4">
    <div class="mb-3 mb-md-4 mt-2">
        <h2 class="fw-bold d-flex align-items-center" style="font-size: clamp(1.5rem, 5vw, 2rem);">
            <i class="bi bi-gear-wide-connected me-2 text-primary"></i> Panel de Administración
        </h2>
        <p class="text-muted small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Gestión de métricas generales de UPTEX Tickets.</p>
    </div>

    <!-- Primera fila: 6 estadísticas principales -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4 text-center">
        <div class="col-12 col-sm-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100 border-bottom border-4 border-primary">
                <div class="card-body p-2 p-md-3 p-lg-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2" style="font-size: 0.75rem;">Usuarios</h6>
                    <h2 class="fw-bold mb-2 text-primary" style="font-size: clamp(1.5rem, 4vw, 2rem);">{{ $stats['total_usuarios'] ?? '0' }}</h2>
                    <i class="bi bi-people" style="font-size: clamp(1.2rem, 3vw, 1.5rem); opacity: 0.25;"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100 border-bottom border-4 border-warning">
                <div class="card-body p-2 p-md-3 p-lg-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2 text-warning" style="font-size: 0.75rem;">Técnicos</h6>
                    <h2 class="fw-bold mb-2 text-warning" style="font-size: clamp(1.5rem, 4vw, 2rem);">{{ $stats['tecnicos'] ?? '0' }}</h2>
                    <i class="bi bi-person-badge text-warning" style="font-size: clamp(1.2rem, 3vw, 1.5rem); opacity: 0.25;"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100 border-bottom border-4" style="border-color: #6f42c1 !important;">
                <div class="card-body p-2 p-md-3 p-lg-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2" style="color: #6f42c1; font-size: 0.75rem;">U. Normales</h6>
                    <h2 class="fw-bold mb-2" style="color: #6f42c1; font-size: clamp(1.5rem, 4vw, 2rem);">{{ $stats['usuarios_normales'] ?? '0' }}</h2>
                    <i class="bi bi-person" style="color: #6f42c1; font-size: clamp(1.2rem, 3vw, 1.5rem); opacity: 0.25;"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100 border-bottom border-4 border-info">
                <div class="card-body p-2 p-md-3 p-lg-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2 text-info" style="font-size: 0.75rem;">Tickets</h6>
                    <h2 class="fw-bold mb-2 text-info" style="font-size: clamp(1.5rem, 4vw, 2rem);">{{ $stats['total_tickets'] ?? '0' }}</h2>
                    <i class="bi bi-ticket-perforated text-info" style="font-size: clamp(1.2rem, 3vw, 1.5rem); opacity: 0.25;"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100 border-bottom border-4 border-success">
                <div class="card-body p-2 p-md-3 p-lg-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2 text-success" style="font-size: 0.75rem;">Abiertos</h6>
                    <h2 class="fw-bold mb-2 text-success" style="font-size: clamp(1.5rem, 4vw, 2rem);">{{ $stats['tickets_abiertos'] ?? '0' }}</h2>
                    <i class="bi bi-envelope-open text-success" style="font-size: clamp(1.2rem, 3vw, 1.5rem); opacity: 0.25;"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100 border-bottom border-4 border-danger">
                <div class="card-body p-2 p-md-3 p-lg-3">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2 text-danger" style="font-size: 0.75rem;">Cerrados</h6>
                    <h2 class="fw-bold mb-2 text-danger" style="font-size: clamp(1.5rem, 4vw, 2rem);">{{ $stats['tickets_cerrados'] ?? '0' }}</h2>
                    <i class="bi bi-check2-circle text-danger" style="font-size: clamp(1.2rem, 3vw, 1.5rem); opacity: 0.25;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribución por prioridad -->
    <h5 class="fw-bold mb-2 mb-md-3 text-secondary" style="font-size: clamp(0.95rem, 2vw, 1.1rem);">
        <i class="bi bi-tags-fill me-2"></i>Distribución por Prioridad
    </h5>
    <div class="row g-2 g-md-3 mb-3 mb-md-4 text-center">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-info">
                <div class="card-body d-flex justify-content-between align-items-center p-2 p-md-3 p-lg-3">
                    <div class="text-start">
                        <h6 class="text-muted small fw-bold mb-1" style="font-size: 0.75rem;">Baja</h6>
                        <h2 class="fw-bold mb-0" style="font-size: clamp(1.3rem, 3vw, 1.8rem);">{{ $stats['prioridad_baja'] ?? '0' }}</h2>
                    </div>
                    <i class="bi bi-arrow-down-circle text-info" style="font-size: clamp(1.5rem, 4vw, 2rem); opacity: 0.5;"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-primary">
                <div class="card-body d-flex justify-content-between align-items-center p-2 p-md-3 p-lg-3">
                    <div class="text-start">
                        <h6 class="text-muted small fw-bold mb-1" style="font-size: 0.75rem;">Media</h6>
                        <h2 class="fw-bold mb-0 text-primary" style="font-size: clamp(1.3rem, 3vw, 1.8rem);">{{ $stats['prioridad_media'] ?? '0' }}</h2>
                    </div>
                    <i class="bi bi-dash-circle text-primary" style="font-size: clamp(1.5rem, 4vw, 2rem); opacity: 0.5;"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-warning">
                <div class="card-body d-flex justify-content-between align-items-center p-2 p-md-3 p-lg-3">
                    <div class="text-start">
                        <h6 class="text-muted small fw-bold mb-1 text-warning" style="font-size: 0.75rem;">Alta</h6>
                        <h2 class="fw-bold mb-0 text-warning" style="font-size: clamp(1.3rem, 3vw, 1.8rem);">{{ $stats['prioridad_alta'] ?? '0' }}</h2>
                    </div>
                    <i class="bi bi-exclamation-circle text-warning" style="font-size: clamp(1.5rem, 4vw, 2rem); opacity: 0.5;"></i>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
                <div class="card-body d-flex justify-content-between align-items-center p-2 p-md-3 p-lg-3">
                    <div class="text-start">
                        <h6 class="text-muted small fw-bold mb-1 text-danger" style="font-size: 0.75rem;">Crítica</h6>
                        <h2 class="fw-bold mb-0 text-danger" style="font-size: clamp(1.3rem, 3vw, 1.8rem);">{{ $stats['prioridad_critica'] ?? '0' }}</h2>
                    </div>
                    <i class="bi bi-fire text-danger animate-pulse" style="font-size: clamp(1.5rem, 4vw, 2rem); opacity: 0.5;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones y Actividad -->
    <div class="row g-2 g-md-3">
        <div class="col-12 col-lg-6 mb-2 mb-md-3 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-2 py-md-3 border-0">
                    <h6 class="card-title mb-0 fw-bold" style="font-size: clamp(0.95rem, 2vw, 1.1rem);">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>Acciones Rápidas
                    </h6>
                </div>
                <div class="card-body d-grid gap-2 gap-md-3 pt-0 p-2 p-md-3 p-lg-4">
                    <a href="{{ route('admin.tecnicos.create') }}" class="btn btn-primary py-2 py-md-3 fw-bold shadow-sm" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 0.95rem);">
                        <i class="bi bi-person-plus-fill me-2"></i><span class="d-none d-sm-inline">Crear Nuevo</span> Técnico
                    </a>
                    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-outline-primary py-2 py-md-3 fw-bold" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 0.95rem);">
                        <i class="bi bi-people-fill me-2"></i><span class="d-none d-sm-inline">Crear Nuevo</span> Usuario
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-2 py-md-3 border-0">
                    <h6 class="card-title mb-0 fw-bold" style="font-size: clamp(0.95rem, 2vw, 1.1rem);">
                        <i class="bi bi-clock-history text-info me-2"></i>Actividad Reciente
                    </h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-muted p-3 p-md-4 p-lg-5 pt-0">
                    <i class="bi bi-inbox" style="font-size: clamp(2rem, 8vw, 3rem); opacity: 0.25; margin-bottom: 1rem;"></i>
                    <p class="mb-0 small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">No hay actividad reciente para mostrar.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection