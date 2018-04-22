<?php

namespace Tests\Feature;

use App\Product;
use App\User;
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

    /** @test */
    function guess_can_only_see_products_list_route()
    {
        $product1 = create(Product::class);
        $product2 = make(Product::class);

        $response = $this->get('/products');
        $response->assertStatus(200);

        $response = $this->post('/products', $product2->toArray());
        $response->assertStatus(302)
            ->assertRedirect('/login');

        $response = $this->get('/products/create');
        $response->assertStatus(302)
            ->assertRedirect('/login');


        $response = $this->put('/products/'.$product1->id);
        $response->assertStatus(302)
            ->assertRedirect('/login');


        $response = $this->delete('/products/'.$product1->id);
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    function seller_users_can_only_see_products_list_route()
    {
        $seller = create(User::class, [
            'role' => 'seller'
        ]);
        $product1 = create(Product::class);
        $product2 = make(Product::class);

        $response = $this->actingAs($seller)
            ->get('/products');
        $response->assertStatus(200);

        $response = $this->actingAs($seller)
            ->post('/products', $product2->toArray());
        $response->assertStatus(302)
            ->assertRedirect('/products');
        $this->assertEquals(1, Product::all()->count());

        $response = $this->actingAs($seller)
            ->get('/products/create');
        $response->assertStatus(302)
            ->assertRedirect('/products');

        $response = $this->actingAs($seller)
            ->put('/products/'.$product1->id, ['sku' => 1234]);
        $response->assertStatus(302)
            ->assertRedirect('/products');
        $this->assertDatabaseMissing('products', ['sku' => 1234]);

        $response = $this->actingAs($seller)
            ->delete('/products/'.$product1->id);
        $response->assertStatus(302);
        $this->assertEquals(1, Product::all()->count());

    }

    /** @test */
    function admin_can_see_all_products_route()
    {
        $admin = createAdmin();
        $product1 = create(Product::class);
        $product2 = make(Product::class);

        $response = $this->actingAs($admin)
            ->get('/products');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)
            ->post('/products', $product2->toArray());
        $response->assertStatus(302)
            ->assertRedirect('/products');
        $this->assertEquals(2, Product::all()->count());

        $response = $this->actingAs($admin)
            ->get('/products/create');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)
            ->put('/products/'.$product1->id, ['sku' => 1234]);
        $response->assertStatus(302)
            ->assertRedirect('/products');
        $this->assertDatabaseHas('products', ['sku' => 1234]);

        $response = $this->actingAs($admin)
            ->delete('/products/'.$product1->id);
        $response->assertStatus(302)
            ->assertRedirect('/products');
        $this->assertEquals(1, Product::all()->count());
    }
}
