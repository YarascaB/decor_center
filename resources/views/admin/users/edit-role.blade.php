@extends('layouts.plantilla')

@section('title', 'Editar Rol')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #e3f2fd, #fce4ec);
    }

    .fade-in {
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-card {
        background: linear-gradient(to bottom right, #ffffffee, #f7f7f7dd);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        border: 1px solid #dee2e6;
        transition: transform 0.3s ease;
    }

    .form-card:hover {
        transform: translateY(-3px);
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    select.form-select {
        background-color: #f1f3f5;
        border: 1px solid #ced4da;
        transition: box-shadow 0.3s ease;
    }

    select.form-select:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn-cancel {
        background-color: #dee2e6;
        color: #495057;
        border: none;
    }

    .btn-cancel:hover {
        background-color: #ced4da;
    }

    .btn-submit {
        background: linear-gradient(to right, #4facfe, #00f2fe);
        border: none;
        color: white;
        font-weight: 600;
        transition: transform 0.2s ease;
    }

    .btn-submit:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .title-icon {
        font-size: 2rem;
        color: #0d6efd;
        margin-right: 0.5rem;
        vertical-align: middle;
    }
</style>

<div class="container mt-5 fade-in">
    <h2 class="mb-4 text-center">
        <span class="title-icon">🛠️</span>Modificar Rol de <strong>{{ $user->name }}</strong>
    </h2>

    <div class="form-card mx-auto fade-in" style="max-width: 500px;">
        <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="role" class="form-label">Selecciona el rol</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="">-- Elegir rol --</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->name }}" {{ $user->hasRole($rol->name) ? 'selected' : '' }}>
                            {{ ucfirst($rol->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}" class="btn btn-cancel px-4">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-submit px-4">
                    Actualizar Rol
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
