@extends('layouts.app')

@section('title', 'Tickets - Sistema de Tickets')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="m-0"><i class="bi bi-ticket"></i> Gestión de Tickets</h2>
    
    {{-- OCULTAR BOTÓN SUPERIOR PARA TÉCNICOS --}}
    @if(!str_contains(session('usuario_rol'), 'Técnico'))
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline">Nuevo</span> Ticket
    </a>
    @endif
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row g-2 g-md-3">
            <div class="col-12 col-md-6 col-lg-3">
                <label class="form-label">Estado</label>
                <select name="estado_id" id="estadoFilter" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach($estados ?? [] as $estado)
                    <option value="{{ $estado['id_estado'] }}" {{ request('estado_id') == $estado['id_estado'] ? 'selected' : '' }}>
                        {{ $estado['nombre'] }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <label class="form-label">Prioridad</label>
                <select name="prioridad_id" id="prioridadFilter" class="form-select form-select-sm">
                    <option value="">Todas</option>
                    @foreach($prioridades ?? [] as $prioridad)
                    <option value="{{ $prioridad['id_prioridad'] }}" {{ request('prioridad_id') == $prioridad['id_prioridad'] ? 'selected' : '' }}>
                        {{ $prioridad['nombre'] }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <label class="form-label">Área</label>
                <select name="area_id" id="areaFilter" class="form-select form-select-sm">
                    <option value="">Todas</option>
                    @foreach($areas ?? [] as $area)
                    <option value="{{ $area['id_area'] }}" {{ request('area_id') == $area['id_area'] ? 'selected' : '' }}>
                        {{ $area['nombre'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0 p-md-3">
        <!-- VISTA DESKTOP (TABLA) -->
        <div class="table-responsive d-none d-md-block">
            <table id="ticketsTable" class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="min-width: 60px;">ID</th>
                        <th style="min-width: 180px;">Título</th>
                        <th style="min-width: 130px;">Usuario</th>
                        <th style="min-width: 100px;">Área</th>
                        <th style="min-width: 100px;">Prioridad</th>
                        <th style="min-width: 100px;">Estado</th>
                        <th style="min-width: 120px;">Técnico</th>
                        <th style="min-width: 140px;">Fecha</th>
                        <th style="min-width: 100px;"class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td><strong>#{{ $ticket['id_ticket'] }}</strong></td>
                        <td>
                            <a href="{{ route('tickets.show', $ticket['id_ticket']) }}" class="text-decoration-none">
                                {{ Str::limit($ticket['titulo'], 50) }}
                            </a>
                        </td>
                        <td>{{ $ticket['usuario']['nombre_completo'] ?? 'N/A' }}</td>
                        <td>{{ $ticket['area']['nombre'] ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-prioridad-{{ $ticket['prioridad']['nivel'] ?? 1 }}">
                                {{ $ticket['prioridad']['nombre'] ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-estado-{{ $ticket['estado']['tipo'] ?? 'abierto' }}">
                                {{ $ticket['estado']['nombre'] ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            @if(isset($ticket['tecnico_asignado']))
                                {{ $ticket['tecnico_asignado']['nombre_completo'] }}
                            @else
                                <span class="text-muted">Sin asignar</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($ticket['fecha_creacion'])->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('tickets.show', $ticket['id_ticket']) }}" class="btn btn-info" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(str_contains(session('usuario_rol'), 'Administrador') || str_contains(session('usuario_rol'), 'Técnico'))
                                <a href="{{ route('tickets.edit', $ticket['id_ticket']) }}" class="btn btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">No tienes tickets asignados para mostrar</p>
                            
                            {{-- OCULTAR BOTÓN CENTRAL PARA TÉCNICOS --}}
                            @if(!str_contains(session('usuario_rol'), 'Técnico'))
                            <a href="{{ route('tickets.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle"></i> Crear Ticket
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- VISTA MÓVIL (CARDS) -->
        <div class="d-md-none">
            @forelse($tickets as $ticket)
            <div class="card mb-3 border-start border-5" style="border-color: var(--primary) !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="card-title mb-1">
                                <strong>#{{ $ticket['id_ticket'] }}</strong> 
                                <a href="{{ route('tickets.show', $ticket['id_ticket']) }}" class="text-decoration-none">
                                    {{ Str::limit($ticket['titulo'], 40) }}
                                </a>
                            </h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($ticket['fecha_creacion'])->format('d/m/Y H:i') }}</small>
                        </div>
                        <a href="{{ route('tickets.show', $ticket['id_ticket']) }}" class="btn btn-sm btn-info" title="Ver">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>

                    <div class="mb-2">
                        <small><strong>Usuario:</strong> {{ $ticket['usuario']['nombre_completo'] ?? 'N/A' }}</small><br>
                        <small><strong>Área:</strong> {{ $ticket['area']['nombre'] ?? 'N/A' }}</small>
                    </div>

                    <div class="mb-3 d-flex gap-2 flex-wrap">
                        <span class="badge badge-prioridad-{{ $ticket['prioridad']['nivel'] ?? 1 }}">
                            {{ $ticket['prioridad']['nombre'] ?? 'N/A' }}
                        </span>
                        <span class="badge badge-estado-{{ $ticket['estado']['tipo'] ?? 'abierto' }}">
                            {{ $ticket['estado']['nombre'] ?? 'N/A' }}
                        </span>
                    </div>

                    <small class="text-muted">
                        <i class="bi bi-person"></i>
                        Técnico: {{ isset($ticket['tecnico_asignado']) ? $ticket['tecnico_asignado']['nombre_completo'] : 'Sin asignar' }}
                    </small>

                    <div class="mt-3 pt-2 border-top d-flex gap-2">
                        <a href="{{ route('tickets.show', $ticket['id_ticket']) }}" class="btn btn-sm btn-info flex-grow-1">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        @if(str_contains(session('usuario_rol'), 'Administrador') || str_contains(session('usuario_rol'), 'Técnico'))
                        <a href="{{ route('tickets.edit', $ticket['id_ticket']) }}" class="btn btn-sm btn-warning flex-grow-1">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <p class="mt-2">No tienes tickets asignados</p>
                
                {{-- OCULTAR BOTÓN CENTRAL PARA TÉCNICOS --}}
                @if(!str_contains(session('usuario_rol'), 'Técnico'))
                <a href="{{ route('tickets.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Crear Ticket
                </a>
                @endif
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection