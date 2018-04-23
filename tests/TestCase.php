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
}
