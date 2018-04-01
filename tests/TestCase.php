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

}
