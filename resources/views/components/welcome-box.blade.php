@guest
<div class="col-12 d-flex align-items-center justify-content-center" style="min-height: 85vh; background: linear-gradient(135deg, #e0f7fa, #fce4ec);">
    <div class="card shadow-lg border-0 p-5 bg-white rounded-5 animate__animated animate__fadeIn" style="max-width: 600px; width: 100%;">
        <div class="card-body text-center">
            <h1 class="display-5 fw-bold mb-4 text-gradient">✨ ¡Bienvenido a <span class="text-primary">DECOR CENTER</span>! ✨</h1>
            <p class="fs-5 text-muted mb-4">Gestiona tu inventario de manera rápida, moderna y eficiente.</p>

            <div class="d-grid gap-3">
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg rounded-pill shadow">
                    🔐 Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg rounded-pill shadow">
                    📝 Crear cuenta
                </a>
            </div>
        </div>
    </div>
</div>
@endguest
