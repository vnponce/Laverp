<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function assertValidationErrors(TestResponse $response, $fields)
    {
        $fields = (array) $fields;

        $response->assertStatus(422);

        $messageBag = $response->exception->validator->getMessageBag();

        foreach ($fields as $field) {
            $this->assertArrayHasKey($field, $messageBag->getMessages());
        }
    }


    /**
     * @param $store
     * @param $product
     * @param int $quantity
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    function addProductToStore($store, $product, $quantity = 1): \Illuminate\Foundation\Testing\TestResponse
    {
        $response = $this->actingAs(createAdmin())
            ->withoutExceptionHandling()->post("stores/{$store->id}/products", [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        return $response;
    }

    /**
     * @param $store
     * @param $product
     * @param int $quantity
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    function reduceStock($store, $product, $quantity = 1): \Illuminate\Foundation\Testing\TestResponse
    {
        $response = $this->actingAs(createAdmin())
            ->withoutExceptionHandling()->post("stores/{$store->id}/products/{$product->id}/reduce", [
                'quantity' => $quantity,
            ]);
        return $response;
    }

    /**
     * @param $store
     * @param $product
     * @param int $quantity
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    function addStock($store, $product, $quantity = 1): \Illuminate\Foundation\Testing\TestResponse
    {
        $response = $this->actingAs(createAdmin())
            ->withoutExceptionHandling()->post("stores/{$store->id}/products/{$product->id}/add", [
                'quantity' => $quantity,
            ]);
        return $response;
    }

    protected function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'titulo',
            'description' => 'Este es un gran producto.',
            'code' => '12345678',
            'sku' => '12345678',
            'volume' => '0',
            'weight' => '0',
            'price' => '100',
            'cost' => '90',
            'condition' => 'new',  // Terminado, matería prima, o ambas
            'days_to_deliver' => '2',
//            'category_id' => '1',  // habrá categorias
            'unit_of_measure' => 'piece',  // pieza, metros, cosas de esas
            'available_quantity' => 10
        ], $overrides);
    }
}
