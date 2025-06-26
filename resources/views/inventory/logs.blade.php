@extends('layouts.plantilla')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1f1f1f, #2e3b4e);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        color: #f0f0f0;
    }

    .historial-container {
        background: rgba(30, 35, 50, 0.85);
        padding: 2.5rem 3rem;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.45);
        max-width: 1100px;
        margin: 50px auto 80px;
        transition: box-shadow 0.3s ease;
    }

    .historial-container:hover {
        box-shadow: 0 18px 48px rgba(0, 0, 0, 0.6);
    }

    h2 {
        text-align: center;
        margin-bottom: 2.5rem;
        font-size: 2.2rem;
        font-weight: 700;
        color: #f9d976; /* dorado claro */
        text-shadow: 1px 1px 8px rgba(249, 217, 118, 0.8);
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
        color: #e1e1e1;
        font-size: 0.95rem;
    }

    thead tr {
        background-color: #394867;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    thead th {
        padding: 12px 18px;
        font-weight: 600;
        text-align: left;
        color: #f9d976;
        letter-spacing: 0.03em;
        user-select: none;
    }

    tbody tr {
        background: linear-gradient(90deg, #22314f, #2c3e70);
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    tbody tr:hover {
        background: linear-gradient(90deg, #f9d976, #f1c40f);
        color: #1b1b1b;
        cursor: default;
        transform: scale(1.02);
        box-shadow: 0 8px 18px rgba(249, 217, 118, 0.7);
    }

    tbody td {
        padding: 14px 18px;
        vertical-align: middle;
    }

    /* Para evitar que las celdas queden pegadas en filas con border-spacing */
    tbody tr td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }

    tbody tr td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Scroll horizontal en pantallas pequeñas */
    @media (max-width: 768px) {
        .historial-container {
            padding: 1.5rem 1.5rem;
            margin: 20px auto 40px;
            overflow-x: auto;
        }

        table {
            font-size: 0.85rem;
        }
    }

    /* Paginación */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 2.5rem;
        user-select: none;
    }

    .pagination .page-link {
        background-color: #394867;
        color: #f9d976;
        border: none;
        margin: 0 6px;
        padding: 0.6rem 0.9rem;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.25);
        transition: background-color 0.3s, color 0.3s;
        cursor: pointer;
    }

    .pagination .page-link:hover {
        background-color: #f9d976;
        color: #22314f;
    }

    .pagination .active .page-link {
        background-color: #f1c40f;
        color: #1b1b1b;
        box-shadow: 0 4px 14px rgba(241, 196, 15, 0.9);
        cursor: default;
    }

    /* Botón volver */
    .btn-volver {
        display: inline-block;
        margin-top: 35px;
        padding: 12px 28px;
        background: linear-gradient(45deg, #f9d976, #f1c40f);
        color: #1b1b1b;
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 40px;
        box-shadow: 0 6px 18px rgba(241, 196, 15, 0.6);
        transition: background 0.4s ease, color 0.4s ease;
        user-select: none;
    }

    .btn-volver:hover {
        background: linear-gradient(45deg, #f1c40f, #f9d976);
        color: #111;
        box-shadow: 0 8px 24px rgba(241, 196, 15, 0.85);
    }

    .pagination-modern {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 14px;
    margin-top: 2.5rem;
    flex-wrap: wrap;
}

.page-btn {
    width: 42px;
    height: 42px;
    border: none;
    border-radius: 50%;
    background: linear-gradient(145deg, #394867, #22314f);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: transform 0.2s ease, background 0.3s ease;
}

.page-btn:hover {
    background: #f9d976;
    transform: scale(1.1);
}

.page-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    box-shadow: none;
}

.arrow {
    display: inline-block;
    width: 0;
    height: 0;
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
}

.arrow.left {
    border-right: 10px solid #f9d976;
}

.arrow.right {
    border-left: 10px solid #f9d976;
}

.page-number {
    min-width: 40px;
    height: 42px;
    border-radius: 10px;
    background: #394867;
    color: #f9d976;
    font-weight: bold;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    transition: background 0.3s ease, transform 0.2s ease;
}

.page-number:hover {
    background: #f9d976;
    color: #22314f;
    transform: scale(1.05);
}

.page-number.active {
    background: #f1c40f;
    color: #1b1b1b;
    box-shadow: 0 4px 12px rgba(241, 196, 15, 0.7);
    cursor: default;
}


    
</style>

<div class="historial-container" role="region" aria-label="Historial de Inventario">
    <h2>Historial de Inventario</h2>

    <table>
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Producto</th>
                <th scope="col">Tipo</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Usuario</th>
                <th scope="col">Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $log->product->name }}</td>
                <td>{{ ucfirst($log->type) }}</td>
                <td>{{ $log->quantity }}</td>
                <td>{{ $log->user->name ?? 'Sistema' }}</td>
                <td>{{ $log->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($logs->hasPages())
<nav class="pagination-modern" role="navigation" aria-label="Paginación del historial">
    {{-- Botón Anterior --}}
    @if ($logs->onFirstPage())
        <button class="page-btn disabled" disabled>
            <span class="arrow left"></span>
        </button>
    @else
        <a href="{{ $logs->previousPageUrl() }}" class="page-btn">
            <span class="arrow left"></span>
        </a>
    @endif

    {{-- Números de página --}}
    @foreach ($logs->links()->elements[0] as $page => $url)
        @if ($page == $logs->currentPage())
            <span class="page-number active">{{ $page }}</span>
        @else
            <a href="{{ $url }}" class="page-number">{{ $page }}</a>
        @endif
    @endforeach

    {{-- Botón Siguiente --}}
    @if ($logs->hasMorePages())
        <a href="{{ $logs->nextPageUrl() }}" class="page-btn">
            <span class="arrow right"></span>
        </a>
    @else
        <button class="page-btn disabled" disabled>
            <span class="arrow right"></span>
        </button>
    @endif
</nav>
@endif

    <a href="{{ route('dashboard') }}" class="btn-volver" role="button" aria-label="Volver al Dashboard">Volver al Dashboard</a>
</div>
@endsection
