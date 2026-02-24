<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_user_can_login(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@bppmpv.com')
                    ->type('password', 'password123')
                    ->press('Login')
                    ->assertPathIs('/dashboard');
        });
    }
}