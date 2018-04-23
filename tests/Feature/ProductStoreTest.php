<?php

namespace Tests\Feature;

use App\Product;
use App\Store;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_can_store_products_on_a_specific_store()
    {
        $store = create(Store::class, [
            'name' => 'Confeti'
        ]);
        $product = create(Product::class,[
            'title' => 'papas'
        ]);

        $response = $this->addProductToStore($store, $product);

        $response->assertStatus(200);
        $this->assertDatabaseHas('product_store', [
            'product_id' => $product->id,
            'store_id' => $store->id,
            'quantity' => 1,
            'price' => $product->price,
        ]);
    }

    /** @test */
    function it_can_show_all_products_on_a_specific_store()
    {
        $store = create(Store::class, [
            'name' => 'Confeti'
        ]);
        $product1 = create(Product::class,[
            'title' => 'papas'
        ]);
        $product2 = create(Product::class,[
            'title' => 'sabritas'
        ]);

        $this->addProductToStore($store, $product1);
        $this->addProductToStore($store, $product2);

        $response = $this->get("stores/{$store->id}/products");

        $response->assertStatus(200)
            ->assertSee('papas')
            ->assertSee('sabritas');
    }

    /** @test */
    function it_validate_if_there_are_available_products_to_store_on_specific_shop()
    {
        $store = create(Store::class, [
            'name' => 'Confeti'
        ]);
        $product = create(Product::class,[
            'title' => 'papas',
            'available_quantity' => 1
        ]);

        $response = $this->actingAs(createAdmin())
            ->post("stores/{$store->id}/products", [
                'product_id' => $product->id,
                'quantity' => 2,
                'price' => $product->price
            ]);
        $errors = session('errors');
        $this->assertTrue($errors->has('quantity'));
    }
}
