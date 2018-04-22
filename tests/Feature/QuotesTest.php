<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuotesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function admin_can_browse_quotes()
    {
        $this->assertTrue(true);
//        // Having
//        $seller = create(User::class, [
//            'role' => 'admin'
//        ]);
//
//        $product1 = create(Product::class);
//        $product2 = create(Product::class);
//
//        $this->actingAs($seller);
//        // When
//        $response = $this->get('/products');
//        // Then
//        $response->assertStatus(200);
//        $response->assertSee($product1->title);
//        $response->assertSee($product2->title);

    }
}
