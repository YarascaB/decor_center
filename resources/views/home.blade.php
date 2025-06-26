@extends('layouts.plantilla')

@section('title', 'Home')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #2c3e50, #4ca1af);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #f4f4f4;
        min-height: 100vh;
        padding: 2rem;
    }

    .inicio-container {
        background: rgba(255, 255, 255, 0.05);
        padding: 3rem;
        border-radius: 20px;
        backdrop-filter: blur(8px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }

    .inicio-container h1 {
        font-size: 2.8rem;
        font-weight: bold;
        margin-bottom: 1rem;
        color: #ffffff;
    }

    .inicio-container p {
        font-size: 1.2rem;
        color: #e0e0e0;
        margin-top: 0.5rem;
    }

    .btn-productos {
        display: inline-block;
        margin-top: 2rem;
        padding: 0.8rem 1.5rem;
        background-color: #34495e;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-productos:hover {
        background-color: #2c3e50;
    }

    .auth-buttons {
        margin-top: 2rem;
    }

    .btn-login, .btn-register {
        display: inline-block;
        padding: 0.8rem 1.5rem;
        background-color: #e67e22;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        margin: 0.5rem;
    }

    .btn-login:hover, .btn-register:hover {
        background-color: #d35400;
    }

    .btn-logout {
        display: inline-block;
        margin-top: 2rem;
        padding: 0.8rem 1.5rem;
        background-color: #c0392b;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-logout:hover {
        background-color: #e74c3c;
    }
</style>

<div class="inicio-container">
    <h1>Bienvenido a DECOR CENTER</h1>
    <p>Sistema de Inventario.</p>

    @auth
        <a href="{{ route('productos.index') }}" class="btn-productos">Ver Productos</a>
        <!-- Botón de cerrar sesión -->
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-logout">Cerrar sesión</button>
        </form>
    @else
        <div class="auth-buttons">
            <a href="{{ route('login') }}" class="btn-login">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="btn-register">Crear cuenta</a>
        </div>
    @endauth
</div>
@endsection