@extends('layouts.app')

@section('title', 'Historial de Tickets')

@section('content')
<style>
    .table th, .table td {
        font-size: clamp(0.8rem, 2vw, 0.95rem);
    }
</style>

<div class="container-fluid px-2 px-md-4 py-2 py-md-4">
    <!-- HEADER -->
    <div class="row">
        <div class="col-12 mb-3 mb-md-4">
            <h2 style="font-size: clamp(1.5rem, 5vw, 2rem); font-weight: 700;">
                <i class="bi bi-clock-history me-2"></i>Historial de Tickets
            </h2>
            <p class="text-muted small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Todos los tickets que has atendido</p>
        </div>
    </div>
    
    <!-- LISTA DE TICKETS -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-2 p-md-3 p-lg-4">
                    @if($tickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-2 ps-md-3">ID</th>
                                    <th class="d-none d-md-table-cell">Título</th>
                                    <th class="d-none d-lg-table-cell">Usuario</th>
                                    <th class="d-none d-xl-table-cell">Área</th>
                                    <th class="d-none d-lg-table-cell">Prioridad</th>
                                    <th class="d-none d-md-table-cell">Estado</th>
                                    <th class="d-none d-xl-table-cell">Fecha Creación</th>
                                    <th class="pe-2 pe-md-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td class="ps-2 ps-md-3"><strong>#{{ $ticket->id_ticket }}</strong></td>
                                    <td class="d-none d-md-table-cell">
                                        <span style="font-size: clamp(0.8rem, 2vw, 0.9rem);">{{ Str::limit($ticket->titulo, 40) }}</span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span style="font-size: clamp(0.8rem, 2vw, 0.9rem);">{{ $ticket->usuario->nombre_completo }}</span>
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        <span style="font-size: clamp(0.8rem, 2vw, 0.9rem);">{{ $ticket->area->nombre }}</span>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        <span class="badge badge-prioridad-{{ $ticket->prioridad->nivel }}" style="font-size: clamp(0.7rem, 1.5vw, 0.8rem);">
                                            {{ $ticket->prioridad->nombre }}
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <span class="badge badge-estado-{{ $ticket->estado->tipo }}" style="font-size: clamp(0.7rem, 1.5vw, 0.8rem);">
                                            {{ $ticket->estado->nombre }}
                                        </span>
                                    </td>
                                    <td class="d-none d-xl-table-cell">
                                        <span style="font-size: clamp(0.8rem, 2vw, 0.9rem);">{{ $ticket->fecha_creacion->format('d/m/Y H:i') }}</span>
                                    </td>
                                    <td class="pe-2 pe-md-3 text-center">
                                        <a href="{{ route('tickets.show', $ticket->id_ticket) }}" class="btn btn-sm btn-info text-white" title="Ver Detalle" style="min-width: 36px; min-height: 36px;">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- PAGINACIÓN -->
                    @if($tickets->hasPages())
                    <div class="mt-3 mt-md-4 d-flex justify-content-center">
                        {{ $tickets->links() }}
                    </div>
                    @endif
                    @else
                    <div class="text-center py-4 py-md-5">
                        <i class="bi bi-inbox text-muted" style="font-size: clamp(2.5rem, 10vw, 4rem); margin-bottom: 1rem; display: block;"></i>
                        <p class="text-muted small" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">No tienes tickets en tu historial</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
