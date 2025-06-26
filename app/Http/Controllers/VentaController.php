<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\InventoryLog;
use Spatie\FlareClient\Http\Client;


class VentaController extends Controller
{
    public function formulario($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.vender', compact('producto'));
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array',
            'cantidades' => 'required|array',
        ]);
    
        $total = 0;
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'total' => 0 // temporal, luego actualizamos
        ]);
    
        foreach ($request->productos as $index => $producto_id) {
            $producto = Producto::findOrFail($producto_id);
            $cantidad = (int)$request->cantidades[$index];
    
            if ($producto->stock < $cantidad) {
                return back()->withErrors("Stock insuficiente para {$producto->name}");
            }
    
            $subtotal = $producto->price * $cantidad;
            $total += $subtotal;
    
            // Guardar detalle
            DetalleVenta::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->price,
                'subtotal' => $subtotal,
            ]);
    
            // Actualizar stock
            $producto->stock -= $cantidad;
            $producto->save();
    
            // Log de salida
            InventoryLog::create([
                'product_id' => $producto->id,
                'user_id' => auth()->id(),
                'type' => 'salida',
                'quantity' => $cantidad,
                'description' => 'Venta de producto',
            ]);
        }
    
        $venta->update(['total' => $total]);
    
        return redirect()->route('ventas.crear')->with('success', "Venta registrada correctamente. Total: S/. {$total}");
    }

    public function crear()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('ventas.crear', compact('clientes', 'productos'));
    }
}