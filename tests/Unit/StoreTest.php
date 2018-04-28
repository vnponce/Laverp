<?php

namespace Tests\Unit;

use App\Product;
use App\Store;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    /** @test */
    function it_has_many_products()
    {
        $store = create(Store::class, [
            'name' => 'Confeti'
        ]);
        $product = create(Product::class,[
            'title' => 'papas'
        ]);
        $response = $this->actingAs(createAdmin())
            ->withoutExceptionHandling()->post("stores/{$store->id}/products", [
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);

        $this->assertEquals(1, $store->products->count());
    }

    /** @test */
    function it_returns_quantities_on_each_products()
    {
        $store = create(Store::class, [
            'name' => 'Confeti'
        ]);
        $product = create(Product::class,[
            'title' => 'papas'
        ]);

        $this->actingAs(createAdmin())
            ->withoutExceptionHandling()->post("stores/{$store->id}/products", [
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);

        $store->products->map(function($product){
            $this->assertEquals(1, $product->pivot->quantity);
        });
    }

}
