<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function a_user_can_browse_products()
    {
        // Having
        $seller = create(User::class, [
            'role' => 'seller'
        ]);

        $product1 = create(Product::class);
        $product2 = create(Product::class);

        $this->actingAs($seller);
        // When
        $response = $this->get('/products');
        // Then
        $response->assertStatus(200);
        $response->assertSee($product1->title);
        $response->assertSee($product2->title);

    }

    /** @test */
    function it_can_show_a_specific_product()
    {
        $this->actingAs(createAdmin());
        $product = create(Product::class);

        $response = $this->get('/products/'.$product->id);
        $response->assertSee($product->title);
    }

    /** @test */
    function user_can_create_product()
    {
        // Having
        $this->actingAs(createAdmin());
        // When
//        $response = $this->withoutExceptionHandling()->get('/products/create');
        $response = $this->get('/products/create');
        // Then
        $response->assertStatus(200);
        $response->assertSee('Crear producto');

        $this->post('/products/create', [
            'title' => 'titulo',
            'description' => 'Este es un gran producto.',
            'photo' => '/imagen/algo',
            'code' => '12345678',
            'sku' => '12345678',
            'volume' => '0',
            'weight' => '0',
            'price' => '100',
            'cost' => '90',
            'condition' => 'new',  // Terminado, matería prima, o ambas
            'days_to_deliver' => '2',
//            'category_id' => '1',  // habrá categorias
            'unit_of_measure' => 'new',  // pieza, metros, cosas de esas
        ]);

        $this->assertDatabaseHas('products', [
            'title' => 'titulo',
            'description' => 'Este es un gran producto.',
            'photo' => '/imagen/algo',
            'code' => '12345678',
            'sku' => '12345678',
            'volume' => '0',
            'weight' => '0',
            'price' => '100',
            'cost' => '90',
            'condition' => 'new',  // Terminado, matería prima, o ambas
            'days_to_deliver' => '2',
//            'category_id' => '1',  // habrá categorias
            'unit_of_measure' => 'piece',  // pieza, metros, cosas de esas
        ]);
    }
}
