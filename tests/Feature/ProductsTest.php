<?php

namespace Tests\Feature;

use App\Product;
use App\Store;
use App\User;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $product;

    public function setUp()
    {
        parent::setUp();
        $this->admin = createAdmin();
    }

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
        $product = create(Product::class, $this->validParams());

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

        $response = $this->withoutExceptionHandling()->post('/products', [
            'title' => 'titulo',
            'description' => 'Este es un gran producto.',
            'code' => '12345678',
            'sku' => '12345678',
            'volume' => '0',
            'weight' => '0',
            'price' => '100.00',
            'cost' => '90',
            'condition' => 'new',  // Terminado, matería prima, o ambas
            'days_to_deliver' => '2',
//            'category_id' => '1',  // habrá categorias
            'unit_of_measure' => 'new',  // pieza, metros, cosas de esas
            'available_quantity' => 10
        ]);
        $this->assertDatabaseHas('products', [
            'title' => 'titulo',
            'description' => 'Este es un gran producto.',
//            'photo' => '/imagen/algo',
            'code' => '12345678',
            'sku' => '12345678',
            'volume' => '0',
            'weight' => '0',
            'price' => '10000',
            'cost' => '90',
            'condition' => 'new',  // Terminado, matería prima, o ambas
            'days_to_deliver' => '2',
//            'category_id' => '1',  // habrá categorias
            'unit_of_measure' => 'piece',  // pieza, metros, cosas de esas
            'available_quantity' => 10
        ]);
    }

    /** @test */
    function it_can_validate_required_data_when_product_is_created()
    {
        $response = $this->actingAs($this->admin)
            ->from('/products/create')
            ->post('/products', [
                'title' => '',
                'description' => '',
//            'photo' => '/imagen/algo',
                'code' => '',
                'sku' => '',
                'volume' => '',
                'weight' => '',
                'price' => '',
                'cost' => '',
                'condition' => '',  // Terminado, matería prima, o ambas
                'days_to_deliver' => '',
//            'category_id' => '1',  // habrá categorias
                'unit_of_measure' => '',  // pieza, metros, cosas de esas
                'available_quantity' => ''
            ]);
        $response->assertStatus(302)
            ->assertRedirect('/products/create')
            ->assertSessionHasErrors([
                'title',
                'description',
                'code',
//                'sku',
                'volume',
                'weight',
                'price',
                'cost',
                'condition',  // Terminado, matería prima, o ambas
                'days_to_deliver',
//            'category_id' => 'required',  // habrá categorias
                'unit_of_measure',  // pieza, metros, cosas de esas
            ]);
        $this->assertEquals(0, Product::all()->count());
    }

    /** @test */
    function user_can_update_product()
    {
        $admin = createAdmin();
        $product = create(Product::class, [
            'title' => 'Mi producto'
        ]);

        $response = $this->actingAs($admin)
            ->withoutExceptionHandling()
            ->get('/products/' .  $product->id . '/edit');
        $response->assertStatus(200)
            ->assertSee('Mi producto');

        $this->put('/products/' . $product->id, $this->validParams(['title' => 'Nuevo titulo']));

        $this->assertDatabaseHas('products', [
            'title' => 'Nuevo titulo'
        ]);
    }

    /** @test */
    function it_validate_data_when_product_is_updated()
    {
        $product = create(Product::class, $this->validParams());
        $response = $this->actingAs($this->admin)
            ->from("/products/{$product->id}/edit/")
            ->put("/products/{$product->id}", [
                'title' => '',
                'description' => '',
//            'photo' => '/imagen/algo',
                'code' => '',
                'sku' => '',
                'volume' => '',
                'weight' => '',
                'price' => '',
                'cost' => '',
                'condition' => '',  // Terminado, matería prima, o ambas
                'days_to_deliver' => '',
//            'category_id' => '1',  // habrá categorias
                'unit_of_measure' => '',  // pieza, metros, cosas de esas
                'available_quantity' => ''
            ]);
        $response->assertStatus(302)
            ->assertRedirect("/products/{$product->id}/edit/")
            ->assertSessionHasErrors([
                'title',
                'description',
                'code',
                'sku',
                'volume',
                'weight',
                'price',
                'cost',
                'condition',  // Terminado, matería prima, o ambas
                'days_to_deliver',
//            'category_id' => 'required',  // habrá categorias
                'unit_of_measure',  // pieza, metros, cosas de esas
            ]);
        $this->assertEquals('titulo', Product::first()->title);
    }

    /** @test */
    function it_can_be_deleted()
    {
        $admin = createAdmin();
        $product = create(Product::class, [
            'title' => 'deleted product'
        ]);

        $this->actingAs($admin)
            ->delete('/products/' . $product->id);

        $this->assertDatabaseMissing('products', [
            'title' => 'deleted product'
        ]);
    }

    /** @test */
    function it_return_total_existing_product()
    {
        $admin = createAdmin();
        $product = create(Product::class, [
            'available_quantity' => 9
        ]);
        $store = create(Store::class);
        $this->addProductToStore($store, $product, 4);

        $this->assertEquals(9, $product->total_available);
    }

    /** @test */
    function image_is_uploaded_if_included()
    {
        Storage::fake('local');
        $response = $this->actingAs(createAdmin())
            ->post('/products', $this->validParams([
            'image' => File::image('concert-poster.png'),
        ]));
        $this->assertNotNull(Product::first()->image);
        Storage::disk('public')->assertExists(Product::first()->image);
    }

    /** @test */
    function image_is_uploaded_is_optional()
    {
        $response = $this->actingAs(createAdmin())
            ->post('/products', $this->validParams([
            'image' => null,
        ]));
        tap(Product::first(), function ($product) use ($response) {
            $response->assertRedirect('/products');
            $this->assertNull($product->image);
        });
    }

    /** @test */
    function image_is_uploaded_if_included_when_update_product()
    {
        $product = create(Product::class, $this->validParams());
        Storage::fake('local');
        $response = $this->actingAs(createAdmin())
            ->put('/products/' . $product->id, $this->validParams([
                'image' => File::image('concert-poster.png'),
            ]));
        $this->assertNotNull(Product::first()->image);
        Storage::disk('public')->assertExists(Product::first()->image);
    }

    /** @test */
    function it_can_increment_sku_attribute_by_one()
    {
//        $this->withoutExceptionHandling();
        create(Product::class, [
            'sku' => '0000'
        ]);
        $this->actingAs($this->admin)->post('/products', $this->validParams());
        $this->assertEquals('0001', Product::orderBy('id', 'desc')->first()->sku);

        $this->actingAs($this->admin)->post('/products', $this->validParams());
        $this->assertEquals('0002', Product::orderBy('id', 'desc')->first()->sku);
    }
}
