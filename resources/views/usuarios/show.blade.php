@extends('layouts.app')

@section('title', 'Detalle del Usuario')

@section('content')
<style>
    .profile-card {
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: none;
    }
    
    .stat-card {
        border-radius: 12px;
        padding: 1.5rem;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .stat-card.primary {
        background: linear-gradient(135deg, #DBEAFE 0%, #E0E7FF 100%);
    }
    
    .stat-card.warning {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1F2937;
    }
    
    .stat-label {
        font-size: 0.95rem;
        color: #6B7280;
        margin-top: 0.5rem;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-5">
    <h2 style="font-size: 1.8rem;"><i class="bi bi-person-badge me-2"></i> Detalle del Usuario</h2>
    <div>
        <a href="{{ route('usuarios.edit', $usuario['id_usuario']) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <!-- Panel Izquierdo: Perfil -->
    <div class="col-lg-4 mb-4">
        <!-- Tarjeta de Perfil -->
        <div class="card profile-card mb-4">
            <div class="card-body text-center p-5">
                <div class="mb-4">
                    <i class="bi bi-person-circle" style="font-size: 6rem; color: #0d6efd;"></i>
                </div>
                
                <h3 class="mb-1" style="font-size: 1.4rem; font-weight: 700;">{{ $usuario['nombre'] }} {{ $usuario['apellido'] }}</h3>
                <p class="text-muted mb-3" style="font-size: 0.95rem;">{{ $usuario['correo'] }}</p>
                
                @if($usuario['rol']['nombre'] == 'Administrador')
                    <span class="badge bg-danger fs-6" style="padding: 0.5rem 1rem;">{{ $usuario['rol']['nombre'] }}</span>
                @elseif($usuario['rol']['nombre'] == 'Técnico')
                    <span class="badge bg-warning text-dark fs-6" style="padding: 0.5rem 1rem;">{{ $usuario['rol']['nombre'] }}</span>
                @else
                    <span class="badge bg-secondary fs-6" style="padding: 0.5rem 1rem;">{{ $usuario['rol']['nombre'] }}</span>
                @endif
                
                <hr class="my-4">
                
                <div class="d-grid gap-2">
                    @if($usuario['activo'])
                        <span class="badge bg-success fs-6 py-3" style="font-size: 1rem !important;">
                            <i class="bi bi-check-circle"></i> Usuario Activo
                        </span>
                    @else
                        <span class="badge bg-danger fs-6 py-3" style="font-size: 1rem !important;">
                            <i class="bi bi-x-circle"></i> Usuario Inactivo
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Información de Cuenta -->
        <div class="card profile-card">
            <div class="card-header bg-white py-4" style="border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0 fw-bold text-muted"><i class="bi bi-clock-history me-2"></i> Información de Cuenta</h6>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <small class="text-muted d-block" style="font-size: 0.85rem;">Creado:</small>
                    <p class="mb-0" style="font-size: 1rem; font-weight: 500;">{{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y H:i') }}</p>
                </div>
                
                <div>
                    <small class="text-muted d-block" style="font-size: 0.85rem;">Última actualización:</small>
                    <p class="mb-0" style="font-size: 1rem; font-weight: 500;">{{ \Carbon\Carbon::parse($usuario['updated_at'])->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Panel Derecho: Estadísticas y Tickets -->
    <div class="col-lg-8">
        <!-- Estadísticas de Tickets -->
        <div class="card profile-card mb-4">
            <div class="card-header bg-white py-4" style="border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0 fw-bold text-muted"><i class="bi bi-bar-chart me-2"></i> Estadísticas de Tickets</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @if($usuario['rol']['nombre'] != 'Técnico')
                    <div class="col-md-6">
                        <div class="stat-card primary">
                            <div class="stat-number">{{ count($usuario['tickets'] ?? []) }}</div>
                            <div class="stat-label">
                                <i class="bi bi-ticket"></i> Tickets Creados
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($usuario['rol']['nombre'] == 'Técnico')
                    <div class="col-md-6">
                        <div class="stat-card warning">
                            <div class="stat-number">{{ count($usuario['tickets_asignados'] ?? []) }}</div>
                            <div class="stat-label">
                                <i class="bi bi-clipboard-check"></i> Tickets Asignados
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Tickets Creados (Solo para Usuarios Normales) -->
        @if($usuario['rol']['nombre'] != 'Técnico')
        <div class="card profile-card">
            <div class="card-header bg-white py-4" style="border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0 fw-bold text-muted"><i class="bi bi-ticket me-2"></i> Tickets Creados</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Título</th>
                                <th>Estado</th>
                                <th class="pe-4">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(collect($usuario['tickets'])->take(5) as $ticket)
                            <tr>
                                <td class="ps-4"><strong>#{{ $ticket['id_ticket'] }}</strong></td>
                                <td style="font-size: 1rem;">{{ Str::limit($ticket['titulo'], 40) }}</td>
                                <td>
                                    <span class="badge badge-estado-{{ $ticket['estado']['tipo'] ?? 'abierto' }}">
                                        {{ $ticket['estado']['nombre'] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="pe-4" style="font-size: 0.95rem;">{{ \Carbon\Carbon::parse($ticket['fecha_creacion'])->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2">No hay tickets creados</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Tickets Asignados (Solo para Técnicos) -->
        @if($usuario['rol']['nombre'] == 'Técnico')
        <div class="card profile-card">
            <div class="card-header bg-white py-4" style="border-bottom: 1px solid #f0f0f0;">
                <h6 class="mb-0 fw-bold text-muted"><i class="bi bi-clipboard-check me-2"></i> Tickets Asignados</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Título</th>
                                <th>Estado</th>
                                <th class="pe-4">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(collect($usuario['tickets_asignados'] ?? [])->take(5) as $ticket)
                            <tr>
                                <td class="ps-4"><strong>#{{ $ticket['id_ticket'] ?? 'N/A' }}</strong></td>
                                <td style="font-size: 1rem;">{{ Str::limit($ticket['titulo'] ?? 'N/A', 40) }}</td>
                                <td>
                                    <span class="badge badge-estado-{{ $ticket['estado']['tipo'] ?? 'abierto' }}">
                                        {{ $ticket['estado']['nombre'] ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="pe-4" style="font-size: 0.95rem;">{{ \Carbon\Carbon::parse($ticket['fecha_creacion'] ?? now())->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                    <p class="mt-2">No hay tickets asignados</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection