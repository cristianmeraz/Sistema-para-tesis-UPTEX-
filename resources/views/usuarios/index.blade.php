@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="m-0"><i class="bi bi-people"></i> Gestión de Usuarios</h2>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus"></i> <span class="d-none d-sm-inline">Nuevo</span> Usuario
    </a>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-2 g-md-3">
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label">Rol</label>
                <select name="id_rol" id="rolFilter" class="form-select form-select-sm">
                    <option value="">Todos los roles</option>
                    @foreach($roles ?? [] as $rol)
                    <option value="{{ $rol['id_rol'] }}" {{ request('id_rol') == $rol['id_rol'] ? 'selected' : '' }}>
                        {{ $rol['nombre'] }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label">Estado</label>
                <select name="activo" id="estadoFilter" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Usuarios -->
<div class="card">
    <div class="card-body p-0 p-md-3">
        <!-- VISTA DESKTOP (TABLA) -->
        <div class="table-responsive d-none d-md-block">
            <table id="usuariosTable" class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="min-width: 60px;">ID</th>
                        <th style="min-width: 160px;">Nombre</th>
                        <th style="min-width: 150px;">Correo</th>
                        <th style="min-width: 110px;">Rol</th>
                        <th style="min-width: 90px;">Estado</th>
                        <th style="min-width: 95px;">Creado</th>
                        <th style="min-width: 140px;" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr>
                        <td><strong>#{{ $usuario['id_usuario'] }}</strong></td>
                        <td>
                            <i class="bi bi-person-circle"></i>
                            {{ $usuario['nombre'] }} {{ $usuario['apellido'] }}
                        </td>
                        <td>{{ $usuario['correo'] }}</td>
                        <td>
                            @if($usuario['rol']['nombre'] == 'Administrador')
                                <span class="badge bg-danger">{{ $usuario['rol']['nombre'] }}</span>
                            @elseif($usuario['rol']['nombre'] == 'Técnico')
                                <span class="badge bg-warning">{{ $usuario['rol']['nombre'] }}</span>
                            @else
                                <span class="badge bg-secondary">{{ $usuario['rol']['nombre'] }}</span>
                            @endif
                        </td>
                        <td>
                            @if($usuario['activo'])
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('usuarios.show', $usuario['id_usuario']) }}" 
                                   class="btn btn-info" 
                                   title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('usuarios.edit', $usuario['id_usuario']) }}" 
                                   class="btn btn-warning" 
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('usuarios.toggle-activo', $usuario['id_usuario']) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn {{ $usuario['activo'] ? 'btn-secondary' : 'btn-success' }}" 
                                            title="{{ $usuario['activo'] ? 'Desactivar' : 'Activar' }}">
                                        <i class="bi bi-power"></i>
                                    </button>
                                </form>
                                @if(session('usuario_id') != $usuario['id_usuario'])
                                <form action="{{ route('usuarios.destroy', $usuario['id_usuario']) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-people" style="font-size: 3rem;"></i>
                            <p class="mt-2">No hay usuarios para mostrar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- VISTA MÓVIL (CARDS) -->
        <div class="d-md-none">
            @forelse($usuarios as $usuario)
            <div class="card mb-3 border-start border-5" style="border-color: var(--primary) !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="card-title mb-1">
                                <i class="bi bi-person-circle"></i>
                                <strong>#{{ $usuario['id_usuario'] }}</strong>
                            </h6>
                            <p class="mb-1">{{ $usuario['nombre'] }} {{ $usuario['apellido'] }}</p>
                            <small class="text-muted">{{ $usuario['correo'] }}</small>
                        </div>
                    </div>

                    <div class="mb-2 d-flex gap-2 flex-wrap">
                        @if($usuario['rol']['nombre'] == 'Administrador')
                            <span class="badge bg-danger">{{ $usuario['rol']['nombre'] }}</span>
                        @elseif($usuario['rol']['nombre'] == 'Técnico')
                            <span class="badge bg-warning">{{ $usuario['rol']['nombre'] }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $usuario['rol']['nombre'] }}</span>
                        @endif
                        
                        @if($usuario['activo'])
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </div>

                    <small class="text-muted d-block mb-3">
                        <i class="bi bi-calendar"></i>
                        Creado: {{ \Carbon\Carbon::parse($usuario['created_at'])->format('d/m/Y') }}
                    </small>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('usuarios.show', $usuario['id_usuario']) }}" 
                           class="btn btn-sm btn-info flex-grow-1" 
                           title="Ver">
                            <i class="bi bi-eye"></i> Ver
                        </a>
                        <a href="{{ route('usuarios.edit', $usuario['id_usuario']) }}" 
                           class="btn btn-sm btn-warning flex-grow-1" 
                           title="Editar">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('usuarios.toggle-activo', $usuario['id_usuario']) }}" 
                              method="POST" 
                              class="d-inline flex-grow-1">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-sm w-100 {{ $usuario['activo'] ? 'btn-secondary' : 'btn-success' }}" 
                                    title="{{ $usuario['activo'] ? 'Desactivar' : 'Activar' }}">
                                <i class="bi bi-power"></i> {{ $usuario['activo'] ? 'Desact' : 'Act' }}
                            </button>
                        </form>
                        @if(session('usuario_id') != $usuario['id_usuario'])
                        <form action="{{ route('usuarios.destroy', $usuario['id_usuario']) }}" 
                              method="POST" 
                              class="d-inline flex-grow-1"
                              onsubmit="return confirm('¿Eliminar este usuario?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-4">
                <i class="bi bi-people" style="font-size: 3rem;"></i>
                <p class="mt-2">No hay usuarios para mostrar</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let dataTableInstance = null;
    const currentUserId = {{ session('usuario_id') }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    
    // Función para cargar y actualizar usuarios
    function cargarUsuarios() {
        const rolId = $('#rolFilter').val();
        const estadoId = $('#estadoFilter').val();
        
        // Construir URL con parámetros
        const params = new URLSearchParams();
        if (rolId) params.append('id_rol', rolId);
        if (estadoId !== '') params.append('activo', estadoId);
        
        const url = '{{ route("usuarios.index") }}?' + params.toString();
        
        // Hacer petición AJAX
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Destruir DataTable anterior si existe
            if (dataTableInstance) {
                dataTableInstance.destroy();
            }
            
            // Limpiar tabla
            let tbody = $('#usuariosTable tbody');
            tbody.empty();
            
            // Agregar filas
            if (data.usuarios && data.usuarios.length > 0) {
                data.usuarios.forEach(usuario => {
                    const rolBadge = usuario.rol.nombre === 'Administrador' 
                        ? '<span class="badge bg-danger">Administrador</span>'
                        : usuario.rol.nombre === 'Técnico'
                        ? '<span class="badge bg-warning">Técnico</span>'
                        : '<span class="badge bg-secondary">Usuario Normal</span>';
                    
                    const estadoBadge = usuario.activo
                        ? '<span class="badge bg-success">Activo</span>'
                        : '<span class="badge bg-danger">Inactivo</span>';
                    
                    // Crear HTML para los botones
                    let botonesHTML = `
                        <div class="btn-group btn-group-sm">
                            <a href="/usuarios/${usuario.id_usuario}" class="btn btn-info" title="Ver">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="/usuarios/${usuario.id_usuario}/edit" class="btn btn-warning" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="/usuarios/${usuario.id_usuario}/toggle-activo" method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <button type="submit" class="btn ${usuario.activo ? 'btn-secondary' : 'btn-success'}" title="${usuario.activo ? 'Desactivar' : 'Activar'}">
                                    <i class="bi bi-power"></i>
                                </button>
                            </form>
                    `;
                    
                    // Agregar botón de eliminar solo si no es el usuario actual
                    if (usuario.id_usuario !== currentUserId) {
                        botonesHTML += `
                            <form action="/usuarios/${usuario.id_usuario}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        `;
                    }
                    
                    botonesHTML += `</div>`;
                    
                    const row = `
                        <tr>
                            <td><strong>#${usuario.id_usuario}</strong></td>
                            <td>
                                <i class="bi bi-person-circle"></i>
                                ${usuario.nombre} ${usuario.apellido}
                            </td>
                            <td>${usuario.correo}</td>
                            <td>${rolBadge}</td>
                            <td>${estadoBadge}</td>
                            <td>${new Date(usuario.created_at).toLocaleDateString('es-ES', {year: 'numeric', month: '2-digit', day: '2-digit'})}</td>
                            <td>${botonesHTML}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            } else {
                tbody.append(`
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-people" style="font-size: 3rem;"></i>
                            <p class="mt-2">No hay usuarios para mostrar</p>
                        </td>
                    </tr>
                `);
            }
            
            // Reinicializar DataTable
            dataTableInstance = $('#usuariosTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "pageLength": 15,
                "order": [[0, 'desc']],
                "columnDefs": [
                    { "orderable": false, "targets": 6 }
                ],
                "dom": "lrtip"
            });
        })
        .catch(error => console.error('Error:', error));
    }
    
    // Event listeners para los filtros
    $('#rolFilter').on('change', cargarUsuarios);
    $('#estadoFilter').on('change', cargarUsuarios);
    
    // Inicializar DataTable
    if ($('#usuariosTable tbody tr').length > 0) {
        dataTableInstance = $('#usuariosTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            "pageLength": 15,
            "order": [[0, 'desc']],
            "columnDefs": [
                { "orderable": false, "targets": 6 }
            ],
            "dom": "lrtip"
        });
    }
});
</script>
@endpush
@endsection 