<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- FontAwesome para iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Fuentes y colores */
        body {
            background: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #34495e;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #1d3557 0%, #457b9d 100%);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            padding: 0.75rem 1.5rem;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #f1faee !important;
            letter-spacing: 1px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        .nav-link {
            color: #a8dadc !important;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #ffb703 !important;
            text-decoration: underline;
        }
        #toggleSidebar {
            background: transparent;
            border: none;
            color: #f1faee;
            font-size: 1.8rem;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 1100;
        }
        #toggleSidebar:hover {
            color: #ffb703;
        }

        /* Sidebar */
        .sidebar {
            background: #264653;
            color: #e9ecef;
            height: 100vh;
            width: 260px;
            padding: 2rem 1.5rem;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0,0,0,0.2);
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1050;
        }
        body.sidebar-visible .sidebar {
            transform: translateX(0);
        }

        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #f1faee;
            text-shadow: 0 1px 4px rgba(0,0,0,0.5);
        }
        .sidebar a {
            display: block;
            color: #a8dadc;
            padding: 10px 15px;
            margin-bottom: 0.75rem;
            border-radius: 10px;
            font-weight: 500;
            transition: background-color 0.3s ease, color 0.3s ease;
            box-shadow: inset 0 0 0 0 #ffb703;
            text-decoration: none;
        }
        .sidebar a:hover,
        .sidebar a:focus {
            background-color: #ffb703;
            color: #264653;
            box-shadow: inset 0 0 10px 5px #ffb703;
            text-decoration: none;
        }
        .sidebar .btn {
            width: 100%;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(255, 183, 3, 0.5);
            transition: box-shadow 0.3s ease;
        }
        .sidebar .btn:hover {
            box-shadow: 0 0 15px 4px #ffb703;
        }

        /* Contenido */
        .content {
            margin-left: 0;
            padding: 2rem 2rem 4rem;
            flex-grow: 1;
            transition: margin-left 0.3s ease;
        }
        body.sidebar-visible .content {
            margin-left: 260px;
        }

        /* Footer */
        .footer {
            background: linear-gradient(90deg, #1d3557 0%, #457b9d 100%);
            color: #f1faee;
            text-align: center;
            padding: 12px 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-weight: 500;
            box-shadow: 0 -3px 8px rgba(0,0,0,0.15);
            z-index: 1000;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        /* Ajustes responsivos */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                width: 220px;
                height: 100vh;
                border-radius: 0 15px 15px 0;
            }
            body.sidebar-visible .content {
                margin-left: 0;
            }
            .navbar-brand {
                position: static !important;
                transform: none !important;
            }
            .content {
                padding: 1rem 1rem 5rem;
            }
        }

        /* Mejorar cards y filas */
        .row {
            margin-top: 1.5rem;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container position-relative">
            <button id="toggleSidebar" aria-label="Toggle sidebar">☰</button>
            <a class="navbar-brand position-absolute start-50 translate-middle-x" href="{{ route('dashboard') }}">
                DECOR CENTER
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="navbar-nav">
                    <a class="nav-link" href="{{ route('dashboard') }}">Inicio</a>
                    @if(Auth::check())
                        <a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger ms-2 px-3 rounded-pill shadow-sm">
                                <i class="fas fa-sign-out-alt me-1"></i> Cerrar sesión
                            </button>
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                        <a class="nav-link" href="{{ route('register') }}">Crear cuenta</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar y contenido -->
    <div class="container-fluid mt-4">
        <div class="row">
            @include('components.welcome-box')

            @auth
            <div class="sidebar" id="sidebar">
                <h4>Bienvenido, {{ Auth::user()->name }}</h4>

                <a href="{{ route('dashboard') }}">Panel de Control</a>

                @hasanyrole('admin|editor|vendedor')
                    <a href="{{ route('productos.index') }}">Ver Productos</a>
                @endhasanyrole

                @hasanyrole('admin|vendedor')
                    <a href="{{ route('ventas.crear') }}" class="btn btn-primary mt-3">Nueva Venta</a>
                @endhasanyrole

                @hasanyrole('admin|editor')
                    <a href="{{ route('productos.create') }}">Agregar Producto</a>
                    <a href="{{ route('inventory.logs') }}">Historial de Inventario</a>
                @endhasanyrole

                @hasanyrole('admin|vendedor')
                <a href="{{ route('clientes.crear') }}" class="btn btn-secondary mt-3">Crear Cliente</a>
                @endhasanyrole

                @role('admin')
                    <a href="{{ route('admin.users.index') }}">Gestionar Usuarios</a>
                @endrole

                <div class="mt-4">
                    @role('admin')
                    <a class="d-block fw-semibold text-warning" data-bs-toggle="collapse" href="#submenuReportes" role="button" aria-expanded="false" aria-controls="submenuReportes" style="cursor:pointer;">
                        📊 Reportes ▾
                    </a>
                    @endrole
                    <div class="collapse" id="submenuReportes">
                        <a href="{{ route('reportes.ventas_por_mes') }}" class="ms-3 d-block mt-2">📈 Ventas por mes</a>
                        <a href="{{ route('reportes.productos_mas_vendidos') }}" class="ms-3 d-block mt-2">🔥 Productos más vendidos</a>
                        <a href="{{ route('reportes.variacion_stock') }}" class="ms-3 d-block mt-2">⚠️ Variación de Stock</a>
                        <a href="{{ route('reportes.usuarios_registrados') }}" class="ms-3 d-block mt-2">👥 Usuarios Registrados</a>
                    </div>
                </div>
            </div>

            <div class="content">
                @yield('content')
            </div>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 DECOR CENTER. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', () => {
            document.body.classList.toggle('sidebar-visible');
        });
    </script>
</body>
</html>
