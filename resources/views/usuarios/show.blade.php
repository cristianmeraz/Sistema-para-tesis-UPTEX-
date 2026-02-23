@extends('layouts.app')

@section('title', 'Detalle del Usuario')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <h2 class="m-0"><i class="bi bi-person-badge"></i> Detalle del Usuario</h2>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('usuarios.edit', $usuario['id_usuario']) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Editar</span>
        </a>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Volver</span>
        </a>
    </div>
</div>

<div class="row g-2 g-md-3 g-lg-4">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center p-3 p-md-4">
                <div class="mb-3">
                    <i class="bi bi-person-circle" style="font-size: clamp(3rem, 20vw, 5rem); color: var(--primary-color);"></i>
                </div>
                <h4 style="font-size: clamp(1.1rem, 2vw, 1.3rem);">{{ $usuario['nombre'] }} {{ $usuario['apellido'] }}</h4>
                <p class="text-muted small" style="font-size: clamp(0.9rem, 2vw, 1rem);">{{ $usuario['correo'] }}</p>
                
                @if($usuario['rol']['nombre'] == 'Administrador')
                    <span class="badge bg-danger" style="font-size: clamp(0.85rem, 1.5vw, 1rem);">{{ $usuario['rol']['nombre'] }}</span>
                @elseif($usuario['rol']['nombre'] == 'Técnico')
                    <span class="badge bg-warning" style="font-size: clamp(0.85rem, 1.5vw, 1rem);">{{ $usuario['rol']['nombre'] }}</span>
                @else
                    <span class="badge bg-secondary" style="font-size: clamp(0.85rem, 1.5vw, 1rem);">{{ $usuario['rol']['nombre'] }}</span>
                @endif
                
                <hr>
                
                <div class="d-grid gap-2">
                    @if($usuario['activo'])
                        <span class="badge bg-success py-2" style="font-size: clamp(0.85rem, 1.5vw, 1rem);">
                            <i class="bi bi-check-circle"></i> <span class="d-none d-sm-inline">Activo</span>
                        </span>
                    @else
                        <span class="badge bg-danger py-2" style="font-size: clamp(0.85rem, 1.5vw, 1rem);">
                            <i class="bi bi-x-circle"></i> <span class="d-none d-sm-inline">Inactivo</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card mt-2 mt-md-3">
            <div class="card-header bg-light py-2 py-md-3">
                <i class="bi bi-clock-history"></i> <span class="d-none d-sm-inline">Información de</span> Cuenta
            </div>
            <div class="card-body p-3 p-md-4 small">
                <p class="mb-2"><small class="text-muted d-block">Creado:</small>
                {{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y H:i') }}</p>
                
                <p class="mb-0"><small class="text-muted d-block">Última actualización:</small>
                {{ \Carbon\Carbon::parse($usuario['updated_at'])->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-8">
        <!-- Estadísticas de Tickets -->
        <div class="card mb-2 mb-md-3">
            <div class="card-header bg-light py-2 py-md-3">
                <i class="bi bi-bar-chart"></i> <span class="d-none d-sm-inline">Estadísticas de</span> Tickets
            </div>
            <div class="card-body p-2 p-md-4">
                <div class="row g-2 g-md-3">
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <div class="stat-card primary p-3 p-md-4 rounded" style="background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%); color: white; text-align: center;">
                            <div class="stat-number" style="font-size: clamp(1.8rem, 5vw, 2.5rem); font-weight: bold;">{{ count($usuario['tickets'] ?? []) }}</div>
                            <div class="stat-label" style="font-size: clamp(0.9rem, 2vw, 1rem);">
                                <i class="bi bi-ticket"></i> Tickets Creados
                            </div>
                        </div>
                    </div>
                    
                    @if($usuario['rol']['nombre'] == 'Técnico')
                    <div class="col-12 col-md-6">
                        <div class="stat-card warning p-3 p-md-4 rounded" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); color: white; text-align: center;">
                            <div class="stat-number" style="font-size: clamp(1.8rem, 5vw, 2.5rem); font-weight: bold;">{{ count($usuario['tickets_asignados'] ?? []) }}</div>
                            <div class="stat-label" style="font-size: clamp(0.9rem, 2vw, 1rem);">
                                <i class="bi bi-clipboard-check"></i> Asignados
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Tickets Recientes -->
        <div class="card">
            <div class="card-header bg-light py-2 py-md-3">
                <i class="bi bi-ticket"></i> <span class="d-none d-sm-inline">Tickets</span> Recientes
            </div>
            <div class="card-body p-0 p-md-3">
                <!-- Vista Desktop (Tabla) -->
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th style="min-width: 50px;">ID</th>
                                <th style="min-width: 150px;">Título</th>
                                <th style="min-width: 100px;">Estado</th>
                                <th style="min-width: 100px;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(collect($usuario->tickets ?? [])->take(5) as $ticket)
                            <tr>
                                <td>#{{ $ticket['id_ticket'] }}</td>
                                <td>{{ Str::limit($ticket['titulo'], 40) }}</td>
                                <td>
                                    <span class="badge badge-estado-{{ $ticket['estado']['tipo'] ?? 'abierto' }}">
                                        {{ $ticket['estado']['nombre'] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($ticket['fecha_creacion'])->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    No hay tickets recientes
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Vista Móvil (Cards) -->
                <div class="d-md-none">
                    @forelse(collect($usuario->tickets ?? [])->take(5) as $ticket)
                    <div class="card card-sm mb-2 border-start border-4" style="border-left-color: var(--primary) !important;">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-1 small">
                                        <strong>#{{ $ticket['id_ticket'] }}</strong> {{ Str::limit($ticket['titulo'], 30) }}
                                    </h6>
                                    <small class="text-muted d-block">{{ \Carbon\Carbon::parse($ticket['fecha_creacion'])->format('d/m/Y') }}</small>
                                </div>
                                <span class="badge badge-estado-{{ $ticket['estado']['tipo'] ?? 'abierto' }} ms-2">
                                    {{ $ticket['estado']['nombre'] ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        <p class="mb-0 small">No hay tickets recientes</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection