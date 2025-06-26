<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Producto;

class ProductoTest extends TestCase
{

    /** @test */
    public function la_ruta_productos_index_funciona_correctamente()
    {
        $response = $this->get('/productos');
        $response->assertStatus(200);
    }

    /** @test */
    public function la_ruta_create_producto_devuelve_vista()
    {
        $response = $this->get('/productos/create');
        $response->assertStatus(200);
        $response->assertSee('Crear producto'); // Si tienes un texto como 'Crear Producto' en la vista
    }

    /** @test */
    public function se_puede_ver_un_producto_especifico()
    {
        // Este test solo verifica la existencia de la ruta, sin necesidad de producto real
        $response = $this->get('/productos/1');  // Usa un ID de producto simulado
        $response->assertStatus(200);
    }

    /** @test */
    public function se_puede_ver_producto_con_categoria_opcional()
    {
        // Verifica la ruta con una categoría opcional
        $response = $this->get('/productos/1/Mobiliario');
        $response->assertStatus(200);
        $response->assertSee('Mobiliario');  // Si en la vista aparece la categoría
    }

    public function test_index_muestra_lista_de_productos()
    {
        $response = $this->get('/productos');
        $response->assertStatus(200);
        $response->assertSee('Lista de productos'); // o el título en tu vista
    }

    public function test_create_muestra_formulario_de_creacion()
    {
        $response = $this->get('/productos/create');
        $response->assertStatus(200);
        $response->assertSee('Crear producto');
    }

    public function test_usuario_puede_crear_un_producto()
    {
        $response = $this->post('/productos', [
            'name' => 'Mesa de vidrio',
            'category' => 'Muebles',
            'price' => 450.00,
            'description' => 'Mesa de comedor con vidrio templado'
        ]);

        $this->assertDatabaseHas('productos', [
            'name' => 'Mesa de vidrio'
        ]);
    }

    public function test_usuario_puede_eliminar_producto()
    {
        $producto = Producto::factory()->create();

        $response = $this->delete("/productos/{$producto->id}");

        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    public function test_muestra_404_si_producto_no_existe()
    {
        $response = $this->get('/productos/9999'); // ID que no existe

        $response->assertStatus(404); // Solo si manejas este caso con abort(404)
    }

    public function test_usuario_puede_actualizar_un_producto()
    {
        $producto = Producto::factory()->create();

        $response = $this->put("/productos/{$producto->id}", [
            'name' => 'Producto actualizado',
            'category' => $producto->category,
            'price' => $producto->price,
            'description' => $producto->description
        ]);

        $this->assertDatabaseHas('productos', ['name' => 'Producto actualizado']);
    }

    public function test_muestra_formulario_de_edicion_de_producto()
    {
        $producto = Producto::factory()->create();

        $response = $this->get("/productos/{$producto->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($producto->name);
    }

    public function test_no_se_puede_crear_producto_con_datos_vacios()
    {
        $response = $this->post('/productos', []);

        $response->assertSessionHasErrors(['name', 'category', 'price', 'description']);
    }

    /** @test */
    public function no_se_puede_crear_producto_con_precio_invalido()
    {
        $response = $this->post('/productos', [
            'name' => 'Producto con precio negativo',
            'category' => 'Muebles',
            'price' => -100.00,
            'description' => 'Descripción del producto'
        ]);

        $response->assertSessionHasErrors(['price']);
    }

    public function test_formulario_de_creacion_tiene_boton_de_crear()
    {
        $response = $this->get(route('productos.create'));

        $response->assertStatus(200);
        $response->assertSee('<button', false); // Verifica que hay al menos un botón
        $response->assertSee('Enviar Producto'); // Verifica que el texto del botón esté presente
    }

    public function test_formulario_de_edicion_tiene_boton_actualizar()
    {
        $producto = Producto::factory()->create();

        $response = $this->get(route('productos.edit', $producto->id));

        $response->assertStatus(200);
        $response->assertSee('<button', false); // Asegura que hay un botón
        $response->assertSee('Actualizar Producto');     // Verifica el texto del botón
    }
}
