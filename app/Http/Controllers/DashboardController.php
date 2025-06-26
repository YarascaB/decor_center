<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener todos los productos para mostrarlos en el Dashboard
        $productos = Producto::all();

        // Pasar los productos a la vista del dashboard
        return view('dashboard', compact('productos'));
    }
}
