@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg mx-auto p-4" style="max-width: 600px; border-radius: 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="text-center mb-4">
            <h2 class="fw-bold">✨ Crear Nuevo Cliente</h2>
            <p class="opacity-75">Llena el formulario para registrar un cliente nuevo</p>
            <i class="bi bi-person-plus-fill" style="font-size: 3rem;"></i>
        </div>
        <form action="{{ route('clientes.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre completo <span class="text-warning">*</span></label>
                <div class="input-group has-validation">
                    <span class="input-group-text bg-white"><i class="bi bi-person-fill text-primary"></i></span>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Juan Pérez">
                    <div class="invalid-feedback">Por favor, ingresa el nombre completo.</div>
                </div>
                @error('nombre')
                    <div class="text-warning mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-envelope-fill text-primary"></i></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="correo" name="correo" value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                </div>
                @error('email')
                    <div class="text-warning mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-telephone-fill text-primary"></i></span>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="+57 300 123 4567">
                </div>
            </div>

            <div class="mb-4">
                <label for="direccion" class="form-label fw-semibold">Dirección</label>
                <textarea class="form-control" id="direccion" name="direccion" rows="3" placeholder="Calle 123 #45-67">{{ old('direccion') }}</textarea>
            </div>

            <button type="submit" class="btn btn-light fw-bold w-100 shadow-sm" style="color: #764ba2; transition: background-color 0.3s ease;">
                Guardar Cliente
                <i class="bi bi-check-circle ms-2"></i>
            </button>
        </form>
    </div>
</div>

<!-- Validación básica de Bootstrap -->
<script>
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>
@endsection
