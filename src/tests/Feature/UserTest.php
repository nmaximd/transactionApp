<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * When user is created, they should have empty (but not null) account
     * with 0.0 balance
     */
    public function testEmptyAccountAutoCreation()
    {
        $user = factory(User::class)->create();

        $this->assertNotNull($user->account);
        $this->assertEquals(0, $user->account->balance);
    }
}
