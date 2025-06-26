@extends('layouts.plantilla')

@section('title', 'Perfil de Usuario')

@section('content')
<style>
    body {
        background: #0f0f0f;
        color: #f0f0f0;
        font-family: 'Segoe UI', sans-serif;
    }

    h2, h5 {
        color: #00ffc3;
        text-shadow: 0 0 10px #00ffc3;
    }

    .neon-card {
        background-color: #1a1a1a;
        border: 1px solid #00ffc3;
        box-shadow: 0 0 20px rgba(0, 255, 195, 0.3);
        transition: transform 0.3s ease;
    }

    .neon-card:hover {
        transform: scale(1.02);
        box-shadow: 0 0 30px rgba(0, 255, 195, 0.6);
    }

    .form-control {
        background-color: #111;
        color: #fff;
        border: 1px solid #00ffc3;
    }

    .form-control:focus {
        border-color: #00ffc3;
        box-shadow: 0 0 10px #00ffc3;
        background-color: #151515;
        color: #fff;
    }

    .btn-primary {
        background-color: #00ffc3;
        border: none;
        color: #000;
        box-shadow: 0 0 10px #00ffc3;
    }

    .btn-warning {
        background-color: #ff9900;
        border: none;
        color: #000;
        box-shadow: 0 0 10px #ff9900;
    }

    .btn-danger {
        background-color: #ff0033;
        border: none;
        color: #fff;
        box-shadow: 0 0 10px #ff0033;
    }

    .alert-success {
        background-color: #00ffc3;
        color: #000;
        font-weight: bold;
        box-shadow: 0 0 10px #00ffc3;
    }

    label {
        color: #00ffc3;
    }
</style>

<div class="container mt-5">
    <h2 class="mb-4 text-center">👤 Perfil de Usuario</h2>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success text-center">✅ Perfil actualizado correctamente.</div>
    @endif

    {{-- FORMULARIO DE INFORMACIÓN --}}
    <div class="card neon-card p-4 rounded-4 mb-4">
        <h5 class="mb-3">📝 Información personal</h5>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
        </form>
    </div>

    {{-- CAMBIO DE CONTRASEÑA --}}
    <div class="card neon-card p-4 rounded-4 mb-4">
        <h5 class="mb-3">🔐 Cambiar contraseña</h5>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label class="form-label">Contraseña actual</label>
                <input type="password" class="form-control" name="current_password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nueva contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmar nueva contraseña</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-warning">🔁 Actualizar contraseña</button>
        </form>
    </div>

    {{-- ELIMINAR CUENTA --}}
    <div class="card neon-card p-4 rounded-4 mb-4">
        <h5 class="mb-3 text-danger">⚠️ Eliminar cuenta</h5>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-3">
                <label class="form-label">Contraseña para confirmar</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button type="submit" class="btn btn-danger"
                onclick="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.')">
                🗑️ Eliminar cuenta
            </button>
        </form>
    </div>
</div>
@endsection
