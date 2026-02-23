@extends('layouts.app')

@section('title', 'Ficha Técnica #' . $ticket->id_ticket)

@section('content')
<style>
    .figma-bg { 
        background-color: #f8f9fa; 
        padding: clamp(1rem, 5vw, 2rem);
        font-family: 'Inter', sans-serif; 
    }
    .ticket-box { 
        background: #D9D9D9;
        border: 2px solid #000; 
        border-radius: clamp(1.5rem, 5vw, 2.5rem);
        padding: clamp(1.5rem, 5vw, 2.5rem);
        margin: 0 auto;
        max-width: 950px;
    }
    .label-text { 
        font-weight: 800; 
        color: #000; 
        text-transform: uppercase; 
        margin-right: 10px; 
        font-size: clamp(0.75rem, 2vw, 0.9rem);
    }
    .white-pill { 
        background: white; 
        border: 1px solid #000; 
        border-radius: 25px; 
        padding: clamp(0.3rem, 2vw, 0.5rem) clamp(0.75rem, 3vw, 1.25rem);
        display: inline-block; 
        min-width: clamp(120px, 80vw, 180px);
        font-weight: 600;
        font-size: clamp(0.75rem, 2vw, 0.9rem);
    }
    .badge-large {
        border-radius: 20px; 
        padding: clamp(0.5rem, 2vw, 0.75rem) clamp(1rem, 4vw, 1.875rem);
        color: white; 
        font-weight: 900; 
        border: 2px solid #000;
        display: inline-block;
        font-size: clamp(0.8rem, 2vw, 0.95rem);
    }
    .desc-box { 
        background: white; 
        border: 2px solid #000; 
        border-radius: 25px; 
        padding: clamp(1rem, 4vw, 1.25rem);
        margin-top: clamp(1rem, 4vw, 1.5rem);
        min-height: 100px;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    .comments-area { 
        margin-top: clamp(1.5rem, 5vw, 2rem);
        border-top: 2px dashed #000; 
        padding-top: clamp(1rem, 4vw, 1.25rem);
    }
    .bubble { 
        background: white; 
        border: 1px solid #000; 
        border-radius: 15px; 
        padding: clamp(0.75rem, 3vw, 1rem);
        margin-bottom: clamp(0.5rem, 2vw, 0.75rem);
        font-size: clamp(0.8rem, 2vw, 0.9rem);
    }
    .bubble strong { font-size: clamp(0.85rem, 2vw, 0.95rem); }
    .bubble small { font-size: clamp(0.7rem, 1.5vw, 0.8rem); }
    @media print { .no-print { display: none; } }
</style>

<div class="figma-bg">
    <div class="d-flex justify-content-between align-items-center mb-2 mb-md-3 mb-lg-4 no-print flex-wrap gap-2">
        <h3 style="font-size: clamp(1.2rem, 4vw, 1.5rem);">
            UPTEX <span class="text-primary">TICKETS</span>
        </h3>
        <div class="white-pill">{{ session('usuario_nombre') }} (Técnico)</div>
    </div>

    <div class="ticket-box shadow-sm">
        <div class="row g-2 g-md-3">
            <div class="col-12 col-md-7">
                <div class="mb-2 mb-md-3">
                    <span class="label-text d-block mb-1">CREADO POR:</span> 
                    <div class="white-pill">{{ $ticket->usuario->nombre_completo }}</div>
                </div>
                <div class="mb-2 mb-md-3">
                    <span class="label-text d-block mb-1">MATRICULA:</span> 
                    <div class="white-pill">{{ $ticket->usuario->matricula ?? 'N/A' }}</div>
                </div>
                <div class="mb-2 mb-md-3">
                    <span class="label-text d-block mb-1">AREA:</span> 
                    <div class="white-pill">{{ $ticket->area->nombre }}</div>
                </div>
            </div>
            <div class="col-12 col-md-5 text-md-end">
                <div class="mb-2 mb-md-3">
                    <span class="label-text d-block mb-1">PRIORIDAD:</span>
                    <div class="badge-large" style="background: {{ $ticket->prioridad->nivel >= 3 ? 'red' : 'blue' }};">{{ $ticket->prioridad->nombre }}</div>
                </div>
                <div>
                    <span class="label-text d-block mb-1">ESTADO:</span>
                    <div class="badge-large" style="background: #00FF00; color: black;">{{ $ticket->estado->nombre }}</div>
                </div>
            </div>
        </div>

        <div class="mt-3 mt-md-4">
            <h5 class="text-center label-text" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">DESCRIPCIÓN:</h5>
            <div class="desc-box">{{ $ticket->descripcion }}</div>
        </div>

        <div class="comments-area">
            <h6 class="label-text mb-2 mb-md-3" style="font-size: clamp(0.85rem, 2vw, 0.95rem);">Historial de Comentarios:</h6>
            @forelse($ticket->comentarios as $com)
                <div class="bubble">
                    <strong>{{ $com->usuario->nombre_completo }}</strong> 
                    <small class="text-muted">({{ $com->created_at->diffForHumans() }})</small><br>
                    <span style="font-size: clamp(0.8rem, 2vw, 0.9rem);">{{ $com->contenido }}</span>
                </div>
            @empty
                <p class="text-center small" style="font-size: clamp(0.8rem, 2vw, 0.9rem);">No hay comentarios aún.</p>
            @endforelse
        </div>
    </div>

    <div class="text-center mt-3 mt-md-5 no-print d-flex gap-2 gap-md-3 justify-content-center flex-wrap">
        <button onclick="window.print()" class="btn btn-dark px-3 px-md-5 py-2 py-md-3" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 0.95rem);">
            Imprimir Ficha
        </button>
        <a href="{{ route('tickets.asignados') }}" class="btn btn-secondary px-3 px-md-5 py-2 py-md-3" style="min-height: 44px; font-size: clamp(0.9rem, 2vw, 0.95rem);">
            Volver
        </a>
    </div>
</div>
@endsection