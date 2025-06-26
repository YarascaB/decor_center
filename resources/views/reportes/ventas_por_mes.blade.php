@extends('layouts.plantilla')

@section('title', 'Reporte de ventas por mes')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #e8f5e9);
        font-family: 'Segoe UI', sans-serif;
    }

    h1 {
        text-align: center;
        margin-top: 30px;
        font-weight: 700;
        color: #2c3e50;
    }

    h2 {
        margin-top: 40px;
        font-weight: 600;
        color: #34495e;
        text-align: center;
    }

    .table-container {
        margin: 30px auto;
        max-width: 900px;
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th {
        background: linear-gradient(to right, #34495e, #2c3e50);
        color: white;
        padding: 12px;
        font-size: 16px;
    }

    td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    tbody tr:hover {
        background-color: #f0f8ff;
        transition: background-color 0.3s;
    }

    .btn-volver {
        margin: 40px auto;
        display: block;
        padding: 12px 30px;
        font-weight: bold;
        font-size: 16px;
        background: linear-gradient(to right, #3498db, #2c81ba);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-volver:hover {
        background: linear-gradient(to right, #5dade2, #3498db);
        transform: scale(1.05);
    }

    .highlight-total {
        font-weight: bold;
        color: #27ae60;
    }

    .highlight-product {
        font-weight: bold;
        color: #8e44ad;
    }
</style>

<h1>📊 Reporte de Ventas</h1>

<div class="table-container">
    <h2>📅 Ventas Totales por Mes</h2>
    <table>
        <thead>
            <tr>
                <th>Mes</th>
                <th>Total Vendido (S/.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventasPorMes as $venta)
                <tr>
                    <td>{{ $venta->mes }}</td>
                    <td class="highlight-total">S/. {{ number_format($venta->total_ventas, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-container">
    <h2>📦 Ventas por Producto</h2>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Mes</th>
                <th>Total Vendido (S/.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventasPorProducto as $detalle)
                <tr>
                    <td class="highlight-product">{{ strtoupper($detalle->producto) }}</td>
                    <td>{{ $detalle->mes }}</td>
                    <td>S/. {{ number_format($detalle->total_ventas, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a href="{{ route('dashboard') }}" class="btn-volver">🏠 Volver al Dashboard</a>
@endsection
