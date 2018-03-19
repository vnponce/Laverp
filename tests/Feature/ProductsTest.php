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

}
