@extends('layouts.app')

@section('title', 'Mi Dashboard')

@section('content')
<style>
    .stat-card {
        background: white;
        padding: clamp(1rem, 4vw, 1.5rem);
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    
    .stat-icon {
        width: clamp(2.5rem, 8vw, 3rem);
        height: clamp(2.5rem, 8vw, 3rem);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(1rem, 3vw, 1.25rem);
        margin-bottom: clamp(0.75rem, 2vw, 1rem);
    }

    .stat-value {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: 800;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #64748B;
        font-size: clamp(0.75rem, 2vw, 0.9rem);
        font-weight: 500;
    }
    
    .table th, .table td {
        font-size: clamp(0.8rem, 2vw, 0.95rem);
    }
</style>

<div class="container-fluid px-2 px-md-4 py-2 py-md-4">
    <div class="row">
        <!-- HEADER -->
        <div class="col-12 mb-2 mb-md-3 mb-lg-4">
            <h2 style="font-size: clamp(1.3rem, 4vw, 1.8rem);">¡Hola, {{ session('usuario_nombre') }}!</h2>
            <p class="text-muted small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Bienvenido a tu panel de tickets</p>
        </div>
        
        <!-- BOTÓN PRINCIPAL CREAR TICKET -->
        <div class="col-12 mb-2 mb-md-3 mb-lg-4">
            <div class="card border-0" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); color: white; border-radius: 15px;">
                <div class="card-body p-3 p-md-5 text-center">
                    <i class="bi bi-plus-circle" style="font-size: clamp(2.5rem, 10vw, 4rem); margin-bottom: clamp(0.75rem, 2vw, 1.5rem); display: block;"></i>
                    <h3 class="mb-2 mb-md-3" style="font-size: clamp(1.2rem, 3vw, 1.5rem);">¿Necesitas ayuda?</h3>
                    <p class="mb-3 mb-md-4 small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Crea un nuevo ticket de soporte y nuestro equipo te ayudará</p>
                    <a href="{{ route('tickets.create') }}" class="btn btn-light fw-bold py-2 py-md-3 px-3 px-md-5" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 1rem);">
                        <i class="bi bi-plus-circle me-2"></i>
                        Crear Nuevo Ticket
                    </a>
                </div>
            </div>
        </div>
        
        <!-- ESTADÍSTICAS RÁPIDAS -->
        <div class="col-12 col-sm-6 col-md-4 mb-2 mb-md-3 mb-lg-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #EEF2FF; color: #4F46E5;">
                    <i class="bi bi-ticket"></i>
                </div>
                <div class="stat-value" style="color: #4F46E5;">{{ $stats['total'] ?? 0 }}</div>
                <div class="stat-label">Total de Tickets</div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-4 mb-2 mb-md-3 mb-lg-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #FEF3C7; color: #F59E0B;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-value" style="color: #F59E0B;">{{ $stats['abiertos'] ?? 0 }}</div>
                <div class="stat-label">En Proceso</div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-4 mb-3 mb-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #D1FAE5; color: #10B981;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-value" style="color: #10B981;">{{ $stats['cerrados'] ?? 0 }}</div>
                <div class="stat-label">Resueltos</div>
            </div>
        </div>
        
        <!-- MIS TICKETS RECIENTES -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white py-2 py-md-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="mb-0 fw-bold" style="font-size: clamp(0.95rem, 2vw, 1.1rem);">
                        <i class="bi bi-list-task me-2"></i>Mis Tickets Recientes
                    </h6>
                    <a href="{{ route('tickets.mis-tickets') }}" class="btn btn-sm btn-primary px-2 px-md-3 py-1 py-md-2" style="min-height: 36px; font-size: clamp(0.75rem, 1.5vw, 0.85rem);">Ver Todos</a>
                </div>
                <div class="card-body p-0">
                    @if(!empty($tickets) && count($tickets) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-2 ps-md-3">ID</th>
                                    <th class="d-none d-md-table-cell">Título</th>
                                    <th class="d-none d-lg-table-cell">Estado</th>
                                    <th class="d-none d-lg-table-cell">Prioridad</th>
                                    <th class="d-none d-md-table-cell">Fecha</th>
                                    <th class="pe-2 pe-md-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td class="ps-2 ps-md-3"><strong>#{{ $ticket->id_ticket }}</strong></td>
                                    <td class="d-none d-md-table-cell" style="font-size: clamp(0.8rem, 2vw, 0.9rem);">{{ Str::limit($ticket->titulo, 40) }}</td>
                                    <td class="d-none d-lg-table-cell">
                                        <span class="badge badge-estado-{{ $ticket->estado->tipo ?? 'abierto' }}" style="font-size: clamp(0.7rem, 1.5vw, 0.8rem);">
                                            {{ $ticket->estado->nombre ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span class="badge badge-prioridad-{{ $ticket->prioridad->nivel ?? 1 }}" style="font-size: clamp(0.7rem, 1.5vw, 0.8rem);">
                                            {{ $ticket->prioridad->nombre ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell" style="font-size: clamp(0.8rem, 2vw, 0.9rem);">{{ $ticket->fecha_creacion ? $ticket->fecha_creacion->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="pe-2 pe-md-3 text-center">
                                        <a href="{{ route('tickets.show', $ticket->id_ticket) }}" class="btn btn-sm btn-info text-white" title="Ver" style="min-width: 36px; min-height: 36px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4 py-md-5">
                        <i class="bi bi-inbox text-muted" style="font-size: clamp(2.5rem, 10vw, 4rem); display: block; margin-bottom: 1rem;"></i>
                        <p class="text-muted small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">No has creado ningún ticket aún</p>
                        <a href="{{ route('tickets.create') }}" class="btn btn-primary py-2 py-md-3 px-3 px-md-4 mt-2" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 0.95rem);">
                            <i class="bi bi-plus-circle me-2"></i>Crear tu Primer Ticket
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection