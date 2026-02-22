# 📊 ANÁLISIS COMPLETO - SISTEMA DE TICKETS UPTEX

## VERSIÓN 2.0 - COMPLETA Y DEFINITIVA
**Fecha:** 14 de febrero de 2026  
**Estado:** Documentación con Requerimientos Finales

---

## 📑 TABLA DE CONTENIDOS

1. [Resumen Ejecutivo](#1-resumen-ejecutivo)
2. [Arquitectura General](#2-arquitectura-general)
3. [Estructura del Proyecto](#3-estructura-del-proyecto)
4. [Flujo de la Aplicación](#4-flujo-de-la-aplicación)
5. [Análisis de Roles y Permisos](#5-análisis-de-roles-y-permisos)
6. [Módulo Administrador](#6-módulo-administrador)
7. [Módulo Técnico](#7-módulo-técnico)
8. [Módulo Usuario Normal](#8-módulo-usuario-normal)
9. [Código Innecesario](#9-código-innecesario)
10. [Mejoras Fase 1 (Arquitectura)](#10-mejoras-fase-1-arquitectura)
11. [Mejoras Fase 2 (UX/UI)](#11-mejoras-fase-2-uxui)
12. [Nuevos Requerimientos UPTEX](#12-nuevos-requerimientos-uptex)
13. [Plan de Implementación](#13-plan-de-implementación)

---

## 1. 📋 RESUMEN EJECUTIVO

### Estado General del Proyecto: ✅ BIEN ESTRUCTURADO

#### ✓ Fortalezas Identificadas:
- Arquitectura de 3 capas bien separada (API + Web)
- Control de roles implementado correctamente
- Base de datos normalizada eficiente
- Rutas organizadas por contexto
- Uso de Laravel Sanctum para autenticación API
- Modelos con relaciones bien definidas

#### ⚠️ Problemas Encontrados:
- **CRÍTICO:** Duplicación de modelo Usuario (User.php + Usuario.php)
- **CRÍTICO:** Tabla 'users' huérfana en BD
- **MEDIO:** Código duplicado en controladores Web y API
- **MEDIO:** Validaciones no centralizadas
- **BAJO:** Algunas rutas pueden optimizarse

#### 📊 Estadísticas:

| Elemento | Cantidad | Estado |
|----------|----------|--------|
| Controladores API | 7 | ✓ Bien |
| Controladores Web | 4 | ✓ Bien |
| Modelos | 8 (con duplicados) | ⚠️ Revisar |
| Rutas Totales | 50+ | ✓ Organizadas |
| Middlewares | 3 | ✓ Funcionales |
| Vistas Blade | 21 | ✓ Completas |

---

## 2. 🏗️ ARQUITECTURA GENERAL

### Componentes Principales:

```
┌─────────────────────────────────────┐
│     CLIENTE (Web Browser)            │
│  - Blade Templates (HTML/CSS/JS)     │
│  - API REST Client (JSON)            │
└────────────────────┬────────────────┘
                     │
        ┌────────────┴────────────┐
        │                         │
        ▼                         ▼
   WEB FRONTEND          API REST
   (Sessions)            (Tokens)
        │                         │
        └────────────┬────────────┘
                     │
        ┌────────────▼────────────┐
        │    CONTROLADORES        │
        │  - WebController        │
        │  - ApiControllers       │
        │  - Middlewares          │
        └────────────┬────────────┘
                     │
        ┌────────────▼────────────┐
        │    MODELOS (Eloquent)   │
        │  - Usuario              │
        │  - Ticket               │
        │  - Rol                  │
        │  - Área, Estado, etc    │
        └────────────┬────────────┘
                     │
        ┌────────────▼────────────┐
        │  BASE DE DATOS MySQL    │
        │  (9 tablas)             │
        └─────────────────────────┘
```

### Autenticación:

**Web (Blade):** Sesiones PHP + Token simulado  
**API:** Laravel Sanctum + Bearer Token  
**Ambos:** Validan contra tabla 'usuarios'

---

## 3. 📁 ESTRUCTURA DEL PROYECTO

### Árbol de Directorios:

```
app/Http/Controllers/
├── Api/                      (7 controladores)
│   ├── AuthController.php
│   ├── TicketController.php
│   ├── DashboardController.php
│   ├── UsuarioController.php
│   ├── ReporteController.php
│   ├── CatalogoController.php
│   └── ComentarioController.php
│
└── Web/                      (4 controladores)
    ├── WebController.php
    ├── TicketWebController.php
    ├── UsuarioWebController.php
    └── ReporteWebController.php

app/Models/
├── Usuario.php              (Principal)
├── User.php                 (❌ DUPLICADO - NO USAR)
├── Ticket.php
├── Rol.php
├── Comentario.php
├── Area.php
├── Estado.php
└── Prioridad.php

routes/
├── web.php                  (Rutas web)
├── api.php                  (Rutas API)
└── console.php

resources/views/
├── auth/                    (Login/Registro)
├── admin/                   (Dashboard Admin)
├── tecnicos/                (Dashboard Técnico)
├── tickets/                 (Gestión tickets)
├── usuarios/                (Gestión usuarios)
├── reportes/                (Reportes)
└── layouts/                 (Templates)
```

### Modelos y Relaciones:

| Modelo | Tabla | Descripción | Relaciones |
|--------|-------|-------------|-----------|
| **Usuario** | usuarios | Usuario + Autenticación | Rol, Tickets, Comentarios |
| **Rol** | roles | Admin, Técnico, Usuario | Usuarios |
| **Ticket** | tickets | Solicitud de soporte | Usuario, Técnico, Área, Estado, Prioridad |
| **Comentario** | comentarios | Comunicación en tickets | Ticket, Usuario |
| **Área** | areas | Rectoría, Admin, Finanzas, Docencia | Tickets |
| **Estado** | estados | Abierto, En Progreso, Cerrado | Tickets |
| **Prioridad** | prioridades | Baja, Media, Alta, Crítica | Tickets |
| **User** ❌ | users | NO USADO - DUPLICADO | Ninguna |

---

## 4. 🔄 FLUJO DE LA APLICACIÓN

### Ciclo de Vida de un Request:

```
1. Cliente hace HTTP Request
   ↓
2. Laravel recepciona en app.php
   ↓
3. Verifica ruta:
   ├─ /api/...   → Rutas API
   │  ├─ auth:sanctum
   │  ├─ role:X (si aplica)
   │  └─ Controller API
   │
   └─ /...       → Rutas Web
      ├─ web.auth
      ├─ web.admin/tecnico (si aplica)
      └─ Controller Web → View Blade
   ↓
4. Controller procesa:
   ├─ Validación de datos
   ├─ Interacción con Modelos
   └─ Retorna JSON o HTML
   ↓
5. Response al cliente
```

### Ejemplo: Crear Ticket (Usuario Normal)

```
1. GET /tickets/create
   → WebController->create()
   → Retorna formulario Blade

2. POST /tickets
   → Validación
   → WebController->store()
   → Inserta en BD
   → Redirect a /tickets/{id}

3. GET /tickets/{id}
   → Muestra detalle con estado
```

---

## 5. 👥 ANÁLISIS DE ROLES Y PERMISOS

### Jerarquía de Roles:

#### ADMINISTRADOR (id=1)
**Permisos:**
- Ver todos los tickets (sin filtros)
- Crear/Editar/Eliminar usuarios
- Asignar técnicos a tickets
- Cambiar estado de tickets
- Ver todos los reportes
- Exportar datos
- Acceso total al sistema

**Restricciones:** Ninguna

#### TÉCNICO (id=2)
**Permisos:**
- Ver tickets asignados a él
- Cambiar estado de tickets
- Agregar comentarios
- Ver historial de tickets
- Cambiar contraseña
- Recuperar contraseña

**Restricciones:**
- Solo ve sus tickets
- NO puede eliminar
- NO accede a reportes
- NO gestiona usuarios
- NO puede asignar técnicos
- NO ve tickets de otros técnicos

#### USUARIO NORMAL (id=3)
**Permisos:**
- Crear tickets (reportar problema)
- Ver sus propios tickets
- VER estado (no comentar)
- Cambiar contraseña (3 veces/mes)
- Recuperar contraseña
- Responder encuestas

**Restricciones:**
- Solo ve sus tickets
- NO puede cambiar estado
- NO ve comentarios internos
- NO accede a reportes
- NO gestiona usuarios
- NO puede eliminar tickets

### Verificación en 3 Niveles:

**1. Middleware de Autenticación:**
```php
Route::middleware('auth:sanctum')->group(...) // API
Route::middleware('web.auth')->group(...)     // Web
```

**2. Middleware de Rol:**
```php
Route::middleware('role:Administrador')->group(...)
Route::middleware('web.admin')->group(...)
```

**3. Verificación en Controlador:**
```php
if (!$request->user()->esAdministrador()) {
    return response()->json(['message' => 'No autorizado'], 403);
}
```

---

## 6. 👨‍💼 MÓDULO ADMINISTRADOR

### Funcionalidades:
- Dashboard con estadísticas globales
- Gestión completa de tickets
- CRUD de usuarios
- Reportes (por fecha, por técnico)
- Exportación de datos
- Perfil personal

### Rutas Principales:

**Web:**
```
GET  /dashboard                 → Dashboard
GET  /tickets                   → Listar todos
POST /tickets/{id}/asignar      → Asignar técnico
GET  /usuarios                  → Gestión usuarios
POST /usuarios                  → Crear usuario
GET  /reportes                  → Reportes
```

**API:**
```
GET  /api/tickets               → Listar todos
POST /api/tickets/{id}/asignar  → Asignar
PUT  /api/usuarios/{id}         → Editar usuario
```

### Controladores:
- WebController (dashboard, perfil)
- TicketWebController (gestión tickets)
- UsuarioWebController (CRUD usuarios)
- ReporteWebController (reportes)
- API Controllers respectivos

---

## 7. 🔧 MÓDULO TÉCNICO

### Funcionalidades:
- Dashboard técnico
- Ver tickets asignados
- Cambiar estado de tickets
- Agregar comentarios (solución)
- Ver historial
- Perfil

### Rutas Principales:

**Web:**
```
GET  /dashboard                   → Dashboard
GET  /tickets-asignados           → Mis tickets
GET  /tickets/{id}                → Ver detalle
POST /tickets/{id}/cambiar-estado → Cambiar estado
POST /tickets/{id}/comentarios    → Agregar comentario
GET  /historial-tickets           → Cerrados
```

**API:**
```
GET  /api/dashboard/asignados     → Mis tickets
PUT  /api/tickets/{id}/estado     → Cambiar estado
POST /api/tickets/{id}/comentarios → Comentar
```

### Restricciones:
- Solo ve sus tickets
- NO elimina
- NO cambia asignación
- NO ve reportes
- Descripción original BLOQUEADA (no edita)

---

## 8. 👤 MÓDULO USUARIO NORMAL

### Funcionalidades:
- Crear tickets
- Ver sus tickets
- Ver estado
- ✅ NUEVA: Responder encuestas
- Cambiar contraseña

### Rutas Principales:

**Web:**
```
GET  /dashboard                 → Dashboard
GET  /tickets/create            → Crear ticket
GET  /tickets/{id}              → Ver detalle
GET  /mis-tickets               → Mis tickets
GET  /encuestas                 → Encuestas (NUEVA)
```

**API:**
```
POST /api/auth/login            → Login
POST /api/tickets               → Crear ticket
GET  /api/tickets/{id}          → Ver detalle
POST /api/encuestas             → Responder encuesta (NUEVA)
```

### Restricciones:
- Solo ve sus tickets
- NO ve comentarios
- NO ve otros usuarios
- NO accede a reportes
- CAMPO PRIORIDAD: Ocult (Admin elige)
- CAMPO COMENTARIOS: Oculto (Solo técnico)
- CAMPO ÁREA: Autollenado
- Cambios password: 3/mes máximo
- SIN Asistente IA

---

## 9. ⚠️ CÓDIGO INNECESARIO

### CRÍTICOS:

#### 1. Duplicación de User Model
- **Problema:** Existe User.php que no se usa
- **Impacto:** Confusión, tabla 'users' huérfana
- **Solución:** Eliminar user.php y tabla users

#### 2. Token no Usado
- **Problema:** En WebController->login(), variable $token se crea pero nunca se usa
- **Solución:** Remover línea

### SECUNDARIOS:

#### 3. Validaciones Duplicadas
- **Problema:** Mismo código en TicketWebController y ApiTicketController
- **Solución:** Crear Form Request centralizado

#### 4. Sin Caché
- **Problema:** Catálogos consultados en cada request
- **Solución:** Implementar cache

#### 5. Sin Rate Limiting
- **Problema:** Login sin protección contra ataques
- **Solución:** Agregar rate limiting

---

## 10. 🚀 MEJORAS FASE 1 (ARQUITECTURA)

### Limpieza de Código:
1. Eliminar User.php
2. Eliminar tabla users
3. Remover variable token no usada
4. Crear Form Requests centralizadas

### Optimización:
1. Centralizar validaciones en FormRequests
2. Agregar caché para catálogos
3. Implementar eager loading
4. Agregar rate limiting en login

### Seguridad Fase 1:
1. Bloqueo de cuenta tras 3 intentos
2. Limite de cambios de contraseña (3/mes)
3. Validación de recuperar contraseña

---

## 11. 🎨 MEJORAS FASE 2 (UX/UI)

### Mejoras Visuales:

| Mejora | Descripción | Cómo |
|--------|-------------|------|
| **Tickets Críticos en ROJO** | Prioridad Crítica = fondo/texto rojo | CSS condicional en Blade |
| **Diseño ASIMÉTRICO** | Tarjetas y layouts no uniformes | Bootstrap custom + grid |
| **REFRESH AUTOMÁTICO** | Actualizar cada 30-60 seg O botón manual | AJAX + setInterval |
| **Descripción BLOQUEADA** | Técnico NO edita descripción original | disabled attribute |
| **Técnico en BLANCO** | Campo vacío hasta asignación | Condicional en Blade |
| **Estado PRE-SELECCIONADO** | Mostrar estado actual en modal | JavaScript pre-fill |
| **Indicador NUEVO** | Badge en tickets no leídos | Timestamp leido_por_tecnico |

### Cambios BD:
```sql
ALTER TABLE tickets ADD COLUMN (
    leido_por_tecnico TIMESTAMP NULL,
    leido_por_usuario TIMESTAMP NULL
);

ALTER TABLE usuarios ADD COLUMN (
    login_intentos INT DEFAULT 0,
    bloqueado_hasta TIMESTAMP NULL,
    cambios_password_mes INT DEFAULT 0,
    ultimo_cambio_password TIMESTAMP NULL
);
```

### Notificaciones en Tiempo Real:
- WebSockets (Socket.io + Pusher O Redis)
- Polling AJAX (cada 30 seg)
- Email notificaciones

---

## 12. 📋 NUEVOS REQUERIMIENTOS UPTEX

### ✓ ACCIONES REQUERIDAS POR ROL:

---

### ADMINISTRADOR - CAMBIOS:

#### 1. Reporte Escrito + Dates
- ✅ Ya existen: fecha_creacion, fecha_cierre
- ✅ Nueva columna: reporte_final (texto largo)

#### 2. ELIMINAR Área "Sistemas"
- **Actual:** Rectoría, Admin, Finanzas, Docencia, Sistemas
- **Nuevo:** Solo Rectoría, Admin y Finanzas, Docencia
- **Acción:** Actualizar seeders

#### 3. Contraseña Maestra
- **Nueva ruta:** POST /api/admin/cambiar-password/{usuario_id}
- **Validación:** Solo Admin + contraseña master

#### 4. Límite Cambios Password
- **Máximo:** 3 cambios por mes calendarios
- **Control:** Columna usuarios.cambios_password_mes
- **Reset:** Automático 1ro de mes

#### 5. Duplicar Reportes
- GET /api/reportes/tickets (existente)
- GET /api/reportes/tickets-por-titulo (nuevo)
- GET /api/reportes/por-usuario (nuevo)

#### 6. Acceso a Panel Técnico
- Mostrar tickets de todos los técnicos
- Ver asignaciones

### Nueva Funcionalidad:
- **Columna:** reporte_final (editable por técnico)
- **Columna:** quien_atendio (auto-filled)
- **Tabla:** audit_logs (para cambios críticos)

---

### TÉCNICO - CAMBIOS:

#### 1. ❌ Quitar Botón "Editar"
- Remover ruta PUT /tickets/{id} para técnico
- Mantener: Ver, Comentar, Cambiar Estado

#### 2. Descripción BLOQUEADA
```html
<input type="text" name="descripcion" disabled>
<!-- O -->
<p class="form-control-plaintext">{{ $ticket->descripcion }}</p>
```

#### 3. ✅ Recuperar Contraseña
- POST /api/auth/forgot-password
- POST /api/auth/reset-password/{token}

#### 4. Cambios Password: 3/mes
- Validar: usuarios.cambios_password_mes <= 2
- Incrementar al cambiar

#### 5. Áreas Seguras
- **Restricción:** Ver solo tickets de su área
- **Implementar:** Middleware validador de área

#### 6. Qué es un Ticket NUEVO:
```php
// En controller - cuando técnico abre ticket:
$ticket->update(['leido_por_tecnico' => now()]);

// En vista - mostrar indicador:
@if (!$ticket->leido_por_tecnico)
    <span class="badge badge-danger">NUEVO</span>
@endif
```

---

### USUARIO NORMAL - CAMBIOS:

#### 1. ❌ QUITAR: Prioridad
```php
// ANTES:
'prioridad_id' => 'required|exists:prioridades,id_prioridad'

// DESPUÉS:
// Línea eliminada - Admin elige prioridad
```

#### 2. ❌ QUITAR: Asistente IA
- Eliminar cualquier referencia

#### 3. ❌ QUITAR: Comentarios (ver)
```php
// No mostrar comentarios en view
// Solo técnico + admin ven comentarios
```

#### 4. ✅ Área AUTO-FILL
```php
// En create():
'area_id' => Auth::user()->area_id // Auto-fill

// En form:
<input type="hidden" name="area_id" value="{{ Auth::user()->area_id }}">
```

#### 5. Cambios Password: 3/mes
- Validar contador
- Mensaje: "Ha usado 2 de 3 cambios este mes"

#### 6. ✅ NUEVA: Encuestas de Satisfacción
- Nueva tabla: encuestas
- Campos: usuario_id, ticket_id, calificacion (1-5), comentarios
- Mostrar al cerrar ticket

---

## 13. 📅 PLAN DE IMPLEMENTACIÓN

### TIMELINE TOTAL: 18-25 días

### FASE 1: LIMPIEZA (2-3 DÍAS)

**Día 1:**
- Eliminar User.php
- Crear migración drop_users_table
- Remover variable token no usada
- Crear FormRequests centralizados

**Commits:**
```
git add .
git commit -m "chore: eliminar duplicados y limpiar código"
git push
```

### FASE 2: SEGURIDAD (3-4 DÍAS)

**Días 2-3:**
- Migración: agregar columnas usuarios (login_intentos, bloqueado_hasta, etc)
- Migración: agregar columnas tickets (leido_por_tecnico, leido_por_usuario)
- Implementar rate limiting en login

**Código:**
```php
// En AuthController->login()
if ($usuario->bloqueado_hasta && $usuario->bloqueado_hasta > now()) {
    return response()->json([
        'message' => 'Usuario bloqueado temporalmente'
    ], 429);
}
```

### FASE 3: UX/UI (5-7 DÍAS)

**Días 4-6:**
- Agregar estilos para prioridades (CSS)
- Implementar refresh automático (AJAX)
- Bloquear campos de edición
- Pre-seleccionar estados

**Días 7:**
- Pruebas UI
- Ajustes visuales

### FASE 4: CAMBIOS POR ROL (7-10 DÍAS)

**Dias 8-10:**
- Remover prioridad de usuario
- Quitar comentarios de usuario
- Autollenar área
- Crear tabla encuestas

**Días 11-12:**
- Quitar botón editar de técnico
- Bloquear descripción original
- Validar cambios password

**Días 13-15:**
- Filtrar áreas por técnico
- Implementar recuperar contraseña
- Crear reportes duplicados

### FASE 5: TESTING (5-7 DÍAS)

**Días 16-17:**
- Testing de cada módulo
- Testing de permisos
- Testing de seguridad

**Días 18-19:**
- Correcciones
- Capacitación

**Días 20-21:**
- Deploy en Hostinger
- Monitoreo

---

## 📊 TECNOLOGÍAS REQUERIDAS

### Backend:
- Laravel 12.0 ✓
- MySQL ✓
- Sanctum (autenticación API) ✓
- Eloquent ORM ✓

### Frontend (Mejoras):
- Bootstrap 5 (ya tiene)
- Alpine.js (interactividad)
- AJAX (jQuery o Fetch)
- Socket.io O Pusher (tiempo real - opcional)

### DevOps:
- Git ✓
- Composer ✓
- npm ✓
- PHP-CLI ✓

---

## 📝 CONCLUSIÓN

**Estado Actual:** ✅ Bien estructurado  
**Problemas:** ⚠️ Duplicados + Validaciones  
**Solución:** 🚀 Plan de 4 fases en 18-25 días  
**Resultado Final:** ✓ Sistema robusto, seguro y listo para UPTEX

### Cambios Principales:
1. Limpiar y optimizar código
2. Agregar seguridad (rate limiting, bloqueo cuenta)
3. Mejorar UI/UX (colores, refresh,indicadores)
4. Adaptar a requerimientos UPTEX (cambios por rol)
5. Agregar encuestas de satisfacción

**Próximo Paso:** Empezar FASE 1 - Limpieza de código

---

**Documento Versión:** 2.0  
**Última Actualización:** 14 de febrero de 2026  
**Estado:** ✅ Completo y Definitivo
