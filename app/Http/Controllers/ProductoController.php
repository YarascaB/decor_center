<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Solo usuarios autenticados pueden acceder
    }

    // Mostrar formulario para crear producto
    public function create()
    {
        return view('productos.create');
    }

    // Almacenar producto en base de datos
    public function store(Request $request)
    {
        // Convertir nombre a minúsculas para evitar duplicados por mayúsculas/minúsculas
        $nameLower = strtolower($request->name);
        $request->merge(['name' => $nameLower]);

        // Validación con regla unique para evitar duplicados en columna 'name'
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[\pL\s\-]+$/u', 'unique:productos,name'],
            'category' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'name.regex' => 'El nombre solo debe contener letras y espacios.',
            'name.unique' => 'Ya existe un producto con ese nombre.',
            'category.regex' => 'La categoría solo debe contener letras y espacios.',
            'price.min' => 'El precio debe ser mayor que cero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'description.min' => 'La descripción debe tener al menos 10 caracteres.',
        ]);

        $producto = Producto::create($validated);

        // Registrar entrada inicial de stock si el stock es mayor a 0
        if ($producto->stock > 0) {
            \App\Models\InventoryLog::create([
                'product_id' => $producto->id,
                'user_id' => auth()->id(),
                'type' => 'entrada',
                'quantity' => $producto->stock,
                'description' => 'Registro inicial de stock al crear el producto.',
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    // Listar todos los productos
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function dashboard()
    {
        $productos = Producto::all();
        return view('dashboard', compact('productos'));
    }


    // Mostrar formulario para editar producto
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    // Actualiza un producto en la base de datos
    public function update(Request $request, $id)
    {
        // Valida los datos enviados por el formulario
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'category' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[\pL\s\-]+$/u'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'name.regex' => 'El nombre solo debe contener letras y espacios.',
            'category.regex' => 'La categoría solo debe contener letras y espacios.',
            'price.min' => 'El precio debe ser mayor que cero.',
            'stock.min' => 'El stock no puede ser negativo.',
            'description.min' => 'La descripción debe tener al menos 10 caracteres.',
        ]);

        // Encuentra el producto por ID
        $producto = Producto::findOrFail($id);

        // Calcula la diferencia de stock
        $stockAnterior = $producto->stock;
        $nuevoStock = $validated['stock'];
        $diferencia = $nuevoStock - $stockAnterior;

        // Actualiza los datos del producto
        $producto->update($validated);

        if ($diferencia != 0) {
            InventoryLog::create([
                'product_id' => $producto->id,
                'user_id' => auth()->id(),
                'type' => $diferencia > 0 ? 'entrada' : 'salida',
                'quantity' => abs($diferencia),
                'description' => 'Ajuste de stock manual al editar producto.',
            ]);
        }      

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        $cantidadEliminada = $producto->stock;

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
