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

    /** @test */
    public function it_saves_labor_cost_in_cents_using_dots()
    {
        create(Product::class, [ 'price' => '12345.12']);

        $this->assertDatabaseHas('products', [
            'price' => '1234512',
        ]);
    }

    /** @test */
    public function it_returns_labor_cost_in_format_number()
    {
        $product = create(Product::class, [
            'price' => 12345.00
        ]);

        $this->assertEquals('12,345.00', $product->format_price);
    }
}
