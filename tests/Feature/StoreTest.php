<?php

namespace Tests\Feature;

use App\Store;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_show_all_stores()
    {
        // Having
        $seller = create(User::class, [
            'role' => 'seller'
        ]);

        $store1 = create(Store::class);
        $store2 = create(Store::class);

        $this->actingAs($seller);
        // When
        $response = $this->actingAs($seller)->get('/stores');
        // Then
        $response->assertStatus(200);
        $response->assertSee($store1->name);
        $response->assertSee($store2->name);
    }

    /** @test */
    function it_can_show_a_specific_stores()
    {
        $this->actingAs(createAdmin());
        $stores = create(Store::class);

        $response = $this->get('/stores/'.$stores->id);
        $response->assertSee($stores->name);
    }

    /** @test */
    function admin_can_create_store()
    {
        // Having
        $this->actingAs(createAdmin());
        // When
//        $response = $this->withoutExceptionHandling()->get('/stores/create');
        $response = $this->get('/stores/create');
        // Then
        $response->assertStatus(200);
        $response->assertSee('Create Store');

        $response = $this->post('/stores', [
            'name' => 'Confeti',
            'address' => 'Plaza mocambo select.',
        ]);
        $this->assertDatabaseHas('stores', [
            'name' => 'Confeti',
            'address' => 'Plaza mocambo select.',
        ]);
    }

    /** @test */
    function it_validate_name_and_address_are_required()
    {
        // Having
        $this->actingAs(createAdmin());
        // When
        $response = $this->withExceptionHandling()->json('POST', "stores");
        // Then
        $this->assertValidationErrors($response, ['name', 'address']);
    }

    /** @test */
    function user_can_update_store()
    {
        $admin = createAdmin();
        $store = create(Store::class, [
            'name' => 'Confeti',
            'address' => 'Plaza Mocambo'
        ]);

        $response = $this->actingAs($admin)
            ->withoutExceptionHandling()->get('/stores/' .  $store->id . '/edit');
        $response->assertStatus(200)
            ->assertSee('Confeti');

        $this->put('/stores/' . $store->id, [
            'name' => 'New Confeti',
            'address' => 'New Mall'
        ]);

        $this->assertDatabaseHas('stores', [
            'name' => 'New Confeti',
            'address' => 'New Mall'
        ]);
    }

    /** @test */
    function it_validate_name_and_address_are_required_when_store_is_updated()
    {
        // Having
        $this->actingAs(createAdmin());
        $store = create(Store::class);
        // When
        $response = $this->withExceptionHandling()->json('PATCH', "stores/{$store->id}");
        // Then
        $this->assertValidationErrors($response, ['name', 'address']);
    }

    /** @test */
    function it_can_be_deleted()
    {
        $store = create(Store::class, [
            'name' => 'deleted store'
        ]);

        $this->actingAs(createAdmin())
            ->delete('/stores/' . $store->id);

        $this->assertDatabaseMissing('stores', [
            'name' => 'deleted store'
        ]);
    }
}
