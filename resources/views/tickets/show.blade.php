@extends('layouts.app')

@section('title', 'Detalle del Ticket #' . $ticket['id_ticket'])

@section('content')

{{-- CSS PERSONALIZADO PARA DIFERENCIAR ROLES --}}
<style>
    .bg-brown { background-color: #795548 !important; }
    .btn-brown { background-color: #795548; border-color: #795548; color: white; }
    .btn-brown:hover { background-color: #5d4037; border-color: #5d4037; color: white; }
    .border-brown { border-color: #795548 !important; }
    .text-brown { color: #795548 !important; }
    .modal-xl { max-width: 90%; }
    .shadow-inset { box-shadow: inset 0 2px 4px rgba(0,0,0,.06); }
    @media (max-width: 768px) {
        .modal-xl { max-width: 95%; }
    }
</style>

<div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <div class="flex-grow-1">
        <span class="badge bg-secondary mb-2 d-inline-block">Ticket #{{ $ticket['id_ticket'] }}</span>
        <h2 class="mb-0 fw-bold" style="font-size: clamp(1.5rem, 5vw, 2rem);">{{ $ticket['titulo'] }}</h2>
    </div>
    <div class="btn-group shadow-sm d-flex flex-wrap gap-1">
        @if(!str_contains(session('usuario_rol'), 'Técnico'))
        <a href="{{ route('tickets.edit', $ticket['id_ticket']) }}" class="btn btn-warning fw-bold btn-sm">
            <i class="bi bi-pencil-square me-1"></i> <span class="d-none d-sm-inline">Editar</span>
        </a>
        @endif
        <a href="{{ route('tickets.asignados') }}" class="btn btn-secondary fw-bold btn-sm">
            <i class="bi bi-arrow-left-circle me-1"></i> <span class="d-none d-sm-inline">Volver</span>
        </a>
    </div>
</div>

@php $esTecnico = str_contains(session('usuario_rol'), 'Técnico'); @endphp

<div class="row g-2 g-md-3 g-lg-4" style="min-height: auto;">
    <div class="col-12 {{ $esTecnico ? 'col-lg-9' : 'col-lg-8' }}">
        <div class="card border-0 shadow-sm h-100 d-flex flex-column">
            <div class="card-header bg-white py-2 border-bottom">
                <h5 class="card-title mb-0 fw-bold text-primary small" style="font-size: clamp(0.9rem, 2vw, 1rem);">
                    <i class="bi bi-info-circle-fill me-2"></i>Detalle del Problema
                </h5>
            </div>
            <div class="card-body d-flex flex-column">
                <div class="row g-2 g-md-3 mb-2">
                    <div class="col-6 col-md-{{ $esTecnico ? '4' : '6' }}">
                        <label class="text-muted fw-bold text-uppercase small" style="font-size: 0.85rem;">Creado por:</label>
                        <p class="fw-bold mb-0" style="font-size: clamp(0.9rem, 2vw, 1.1rem);">{{ $ticket['usuario']['nombre_completo'] }}</p>
                    </div>
                    <div class="col-6 col-md-{{ $esTecnico ? '4' : '6' }}">
                        <label class="text-muted fw-bold text-uppercase small" style="font-size: 0.85rem;">Área:</label>
                        <p class="fw-bold mb-0" style="font-size: clamp(0.9rem, 2vw, 1.1rem);">{{ $ticket['area']['nombre'] }}</p>
                    </div>
                    <div class="col-12 col-md-{{ $esTecnico ? '4' : '6' }}">
                        <label class="text-muted fw-bold text-uppercase small" style="font-size: 0.85rem;">Creado:</label>
                        <p class="fw-bold mb-0" style="font-size: clamp(0.9rem, 2vw, 1rem);">{{ \Carbon\Carbon::parse($ticket['fecha_creacion'])->format('d/m/Y H:i') }}</p>
                    </div>
                    @if(!$esTecnico)
                    <div class="col-12 col-md-6">
                        <label class="text-muted fw-bold text-uppercase text-primary small" style="font-size: 0.85rem;">Técnico asignado:</label>
                        <p class="fw-bold mb-0 text-primary" style="font-size: clamp(0.9rem, 2vw, 1rem);">{{ $ticket['tecnico_asignado']['nombre_completo'] ?? 'Sin asignar' }}</p>
                    </div>
                    @endif
                    @if($esTecnico)
                    <div class="col-12 col-md-4">
                        <label class="text-muted fw-bold text-uppercase small" style="font-size: 0.85rem;">Prioridad:</label>
                        <p class="fw-bold mb-0">
                            <span class="badge badge-prioridad-{{ $ticket['prioridad']['nivel'] ?? 'media' }}">
                                {{ $ticket['prioridad']['nombre'] ?? 'N/A' }}
                            </span>
                        </p>
                    </div>
                    @endif
                </div>
                <hr class="my-2">
                <div class="mb-2">
                    <label class="text-muted fw-bold text-uppercase mb-1 d-block small" style="font-size: 0.85rem;">Descripción:</label>
                    <div class="p-2 bg-light rounded border" style="max-height: 140px; overflow-y: auto; font-size: clamp(0.9rem, 2vw, 1rem);">
                        <p class="mb-0">{{ $ticket['descripcion'] }}</p>
                    </div>
                </div>
                
                @if($esTecnico)
                <hr class="my-2">
                <div class="flex-grow-1 d-flex flex-column">
                    <label class="text-muted fw-bold text-uppercase mb-1 d-block" style="font-size: 0.9rem;">Comentarios:</label>
                    <div class="bg-light p-2 rounded border shadow-inset flex-grow-1" style="overflow-y: auto; min-height: 200px;" data-comentarios-container>
                        @forelse($comentarios ?? [] as $comentario)
                            <div class="mb-2 p-2 bg-white rounded border-start border-4 border-success shadow-sm">
                                <div class="d-flex justify-content-between mb-1 border-bottom pb-1 flex-wrap gap-1">
                                    <span class="fw-bold" style="font-size: clamp(0.95rem, 2vw, 1rem);">{{ $comentario['usuario']['nombre_completo'] }}</span>
                                </div>
                                <p class="mb-0 text-secondary" style="font-size: clamp(0.9rem, 2vw, 1rem);">{{ $comentario['contenido'] }}</p>
                            </div>
                        @empty
                            <p class="text-center text-muted py-2 mb-0" style="font-size: 0.9rem;">No hay comentarios previos.</p>
                        @endforelse
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 {{ $esTecnico ? 'col-lg-3' : 'col-lg-4' }}">
        <div class="card border-0 shadow h-100 d-flex flex-column" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="card-header bg-white py-2 py-md-3 border-bottom">
                <h5 class="card-title mb-0 fw-bold" style="font-size: clamp(0.95rem, 2vw, 1.1rem);">
                    <i class="bi bi-gear-fill me-2"></i>Acciones
                </h5>
            </div>
            <div class="card-body p-2 p-md-3 text-center d-flex flex-column justify-content-between flex-grow-1">
                <div class="mb-3">
                    <p class="text-muted mb-2 text-uppercase fw-bold ls-1 small" style="font-size: 0.85rem;">Estado Actual:</p>
                    <div class="rounded-pill py-3 px-3 d-inline-block fw-bold shadow {{ $esTecnico ? 'bg-success text-white' : 'bg-brown text-white' }}" style="min-width: 120px; font-size: clamp(1rem, 3vw, 1.2rem);" data-estado-badge>
                        <i class="bi {{ $esTecnico ? 'bi-check-circle-fill' : 'bi-lock-fill' }} me-1"></i>
                        <span class="d-inline d-md-inline">{{ $ticket['estado']['nombre'] }}</span>
                    </div>
                </div>

                @if($esTecnico)
                <div class="mb-3 p-2 p-md-3 rounded bg-white shadow-sm border-start border-4 border-success">
                    <p class="text-muted mb-1 text-uppercase fw-bold small" style="font-size: 0.8rem;">Última actu.:</p>
                    <p class="mb-0 fw-bold text-dark" style="font-size: clamp(0.9rem, 2vw, 1rem);" data-ultima-actualizacion>{{ $ticket['updated_at_formatted'] }}</p>
                </div>
                @endif

                <div class="mt-auto">
                    @if($esTecnico)
                        <button type="button" class="btn btn-success w-100 py-2 py-md-3 fw-bold shadow" style="font-size: clamp(0.95rem, 2vw, 1rem);" data-bs-toggle="modal" data-bs-target="#modalGestionTicket">
                            <i class="bi bi-check-circle-fill me-1"></i>Actualizar
                        </button>
                    @else
                        <button type="button" class="btn btn-brown w-100 py-2 py-md-3 fw-bold shadow" style="font-size: clamp(0.95rem, 2vw, 1rem);" data-bs-toggle="modal" data-bs-target="#modalGestionTicket">
                            <i class="bi bi-shield-lock-fill me-1"></i>Modificar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalGestionTicket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%; max-width: clamp(300px, 90vw, 900px);">
        <div class="modal-content border-0 shadow-lg">
            {{-- CABECERA DINÁMICA: VERDE O MARRÓN --}}
            <div class="modal-header {{ $esTecnico ? 'bg-success' : 'bg-brown' }} text-white py-2 py-md-3">
                <h4 class="modal-title fw-bold" style="font-size: clamp(1rem, 3vw, 1.3rem);">
                    <i class="bi {{ $esTecnico ? 'bi-sliders' : 'bi-shield-shaded' }} me-2"></i>
                    Gestión de Ticket
                </h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('tickets.cambiar-estado', $ticket['id_ticket']) }}" method="POST">
                @csrf
                <div class="modal-body p-2 p-md-4 text-start">
                    <div class="row g-2 g-md-3">
                        <!-- Primera columna: Información del usuario y selección de estado -->
                        <div class="col-12 col-md-5">
                            <div class="mb-3 mb-md-4">
                                <label class="form-label fw-bold text-muted text-uppercase mb-2 small" style="font-size: 0.85rem;">Usuario operando:</label>
                                <p class="fw-bold mb-0" style="font-size: clamp(1rem, 2vw, 1.2rem);">
                                    <i class="bi bi-person-circle me-2 {{ $esTecnico ? 'text-success' : 'text-brown' }}"></i>
                                    {{ session('usuario_nombre') }}
                                </p>
                                <input type="hidden" name="tecnico_id" value="{{ auth()->id() }}">
                            </div>
                            
                            <div class="mb-0">
                                <label class="form-label fw-bold text-muted text-uppercase mb-2 small" style="font-size: 0.85rem;">Cambiar estado a:</label>
                                <select name="estado_id" class="form-select fw-bold {{ $esTecnico ? 'border-success text-success' : 'border-brown text-brown shadow-sm' }}" style="font-size: 0.95rem; min-height: 44px;">
                                    @foreach($estados ?? [] as $est)
                                        @if($esTecnico)
                                            @if(in_array($est['nombre'], ['En Proceso', 'Pendiente', 'Resuelto']))
                                                <option value="{{ $est['id_estado'] }}" {{ $ticket['estado']['id_estado'] == $est['id_estado'] ? 'selected' : '' }}>
                                                    {{ $est['nombre'] }}
                                                </option>
                                            @endif
                                        @else
                                            @if(in_array($est['nombre'], ['Abierto', 'Cerrado']))
                                                <option value="{{ $est['id_estado'] }}" {{ $ticket['estado']['id_estado'] == $est['id_estado'] ? 'selected' : '' }}>
                                                    {{ $est['nombre'] }}
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-muted mt-2 d-block" style="font-size: 0.8rem;">
                                    <i class="bi bi-info-circle me-1"></i>
                                    {{ $esTecnico ? 'Opciones limitadas para técnico.' : 'Opciones exclusivas para administrador.' }}
                                </small>
                            </div>
                        </div>

                        <!-- Segunda columna: Comentarios y agregar comentario -->
                        <div class="col-12 col-md-7">
                            @if(!$esTecnico)
                            <label class="form-label fw-bold text-muted text-uppercase mb-2 small" style="font-size: 0.85rem;">Historial:</label>
                            <div class="bg-light p-2 rounded border mb-3 shadow-inset" style="max-height: 180px; overflow-y: auto;">
                                @forelse($comentarios ?? [] as $comentario)
                                    <div class="mb-2 p-2 bg-white rounded border-start border-4 {{ $esTecnico ? 'border-success' : 'border-brown' }} shadow-sm">
                                        <div class="d-flex justify-content-between mb-1 border-bottom pb-1 flex-wrap gap-1">
                                            <span class="fw-bold small" style="font-size: 0.95rem;">{{ $comentario['usuario']['nombre_completo'] }}</span>
                                            <small class="text-muted" style="font-size: 0.8rem;">{{ \Carbon\Carbon::parse($comentario['created_at'])->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 text-secondary small" style="font-size: 0.9rem;">{{ $comentario['contenido'] }}</p>
                                    </div>
                                @empty
                                    <p class="text-center text-muted py-3 mb-0 small">No hay comentarios previos.</p>
                                @endforelse
                            </div>
                            @endif

                            <div class="mb-0">
                                <label class="form-label fw-bold text-muted text-uppercase mb-2 small" style="font-size: 0.85rem;">Agregar comentario / avance: *</label>
                                <textarea class="form-control {{ $esTecnico ? 'border-success' : 'border-brown' }}" name="contenido" rows="5" placeholder="Indica el motivo del cambio de estado o avances..." required style="resize: vertical; min-height: 120px; font-size: 0.95rem;"></textarea>
                                <small class="text-muted mt-2 d-block" style="font-size: 0.8rem;">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Detalla el cambio o avance en la resolución
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2 py-md-3 border-top">
                    <button type="button" class="btn btn-secondary btn-sm px-3 fw-bold" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn {{ $esTecnico ? 'btn-success' : 'btn-brown' }} btn-sm px-4 fw-bold shadow">
                        <i class="bi bi-save me-1"></i> {{ $esTecnico ? 'Guardar' : 'Aplicar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection>
@endsection