@extends('layouts.plantilla')

@section('title', 'Usuarios Registrados')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #fef9f8, #f1f8ff);
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
        background: linear-gradient(to right, #34495e, #2c3e50);
        color: white;
        padding: 14px;
        text-align: center;
    }

    tbody td {
        padding: 14px;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    tbody tr:hover {
        background-color: #f1f8ff;
        transition: background-color 0.3s;
    }

    .highlight-name {
        font-weight: bold;
        color: #8e44ad;
    }

    .highlight-email {
        color: #2980b9;
    }

    .highlight-role {
        font-weight: bold;
        color: #27ae60;
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
</style>

<h1>👥 Reporte de Usuarios Registrados</h1>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>👤 Nombre</th>
                <th>📧 Email</th>
                <th>📅 Fecha de Registro</th>
                <th>🛡️ Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td class="highlight-name">{{ $usuario->name }}</td>
                    <td class="highlight-email">{{ $usuario->email }}</td>
                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    <td class="highlight-role">{{ $usuario->getRoleNames()->first() ?? 'Sin rol' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<a href="{{ route('dashboard') }}" class="btn-volver">🏠 Volver al Dashboard</a>
@endsection
