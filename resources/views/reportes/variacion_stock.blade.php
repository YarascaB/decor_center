@extends('layouts.plantilla')

@section('title', 'Variación de Stock')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #f0f9ff, #e0f7fa);
        font-family: 'Segoe UI', sans-serif;
    }

    h1 {
        text-align: center;
        margin-top: 40px;
        color: #2c3e50;
        font-weight: 700;
    }

    .table-container {
        max-width: 1000px;
        margin: 30px auto;
        background-color: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
        margin-top: 10px;
    }

    thead th {
        background: linear-gradient(to right, #2c3e50, #34495e);
        color: white;
        padding: 14px;
        text-align: center;
    }

    tbody td {
        padding: 14px;
        border-bottom: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
    }

    tbody tr:hover {
        background-color: #ecf7ff;
        transition: background-color 0.3s;
    }

    .btn-volver {
        display: block;
        margin: 30px auto 60px;
        padding: 12px 30px;
        font-weight: bold;
        font-size: 16px;
        background: linear-gradient(to right, #3498db, #2c81ba);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
        text-align: center;
        max-width: 280px;
    }

    .btn-volver:hover {
        background: linear-gradient(to right, #5dade2, #3498db);
        transform: scale(1.05);
    }

    .highlight-product {
        font-weight: bold;
        color: #8e44ad;
    }

    .stock-number {
        font-weight: bold;
        color: #27ae60;
    }

    .entry {
        color: #2980b9;
        font-weight: bold;
    }

    .exit {
        color: #c0392b;
        font-weight: bold;
    }
</style>

<h1>📦 Reporte de Variación de Stock</h1>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>📅 Fecha</th>
                <th>🛒 Producto</th>
                <th>➕ Entradas</th>
                <th>➖ Salidas</th>
                <th>📦 Stock Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $item)
                <tr>
                    <td>{{ $item->fecha }}</td>
                    <td class="highlight-product">{{ strtoupper($item->producto) }}</td>
                    <td class="entry">{{ $item->entradas }}</td>
                    <td class="exit">{{ $item->salidas }}</td>
                    <td class="stock-number">{{ $stocksActuales[$item->producto] ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a href="{{ route('dashboard') }}" class="btn-volver">🏠 Volver al Dashboard</a>
@endsection
