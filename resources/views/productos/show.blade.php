@extends('layouts.plantilla')

@section('title', 'Producto ' . $producto->name)

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #2c3e50, #4ca1af);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #f4f4f4;
        min-height: 100vh;
        padding: 2rem;
    }

    .product-detail {
        background: rgba(255, 255, 255, 0.05);
        padding: 2rem;
        border-radius: 16px;
        backdrop-filter: blur(8px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }

    h1 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: #ffffff;
    }

    a.button {
        display: inline-block;
        margin-right: 1rem;
        margin-bottom: 1.5rem;
        padding: 0.6rem 1rem;
        background-color: #34495e;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    a.button:hover {
        background-color: #2c3e50;
    }

    p {
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        font-size: 1rem;
        color: #ecf0f1;
    }

    .category {
        font-weight: bold;
        color: #f0d911;
    }
</style>

<div class="product-detail">
    <h1>Producto: {{ $producto->name }}</h1>

    <a class="button" href="{{ route('productos.index') }}">Volver a Productos</a>
    <a class="button" href="{{ route('productos.edit', $producto) }}">Editar Producto</a>

    <p><strong>Categoría:</strong> <span class="category">{{ $producto->category }}</span></p>
    <p><strong>Precio:</strong> ${{ number_format($producto->price, 2) }}</p>
    <p><strong>Descripción:</strong> {{ $producto->description }}</p>

    @if($category)
        <h2 class="category">Categoría Detallada: {{ $category }}</h2>
    @endif
</div>
@endsection
