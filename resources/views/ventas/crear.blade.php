@extends('layouts.app')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .card-custom {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }
    h2.title-main {
        color: #4B0082;
        font-weight: 900;
        letter-spacing: 2px;
        text-shadow: 1px 1px 3px #fff;
    }
    label {
        font-weight: 600;
        color: #4B0082;
    }
    .btn-primary {
        background: linear-gradient(45deg, #6a11cb, #2575fc);
        border: none;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(101, 52, 255, 0.4);
    }
    .btn-primary:hover {
        background: linear-gradient(45deg, #2575fc, #6a11cb);
        box-shadow: 0 6px 20px rgba(101, 52, 255, 0.7);
    }
    .form-select, .form-control {
        border-radius: 8px;
        border: 2px solid #764ba2;
        transition: border-color 0.3s ease;
    }
    .form-select:focus, .form-control:focus {
        border-color: #6a11cb;
        box-shadow: 0 0 8px #6a11cb;
        outline: none;
    }
    .producto-item {
        background: #f7f5ff;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 4px 15px rgba(118, 75, 162, 0.2);
        position: relative;
        transition: box-shadow 0.3s ease;
    }
    .producto-item:hover {
        box-shadow: 0 6px 25px rgba(118, 75, 162, 0.4);
    }
    .btn-remove-producto {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 22px;
        background: transparent;
        color: #ff4d6d;
        border: none;
        cursor: pointer;
        transition: color 0.3s ease;
    }
    .btn-remove-producto:hover {
        color: #ff1a3c;
    }
    #btn-add-producto {
        font-weight: 700;
        padding: 10px 25px;
        background: #ff7e5f;
        border: none;
        border-radius: 50px;
        box-shadow: 0 5px 15px rgba(255, 126, 95, 0.6);
        transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    #btn-add-producto:hover {
        background: #feb47b;
        box-shadow: 0 7px 20px rgba(254, 180, 123, 0.8);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="card card-custom p-4">
        <h2 class="title-main mb-4 text-center">🛒 Registrar Nueva Venta</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ventas.procesar') }}" method="POST" class="mt-3">
            @csrf

            <div class="mb-4">
                <label for="cliente_id" class="form-label">👤 Cliente</label>
                <select class="form-select @error('cliente_id') is-invalid @enderror" id="cliente_id" name="cliente_id" required>
                    <option value="" selected disabled>Selecciona un cliente...</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }} ({{ $cliente->telefono ?? 'Sin teléfono' }})
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4" style="border-color: #764ba2; opacity: 0.4;">

            <h4 class="mb-3 text-purple fw-bold" style="color: #764ba2;">🛍️ Productos</h4>
            
            <div id="productos-container">
                <div class="producto-item">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-7">
                            <label class="form-label">Producto</label>
                            <select name="productos[]" class="form-select" required>
                                <option value="" disabled selected>Selecciona un producto...</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">
                                        {{ $producto->name }} - Stock: {{ $producto->stock }} - ${{ number_format($producto->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cantidad</label>
                            <input type="number" name="cantidades[]" class="form-control" min="1" value="1" required>
                        </div>
                        <!-- Botón eliminar solo en los productos adicionales -->
                        <button type="button" class="btn-remove-producto" title="Eliminar producto" style="display: none;">&times;</button>
                    </div>
                </div>
            </div>

            <button type="button" id="btn-add-producto" class="mb-4 w-100">
                + Agregar otro producto
            </button>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                    💾 Guardar Venta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btnAdd = document.getElementById('btn-add-producto');
        const container = document.getElementById('productos-container');

        btnAdd.addEventListener('click', () => {
            const productoItem = container.querySelector('.producto-item');
            const nuevoProducto = productoItem.cloneNode(true);

            // Reset inputs
            nuevoProducto.querySelector('select').value = "";
            nuevoProducto.querySelector('input').value = 1;

            // Mostrar el botón eliminar en el nuevo producto
            const btnRemove = nuevoProducto.querySelector('.btn-remove-producto');
            btnRemove.style.display = 'block';

            // Añadir evento para eliminar este producto
            btnRemove.addEventListener('click', (e) => {
                e.target.closest('.producto-item').remove();
                checkRemoveButtons();
            });

            container.appendChild(nuevoProducto);

            checkRemoveButtons();
        });

        // Función para mostrar u ocultar botón eliminar según cantidad de productos
        function checkRemoveButtons() {
            const productos = container.querySelectorAll('.producto-item');
            if (productos.length === 1) {
                // Ocultar el botón eliminar si solo queda 1 producto
                productos[0].querySelector('.btn-remove-producto').style.display = 'none';
            } else {
                productos.forEach(producto => {
                    producto.querySelector('.btn-remove-producto').style.display = 'block';
                });
            }
        }

        // Inicializa estado correcto al cargar la página
        checkRemoveButtons();

        // Añadir evento eliminar para el botón del primer producto si existe
        const firstRemoveBtn = container.querySelector('.producto-item .btn-remove-producto');
        if (firstRemoveBtn) {
            firstRemoveBtn.addEventListener('click', (e) => {
                e.target.closest('.producto-item').remove();
                checkRemoveButtons();
            });
        }
    });
</script>
@endsection
