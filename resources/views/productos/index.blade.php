@extends('layouts.plantilla')

@section('title', 'Lista de productos')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #f0f2f5, #eaf4fc);
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: bold;
        color: #2c3e50;
    }

    .btn {
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        color: white;
        border: none;
    }

    .btn-agregar {
        background: linear-gradient(to right, #1abc9c, #16a085);
    }

    .btn-agregar:hover {
        background: linear-gradient(to right, #48c9b0, #1abc9c);
        transform: scale(1.05);
    }

    .btn-vender {
        background: linear-gradient(to right, #f39c12, #e67e22);
        margin-top: 5px;
    }

    .btn-vender:hover {
        background: linear-gradient(to right, #f1c40f, #f39c12);
        transform: scale(1.05);
    }

    .btn-regresar {
        background: linear-gradient(to right, #3498db, #2980b9);
    }

    .btn-regresar:hover {
        background: linear-gradient(to right, #5dade2, #3498db);
    }

    .btn-salir {
        background: linear-gradient(to right, #e74c3c, #c0392b);
    }

    .btn-salir:hover {
        background: linear-gradient(to right, #ec7063, #e74c3c);
    }

    .botones-navegacion {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }

    .table-wrapper {
        overflow-x: auto;
        background: white;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        padding: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }

    th {
        background-color: #2c3e50;
        color: white;
        padding: 12px;
        text-align: center;
    }

    td {
        padding: 10px;
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid #ddd;
    }

    tbody tr:hover {
        background-color: #f2f2f2;
        transition: background-color 0.2s ease;
    }
</style>

<div class="container mt-4">
    <h1>📦 Lista de Productos</h1>

    @role('admin|editor')
    <div class="mb-3 text-center">
        <a href="{{ route('productos.create') }}" class="btn btn-agregar">➕ Agregar Producto</a>
    </div>
    @endrole

    <div class="table-wrapper mb-4">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ strtoupper($producto->name) }}</td>
                        <td>{{ $producto->category }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td>${{ number_format($producto->price, 2) }}</td>
                        <td>{{ $producto->description }}</td>
                        <td>
                            @role('admin|vendedor')
                            <a href="{{ route('ventas.crear', $producto->id) }}" class="btn btn-vender">🛒 Vender</a>
                            @endrole
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="botones-navegacion">
        <a href="{{ url()->previous() }}" class="btn btn-regresar">⬅️ Regresar</a>
        <a href="{{ route('home') }}" class="btn btn-salir">🏠 Salir</a>
    </div>
</div>
@endsection
