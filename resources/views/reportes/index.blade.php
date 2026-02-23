@extends('layouts.app')

@section('title', 'Reportes y Estadísticas')

@section('content')
<style>
    .report-card {
        background: white;
        border-radius: 20px;
        padding: clamp(1rem, 5vw, 2rem);
        text-align: center;
        height: 100%;
        border: 1px solid #f0f0f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        transition: transform 0.2s;
    }
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .report-icon {
        font-size: clamp(2rem, 8vw, 3.5rem);
        margin-bottom: 1rem;
        color: #1E293B;
    }
    .stat-box {
        padding: clamp(1rem, 4vw, 1.5rem);
        border-radius: 12px;
        text-align: center;
    }
    .stat-box span {
        font-size: clamp(1.5rem, 4vw, 2rem);
        font-weight: bold;
        display: block;
        margin-bottom: 0.5rem;
    }
    .stat-box small {
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        display: block;
    }
</style>

<div class="container-fluid px-2 px-md-4">
    <div class="mb-3 mb-md-4">
        <h2 class="fw-bold" style="font-size: clamp(1.5rem, 5vw, 2rem);"><i class="bi bi-graph-up me-2"></i>Reportes y Estadísticas</h2>
    </div>

    <div class="row g-2 g-md-3 g-lg-4 mb-4 mb-md-5">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="report-card">
                <i class="bi bi-calendar-event report-icon text-primary"></i>
                <h4 style="font-size: clamp(1.1rem, 3vw, 1.3rem);">Tickets por Fecha</h4>
                <p style="font-size: clamp(0.9rem, 2vw, 1rem);">Generar reporte de tickets en un rango de fechas</p>
                <button class="btn btn-primary w-100 py-2 py-md-3 fw-bold">
                    <i class="bi bi-download me-2"></i><span class="d-none d-sm-inline">Generar</span>
                </button>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="report-card">
                <i class="bi bi-people report-icon text-warning"></i>
                <h4 style="font-size: clamp(1.1rem, 3vw, 1.3rem);">Rendimiento de Técnicos</h4>
                <p style="font-size: clamp(0.9rem, 2vw, 1rem);">Ver estadísticas de desempeño</p>
                <button class="btn btn-warning w-100 py-2 py-md-3 fw-bold text-dark">
                    <i class="bi bi-eye me-2"></i><span class="d-none d-sm-inline">Ver Reporte</span>
                </button>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-4">
            <div class="report-card">
                <i class="bi bi-file-earmark-spreadsheet report-icon text-success"></i>
                <h4 style="font-size: clamp(1.1rem, 3vw, 1.3rem);">Exportar Datos</h4>
                <p style="font-size: clamp(0.9rem, 2vw, 1rem);">Descargar todos los tickets en CSV</p>
                <button class="btn btn-success w-100 py-2 py-md-3 fw-bold">
                    <i class="bi bi-file-earmark-arrow-down me-2"></i><span class="d-none d-sm-inline">Exportar</span>
                </button>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-2 p-md-4">
        <h5 class="mb-3 mb-md-4 fw-bold" style="font-size: clamp(1.1rem, 3vw, 1.3rem);"><i class="bi bi-bar-chart me-2"></i>Estadísticas del Sistema</h5>
        <div class="row g-2 g-md-3">
            <div class="col-6 col-lg-3">
                <div class="stat-box" style="background: #eff6ff;">
                    <span style="color: #2563eb;">14</span>
                    <small class="text-muted">Total Usuarios</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-box" style="background: #fffbeb;">
                    <span style="color: #d97706;">3</span>
                    <small class="text-muted">Técnicos</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-box" style="background: #f0fdf4;">
                    <span style="color: #16a34a;">25</span>
                    <small class="text-muted">Tickets</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-box" style="background: #f8fafc;">
                    <span style="color: #475569;">4</span>
                    <small class="text-muted">Cerrados</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
        </div>
    </div>
</div>
@endsection