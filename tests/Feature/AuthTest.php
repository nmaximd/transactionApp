<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * If user isn't logged in - redirect to login
     * else - home page should be available
     */
    public function testHomePage()
    {
        $this->get(RouteServiceProvider::HOME)
            ->assertRedirect(route('login'));

        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get(RouteServiceProvider::HOME)
            ->assertOk();
    }

    /**
     * If user isn't logged in - page should be available
     * else - redirect to home page
     */
    public function testRegisterPage()
    {
        $this->get(route('register'))
            ->assertOk();

        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get(route('register'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * If user isn't logged in - page should be available
     * else - redirect to home page
     *
     * Also test post request with wrong and correct credentials
     */
    public function testLoginPage()
    {
        $this->get(route('login'))
            ->assertOk();

        $user = factory(User::class)->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong_password'
        ])
            ->assertRedirect(route('login'));

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ])
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->get(route('login'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * No matter if user is logged in or not should be redirected to home page
     */
    public function testLogoutPage()
    {
        $this->post(route('logout'))
            ->assertRedirect(RouteServiceProvider::HOME);

        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }
}
