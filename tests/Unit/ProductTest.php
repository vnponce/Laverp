<?php

namespace Tests\Unit;

use App\Product;
use App\Store;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_belongs_to_many_stores()
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

        $this->assertEquals(1, $product->stores->count());
    }

    /** @test */
    function it_returns_quantities_on_each_store()
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

        $product->stores->map(function($store){
            $this->assertEquals(1, $store->pivot->quantity);
        });
    }
}
