<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function guess_can_see_products_and_search()
    {
        $product1 = create(Product::class);
        $product2 = create(Product::class);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee((string)$product1->sku);
        $response->assertSee((string)$product2->sku);
    }

    /** @test */
    function guess_cannot_see_edit_or_delete_buttons()
    {
        $product1 = create(Product::class);
        $product2 = create(Product::class);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertDontSee('<i class="fa fa-edit"></i>');
        $response->assertDontSee('<i class="fa fa-trash"></i>');
    }
}
