<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\InventoryLogController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\UserRoleController;


// Ruta principal de la aplicación
Route::get('/', function () {
    return view('home');
})->name('home');


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Rutas de autenticación
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Rutas comunes para cualquier usuario autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/historial-inventario', [InventoryLogController::class, 'index'])->name('inventory.logs');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Productos - listado para admin, editor, vendedor
Route::get('/productos', [ProductoController::class, 'index'])
    ->middleware(['auth', 'role:admin|editor|vendedor'])
    ->name('productos.index');

// CRUD productos - solo admin y editor (excepto index)
Route::group(['middleware' => ['auth', 'role:admin|editor']], function () {
    Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

// Venta productos - admin y vendedor
Route::group(['middleware' => ['auth', 'role:admin|vendedor']], function () {
    Route::get('/productos/{id}/vender', [VentaController::class, 'formulario'])->name('productos.vender.form');
    Route::post('/productos/{id}/vender', [VentaController::class, 'procesar'])->name('productos.vender.procesar');
});

// Reportes - solo admin
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/reportes/ventas-por-mes', [ReporteController::class, 'ventasPorMes'])->name('reportes.ventas_por_mes');
    Route::get('/reportes/productos-mas-vendidos', [ReporteController::class, 'productosMasVendidos'])->name('reportes.productos_mas_vendidos');
    Route::get('/reportes/variacion-stock', [ReporteController::class, 'variacionStock'])->name('reportes.variacion_stock');
    Route::get('/reportes/usuarios-registrados', [ReporteController::class, 'usuariosRegistrados'])->name('reportes.usuarios_registrados');
});


Route::get('/ventas/crear', [VentaController::class, 'crear'])->name('ventas.crear');
Route::post('/ventas', [VentaController::class, 'procesar'])->name('ventas.procesar');

Route::get('/clientes/crear', [ClienteController::class, 'crear'])->name('clientes.crear');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');


Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [UserRoleController::class, 'index'])->name('users.index');
    Route::get('users/{user}/edit-role', [UserRoleController::class, 'editRole'])->name('users.editRole');
    Route::put('users/{user}/update-role', [UserRoleController::class, 'updateRole'])->name('users.updateRole');
    Route::post('users/{user}/assign-role', [UserRoleController::class, 'assignRole'])->name('users.assignRole');
});

Route::get('/api/productos-mas-vendidos', [ReporteController::class, 'apiProductosMasVendidos'])->name('api.productos-mas-vendidos');


Route::get('/verificar-rol', function () {
    dd(Auth::user()->hasRole('admin'));
});

// Cargar las rutas de autenticación generadas por Breeze u otra configuración
require __DIR__.'/auth.php';

