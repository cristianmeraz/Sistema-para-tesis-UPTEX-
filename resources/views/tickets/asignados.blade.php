@extends('layouts.app')

@section('title', 'Panel de Trabajo')

@section('content')
<style>
    .stat-card-premium {
        background: white;
        padding: clamp(1rem, 4vw, 1.5rem);
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        text-align: center;
        border: none;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s;
        height: 100%;
    }
    .stat-card-premium:hover { transform: translateY(-5px); }
    
    .border-b-blue { border-bottom: 5px solid #3B82F6; }
    .border-b-yellow { border-bottom: 5px solid #F59E0B; }
    .border-b-purple { border-bottom: 5px solid #8B5CF6; }
    .border-b-green { border-bottom: 5px solid #10B981; }
    .border-b-red { border-bottom: 5px solid #EF4444; }
    .border-b-cyan { border-bottom: 5px solid #06B6D4; }

    .stat-label-caps {
        text-transform: uppercase;
        font-size: clamp(0.65rem, 1.5vw, 0.75rem);
        font-weight: 800;
        color: #64748B;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }
    .stat-value-large {
        font-size: clamp(1.5rem, 5vw, 2.2rem);
        font-weight: 800;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    .stat-icon-bg { 
        font-size: clamp(0.9rem, 2vw, 1.2rem); 
        opacity: 0.3; 
    }
    
    .table th, .table td {
        font-size: clamp(0.8rem, 2vw, 0.95rem);
    }
</style>

<div class="container-fluid px-2 px-md-4 py-2 py-md-4">
    <div class="row mb-2 mb-md-3 mb-lg-4">
        <div class="col-12">
            <h2 class="fw-bold" style="font-size: clamp(1.5rem, 5vw, 2rem);">
                <i class="bi bi-person-workspace text-primary me-2"></i>Panel de Trabajo
            </h2>
            <p class="text-muted small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Gestiona tus tickets y monitorea tu desempeño.</p>
        </div>
    </div>
    
    <!-- Estadísticas por Estado -->
    <div class="row g-2 g-md-3 mb-3 mb-md-4">
        <div class="col-12 col-sm-6 col-md-3 mb-2 mb-md-3">
            <div class="stat-card-premium border-b-blue">
                <div class="stat-label-caps">Total Asignados</div>
                <div class="stat-value-large text-primary">{{ $stats['totales'] }}</div>
                <i class="bi bi-folder2-open stat-icon-bg"></i>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-2 mb-md-3">
            <div class="stat-card-premium border-b-yellow">
                <div class="stat-label-caps">En Proceso</div>
                <div class="stat-value-large text-warning">{{ $stats['en_proceso'] }}</div>
                <i class="bi bi-gear-wide-connected stat-icon-bg"></i>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-2 mb-md-3">
            <div class="stat-card-premium border-b-purple">
                <div class="stat-label-caps">Pendientes</div>
                <div class="stat-value-large" style="color: #8B5CF6;">{{ $stats['pendientes'] }}</div>
                <i class="bi bi-pause-circle stat-icon-bg"></i>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-2 mb-md-3">
            <div class="stat-card-premium border-b-green">
                <div class="stat-label-caps">Resueltos</div>
                <div class="stat-value-large text-success">{{ $stats['resueltos'] }}</div>
                <i class="bi bi-check2-all stat-icon-bg"></i>
            </div>
        </div>
    </div>

    <!-- Carga por Prioridad -->
    <h6 class="fw-bold text-muted mb-2 mb-md-3" style="font-size: clamp(0.95rem, 2vw, 1rem);">
        <i class="bi bi-bar-chart-fill me-2"></i>Carga por Prioridad
    </h6>
    <div class="row g-2 g-md-3 mb-3 mb-md-5">
        <div class="col-12 col-sm-6 col-md-3 mb-2 mb-md-3">
            <div class="stat-card-premium border-b-cyan">
                <div class="stat-label-caps">Baja</div>
                <div class="stat-value-large" style="color: #06B6D4;">{{ $stats['baja'] }}</div>
                <i class="bi bi-arrow-down-short stat-icon-bg"></i>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-2 mb-md-3">
            <div class="stat-card-premium border-b-blue">
                <div class="stat-label-caps">Media</div>
                <div class="stat-value-large text-primary">{{ $stats['media'] }}</div>
                <i class="bi bi-dash stat-icon-bg"></i>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-2 mb-md-3">
            <div class="stat-card-premium border-b-purple">
                <div class="stat-label-caps">Alta</div>
                <div class="stat-value-large" style="color: #8B5CF6;">{{ $stats['alta'] }}</div>
                <i class="bi bi-exclamation-lg stat-icon-bg"></i>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-2 mb-md-3">
            <div class="stat-card-premium border-b-red">
                <div class="stat-label-caps">Crítica</div>
                <div class="stat-value-large text-danger">{{ $stats['critica'] }}</div>
                <i class="bi bi-fire stat-icon-bg"></i>
            </div>
        </div>
    </div>

    <!-- Tabla de Tickets -->
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white py-2 py-md-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="mb-0 fw-bold text-dark" style="font-size: clamp(0.95rem, 2vw, 1.1rem);">
                <i class="bi bi-list-stars me-2 text-primary"></i>Tickets por Atender
            </h6>
        </div>
        <div class="card-body p-0">
            @if(count($tickets) > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-2 ps-md-4">Folio</th>
                            <th class="d-none d-md-table-cell">Título</th>
                            <th class="d-none d-lg-table-cell">Prioridad</th>
                            <th class="d-none d-md-table-cell">Estado</th>
                            <th class="pe-2 pe-md-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                        <tr>
                            <td class="ps-2 ps-md-4"><strong>#{{ $ticket->id_ticket }}</strong></td>
                            <td class="d-none d-md-table-cell">
                                <div class="fw-bold text-dark">{{ Str::limit($ticket->titulo, 40) }}</div>
                                <small class="text-muted">{{ $ticket->usuario->nombre }} {{ $ticket->usuario->apellido }}</small>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="badge rounded-pill border text-dark p-1 p-md-2" style="font-size: clamp(0.7rem, 1.5vw, 0.8rem);">
                                    {{ $ticket->prioridad->nombre }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge p-1 p-md-2 bg-{{ $ticket->estado->tipo == 'en_proceso' ? 'warning text-dark' : ($ticket->estado->tipo == 'pendiente' ? 'info' : 'primary') }}" style="font-size: clamp(0.7rem, 1.5vw, 0.8rem);">
                                    {{ $ticket->estado->nombre }}
                                </span>
                            </td>
                            <td class="pe-2 pe-md-4 text-center">
                                <a href="{{ route('tickets.show', $ticket->id_ticket) }}" class="btn btn-sm btn-primary rounded-pill px-2 px-md-3 shadow-sm" style="min-height: 36px; font-size: clamp(0.75rem, 1.5vw, 0.85rem);">
                                    <i class="bi bi-pencil-square me-1"></i> <span class="d-none d-sm-inline">Gestionar</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4 py-md-5">
                <i class="bi bi-check-circle text-success" style="font-size: clamp(2.5rem, 10vw, 3.5rem); display: block; margin-bottom: 1rem;"></i>
                <p class="text-muted small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">¡Todo al día! No tienes tickets pendientes.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection