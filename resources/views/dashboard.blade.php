@extends('layouts.plantilla')

@section('title', 'Dashboard')

@section('content')
<style>
    /* Animación de fade-in para el título principal */
    @keyframes fadeInSlide {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .fade-in-slide {
        animation: fadeInSlide 1s ease forwards;
    }

    /* Hover en tarjetas */
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }

    /* Hover en botones */
    .btn-custom:hover {
        box-shadow: 0 4px 12px rgba(0,123,255,0.4);
        transform: scale(1.05);
        transition: all 0.3s ease;
    }

    /* Badge stock bajo */
    .badge-stock-low {
        background-color: #dc3545;
        font-weight: 600;
        font-size: 0.75rem;
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 0.3em 0.6em;
        border-radius: 0.5rem;
        box-shadow: 0 0 5px rgba(220,53,69,0.7);
    }

    /* Banner alerta sidebar */
    .sidebar-alert {
        background: linear-gradient(90deg, #ff6b6b, #f06595);
        padding: 0.8rem 1rem;
        border-radius: 0.5rem;
        color: white;
        font-weight: 600;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.6);
        text-align: center;
    }
</style>


<div class="container mt-5">
    <div class="row gx-4">
        <!-- Columna lateral -->
        <div class="col-md-3 bg-primary text-white p-4 rounded-3 shadow-sm d-flex flex-column align-items-start">

            <!-- Banner alerta stock bajo -->
            @php
                $productosBajoStock = $productos->filter(fn($p) => $p->stock < 5)->count();
            @endphp

            @if($productosBajoStock > 0)
            <div class="sidebar-alert">
                ⚠️ {{ $productosBajoStock }} producto(s) con stock bajo
            </div>
            @endif

            <h4 class="fw-bold">Bienvenido, {{ Auth::user()->name }}</h4>
            <hr class="border-light w-100 my-3">
            <p class="mb-4 fs-5">Panel de Control de Inventario</p>

            <a href="{{ route('productos.index') }}" class="btn btn-light text-primary w-100 mb-3 fw-semibold shadow-sm btn-custom" style="border-radius: 30px;">
                <i class="fas fa-box-open me-2"></i> Ver Productos
            </a>

            @role('admin|editor')
            <a href="{{ route('productos.create') }}" class="btn btn-light text-primary w-100 mb-3 fw-semibold shadow-sm btn-custom" style="border-radius: 30px;">
                <i class="fas fa-plus-circle me-2"></i> Agregar Producto
            </a>
            @endrole

            @role('admin')
            <button type="button" class="btn btn-light text-primary w-100 fw-semibold shadow-sm btn-custom" data-bs-toggle="modal" data-bs-target="#modalReportes" style="border-radius: 30px;">
                <i class="fas fa-chart-bar me-2"></i> Reportes
            </button>
            @endrole
        </div>

        <!-- Columna principal -->
        <div class="col-md-9">
            <h1 class="mb-5 text-center fw-bold text-primary fade-in-slide" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.1);">Bienvenido al Panel de Inventario</h1>

            <div class="row mb-4">
                <div class="col text-center">
                    <h3 class="fw-semibold text-secondary">Productos en Inventario</h3>
                </div>
            </div>

            <div class="row gx-4 gy-4">
                @foreach ($productos as $producto)
                <div class="col-lg-4 col-md-6 col-sm-12 position-relative">
                    <div class="card h-100 shadow border-0 rounded-4" style="transition: transform 0.3s ease;">
                        
                        {{-- Badge de stock bajo --}}
                        @if($producto->stock < 5)
                            <span class="badge-stock-low">¡Stock bajo!</span>
                        @endif

                        <div class="card-body d-flex flex-column" style="background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);">
                            <h5 class="card-title text-primary fw-bold">{{ strtoupper($producto->name) }}</h5>
                            <p class="card-text flex-grow-1">
                                <strong>Stock:</strong> {{ $producto->stock }} <br>
                                <strong>Precio:</strong> ${{ number_format($producto->price, 2) }} <br>
                                <strong>Descripción:</strong> {{ $producto->description }}
                            </p>

                            <div class="d-flex justify-content-between mt-3">
                                @role('admin|editor')
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-outline-warning btn-sm rounded-pill shadow-sm btn-custom" style="width: 48%;">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>
                                @endrole

                                @role('admin|editor')
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="width: 48%;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill shadow-sm w-100 btn-custom">
                                        <i class="fas fa-trash-alt me-1"></i> Eliminar
                                    </button>
                                </form>
                                @endrole
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal de Reportes -->
<div class="modal fade" id="modalReportes" tabindex="-1" aria-labelledby="modalReportesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow-lg">
        <div class="modal-header bg-primary text-white rounded-top-4">
          <h5 class="modal-title" id="modalReportesLabel">📊 Reportes</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>Selecciona el reporte que deseas visualizar:</p>
          <a href="{{ route('reportes.ventas_por_mes') }}" class="btn btn-outline-primary w-100 mb-2 rounded-pill shadow-sm btn-custom">📈 Ventas por mes</a>
          <a href="{{ route('reportes.productos_mas_vendidos') }}" class="btn btn-outline-primary w-100 mb-2 rounded-pill shadow-sm btn-custom">🔥 Productos más vendidos</a>
          <a href="{{ route('reportes.variacion_stock') }}" class="btn btn-outline-primary w-100 mb-2 rounded-pill shadow-sm btn-custom">⚠️ Variación de Stock</a>
          <a href="{{ route('reportes.usuarios_registrados') }}" class="btn btn-outline-primary w-100 mb-2 rounded-pill shadow-sm btn-custom">👥 Usuarios Registrados</a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>  
@endsection
