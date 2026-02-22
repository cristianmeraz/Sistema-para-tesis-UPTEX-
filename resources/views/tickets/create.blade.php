@extends('layouts.app')

@section('title', 'Crear Ticket')

@section('content')
<div class="row g-2 g-md-3 g-lg-4">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Crear Nuevo Ticket</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tickets.store') }}" method="POST" id="ticketForm">
                    @csrf
                    
                    <div class="mb-3 mb-md-4">
                        <label for="titulo" class="form-label fw-semibold">Título del Problema *</label>
                        <input type="text" 
                               class="form-control  @error('titulo') is-invalid @enderror" 
                               id="titulo" 
                               name="titulo" 
                               value="{{ old('titulo') }}"
                               placeholder="Ej: No puedo acceder a mi correo institucional"
                               required
                               style="min-height: 44px;">
                        @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 mb-md-4">
                        <label for="descripcion" class="form-label fw-semibold">Descripción Detallada *</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="6"
                                  placeholder="Describe el problema con el mayor detalle posible. Incluye:&#10;- ¿Qué estabas haciendo cuando ocurrió?&#10;- ¿Qué mensaje de error viste?&#10;- ¿Cuándo comenzó el problema?"
                                  required
                                  style="min-height: 150px;">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row g-2 g-md-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="area_id" class="form-label fw-semibold">Área Relacionada *</label>
                            <select class="form-select @error('area_id') is-invalid @enderror" 
                                    id="area_id" 
                                    name="area_id" 
                                    required
                                    style="min-height: 44px;">
                                <option value="">Selecciona un área</option>
                                @foreach($areas ?? [] as $area)
                                <option value="{{ $area['id_area'] }}" {{ old('area_id') == $area['id_area'] ? 'selected' : '' }}>
                                    {{ $area['nombre'] }}
                                </option>
                                @endforeach
                            </select>
                            @error('area_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3 mb-md-4">
                            <label for="prioridad_id" class="form-label fw-semibold">Prioridad *</label>
                            <select class="form-select @error('prioridad_id') is-invalid @enderror" 
                                    id="prioridad_id" 
                                    name="prioridad_id" 
                                    required
                                    style="min-height: 44px;">
                                <option value="">Selecciona prioridad</option>
                                @foreach($prioridades ?? [] as $prioridad)
                                <option value="{{ $prioridad['id_prioridad'] }}" {{ old('prioridad_id') == $prioridad['id_prioridad'] ? 'selected' : '' }}>
                                    {{ $prioridad['nombre'] }}
                                </option>
                                @endforeach
                            </select>
                            @error('prioridad_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" style="padding: 12px 20px; font-size: 16px;">
                            <i class="bi bi-send me-2"></i>Enviar Ticket
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" style="padding: 12px 20px; font-size: 16px;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- CHATBOT IA - RESPONSIVE -->
    <div class="col-12 col-lg-4 order-lg-last">
        <div class="card sticky-top" style="top: max(90px, clamp(1rem, 5vh, 2rem));">
            <div class="card-header" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-robot me-2"></i>
                        <span class="d-none d-lg-inline">Asistente IA</span>
                        <span class="d-lg-none">Asistente</span>
                    </h5>
                    <button class="btn btn-sm btn-light d-lg-none" id="toggleChat" style="width: 32px; height: 32px; padding: 0;">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>
            <div class="card-body d-lg-block" id="chatContent" style="display: none;">
                <div id="chatMessages" style="height: 300px; overflow-y: auto; margin-bottom: 1rem; padding: 1rem; background: #F8FAFC; border-radius: 8px;">
                    <div class="chat-message bot-message">
                        <div class="message-content">
                            <strong>Asistente:</strong>
                            <p class="mb-0">¡Hola! 👋 Soy tu asistente virtual. Puedo ayudarte a:</p>
                            <ul class="mt-2 mb-0">
                                <li>Clasificar tu problema</li>
                                <li>Sugerir el área correcta</li>
                                <li>Determinar la prioridad</li>
                                <li>Redactar mejor tu ticket</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="input-group input-group-sm">
                    <input type="text" 
                           id="chatInput" 
                           class="form-control" 
                           placeholder="Escribe tu pregunta..."
                           style="min-height: 38px;">
                    <button class="btn btn-success" id="sendChat">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
                
                <div class="mt-2">
                    <small class="text-muted d-block">
                        <i class="bi bi-info-circle me-1"></i>
                        Presiona Enter para enviar
                    </small>
                </div>
                
                <!-- SUGERENCIAS RÁPIDAS -->
                <div class="mt-3">
                    <p class="small fw-semibold mb-2">Sugerencias:</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-sm btn-outline-success suggestion-btn" data-suggestion="No puedo iniciar sesión en el sistema">
                            🔐 Acceso
                        </button>
                        <button class="btn btn-sm btn-outline-success suggestion-btn" data-suggestion="Mi equipo no enciende">
                            💻 Equipo
                        </button>
                        <button class="btn btn-sm btn-outline-success suggestion-btn" data-suggestion="No tengo conexión a internet">
                            🌐 Red
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .chat-message {
        margin-bottom: 1rem;
        padding: 0.75rem;
        border-radius: 8px;
    }
    
    .bot-message {
        background: white;
        border-left: 4px solid #10B981;
    }
    
    .user-message {
        background: #EEF2FF;
        border-left: 4px solid #4F46E5;
    }
    
    .message-content {
        font-size: 0.9rem;
    }
    
    .suggestion-btn {
        text-align: left;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle del chat en móvil
    const toggleChatBtn = document.getElementById('toggleChat');
    const chatContent = document.getElementById('chatContent');
    
    if (toggleChatBtn) {
        toggleChatBtn.addEventListener('click', function() {
            const isVisible = chatContent.style.display !== 'none';
            chatContent.style.display = isVisible ? 'none' : 'block';
            
            // Rotar el ícono
            toggleChatBtn.querySelector('i').style.transform = isVisible ? 'rotate(0deg)' : 'rotate(180deg)';
            toggleChatBtn.querySelector('i').style.transition = 'transform 0.3s ease';
        });
    }
    
    const chatInput = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendChat');
    const chatMessages = document.getElementById('chatMessages');
    const suggestionBtns = document.querySelectorAll('.suggestion-btn');
    
    // Configuración de áreas y prioridades (se llena con datos del servidor)
    const areasMap = {
        'sistemas': 1,
        'sistema': 1,
        'acceso': 1,
        'login': 1,
        'contraseña': 1,
        'cuenta': 1,
        'soporte': 2,
        'técnico': 2,
        'equipo': 2,
        'computadora': 2,
        'pc': 2,
        'laptop': 2,
        'impresora': 2,
        'redes': 3,
        'red': 3,
        'internet': 3,
        'wifi': 3,
        'conexión': 3,
        'conectividad': 3,
        'infraestructura': 4,
        'edificio': 4,
        'instalaciones': 4
    };
    
    const prioridadesMap = {
        'urgente': 3,
        'muy urgente': 4,
        'critico': 4,
        'crítico': 4,
        'importante': 3,
        'normal': 2,
        'baja': 1,
        'no es urgente': 1
    };
    
    // Enviar mensaje
    function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;
        
        addMessage('user', message);
        chatInput.value = '';
        
        // Mostrar indicador de escritura
        showTypingIndicator();
        
        setTimeout(() => {
            removeTypingIndicator();
            const response = generateIntelligentResponse(message);
            addMessage('bot', response.message);
            
            // Auto-llenar campos si se detectaron valores
            if (response.area) {
                document.getElementById('area_id').value = response.area;
                highlightField('area_id');
            }
            if (response.prioridad) {
                document.getElementById('prioridad_id').value = response.prioridad;
                highlightField('prioridad_id');
            }
            if (response.titulo) {
                document.getElementById('titulo').value = response.titulo;
                highlightField('titulo');
            }
        }, 1500);
    }
    
    // Agregar mensaje al chat
    function addMessage(type, text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `chat-message ${type}-message animate__animated animate__fadeIn`;
        messageDiv.innerHTML = `
            <div class="message-content">
                <strong>${type === 'user' ? 'Tú' : 'Asistente IA'}:</strong>
                <p class="mb-0">${text}</p>
            </div>
        `;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Indicador de escritura
    function showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'typingIndicator';
        indicator.className = 'chat-message bot-message';
        indicator.innerHTML = `
            <div class="message-content">
                <strong>Asistente IA:</strong>
                <p class="mb-0">
                    <span class="typing-dots">
                        <span>.</span><span>.</span><span>.</span>
                    </span>
                </p>
            </div>
        `;
        chatMessages.appendChild(indicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    function removeTypingIndicator() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) indicator.remove();
    }
    
    // Resaltar campo auto-llenado
    function highlightField(fieldId) {
        const field = document.getElementById(fieldId);
        field.classList.add('field-highlight');
        setTimeout(() => field.classList.remove('field-highlight'), 2000);
    }
    
    // Generar respuesta inteligente
    function generateIntelligentResponse(message) {
        const lowMsg = message.toLowerCase();
        let response = {
            message: '',
            area: null,
            prioridad: null,
            titulo: null
        };
        
        // Detectar problema de acceso/login
        if (lowMsg.includes('iniciar sesión') || lowMsg.includes('login') || lowMsg.includes('contraseña') || lowMsg.includes('acceso') || lowMsg.includes('cuenta')) {
            response.area = 1; // Sistemas
            response.prioridad = 2; // Media
            response.titulo = 'Problema de acceso al sistema';
            response.message = '🔐 Entiendo que tienes problemas para acceder al sistema. He configurado:<br><br>' +
                              '✅ <strong>Área:</strong> Sistemas<br>' +
                              '✅ <strong>Prioridad:</strong> Media<br>' +
                              '✅ <strong>Título sugerido:</strong> Problema de acceso al sistema<br><br>' +
                              '💡 <strong>Consejo:</strong> En la descripción, menciona:<br>' +
                              '• ¿Recibes algún mensaje de error?<br>' +
                              '• ¿Olvidaste tu contraseña o el sistema no la reconoce?<br>' +
                              '• ¿Desde cuándo tienes este problema?';
            return response;
        }
        
        // Detectar problema de equipo
        if (lowMsg.includes('equipo') || lowMsg.includes('computadora') || lowMsg.includes('pc') || lowMsg.includes('laptop') || lowMsg.includes('no enciende') || lowMsg.includes('impresora')) {
            response.area = 2; // Soporte Técnico
            response.prioridad = 3; // Alta
            response.titulo = lowMsg.includes('impresora') ? 'Problema con impresora' : 'Problema con equipo de cómputo';
            response.message = '💻 Detecté un problema de hardware. He configurado:<br><br>' +
                              '✅ <strong>Área:</strong> Soporte Técnico<br>' +
                              '✅ <strong>Prioridad:</strong> Alta<br>' +
                              '✅ <strong>Título sugerido:</strong> ' + response.titulo + '<br><br>' +
                              '💡 <strong>Consejo:</strong> Describe:<br>' +
                              '• ¿Qué intentaste hacer cuando falló?<br>' +
                              '• ¿Hay luces encendidas o sonidos?<br>' +
                              '• ¿El problema es en laboratorio o área específica?';
            return response;
        }
        
        // Detectar problema de red/internet
        if (lowMsg.includes('internet') || lowMsg.includes('red') || lowMsg.includes('wifi') || lowMsg.includes('conexión') || lowMsg.includes('conectar')) {
            response.area = 3; // Redes
            response.prioridad = 3; // Alta
            response.titulo = 'Problema de conectividad de red';
            response.message = '🌐 Problema de conectividad identificado. He configurado:<br><br>' +
                              '✅ <strong>Área:</strong> Redes<br>' +
                              '✅ <strong>Prioridad:</strong> Alta<br>' +
                              '✅ <strong>Título sugerido:</strong> Problema de conectividad de red<br><br>' +
                              '💡 <strong>Consejo:</strong> Indica:<br>' +
                              '• ¿Es en todo el edificio o solo tu área?<br>' +
                              '• ¿Otros dispositivos tienen el mismo problema?<br>' +
                              '• ¿Desde cuándo no tienes conexión?';
            return response;
        }
        
        // Detectar urgencia en el mensaje
        if (lowMsg.includes('urgente') || lowMsg.includes('rápido') || lowMsg.includes('inmediato') || lowMsg.includes('ahora')) {
            response.prioridad = 4; // Crítica
            response.message = '⚠️ Detecté que es <strong>URGENTE</strong>. He configurado la prioridad como <strong>CRÍTICA</strong>.<br><br>' +
                              '📝 Por favor, describe el problema con el mayor detalle posible para que podamos atenderte rápidamente.';
            return response;
        }
        
        // Respuesta genérica
        response.message = '👋 He registrado tu consulta. Para ayudarte mejor, necesito más información:<br><br>' +
                          '🔹 <strong>¿Qué tipo de problema tienes?</strong><br>' +
                          '• Problemas de acceso/login<br>' +
                          '• Problemas con tu equipo<br>' +
                          '• Problemas de internet/red<br><br>' +
                          '🔹 <strong>¿Qué tan urgente es?</strong><br>' +
                          '• Normal - puedo esperar<br>' +
                          '• Urgente - necesito solución pronto<br>' +
                          '• Crítico - bloquea mi trabajo completamente<br><br>' +
                          '💬 Puedes usar las sugerencias rápidas de abajo o describirme tu problema.';
        
        return response;
    }
    
    // Event listeners
    sendBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });
    
    // Sugerencias rápidas
    suggestionBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const suggestion = this.dataset.suggestion;
            chatInput.value = suggestion;
            sendMessage();
        });
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate__animated {
    animation-duration: 0.3s;
}

.animate__fadeIn {
    animation-name: fadeIn;
}

.typing-dots span {
    animation: blink 1.4s infinite;
    animation-fill-mode: both;
}

.typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes blink {
    0%, 80%, 100% { opacity: 0; }
    40% { opacity: 1; }
}

.field-highlight {
    animation: highlight 0.5s ease;
    border-color: #10B981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2) !important;
}

@keyframes highlight {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}
</style>
@endpush
@endsection