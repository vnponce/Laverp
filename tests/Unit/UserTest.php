<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /** @test */
    function it_can_return_is_admin_role()
    {
        $admin = createAdmin();
        $this->assertTrue($admin->isAdmin());
    }
}
