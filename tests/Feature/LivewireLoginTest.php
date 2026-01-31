<?php

namespace Tests\Feature;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_login()
    {
        Livewire::test(Login::class)
            ->set('email', 'superadmin@marriott.edu')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/dashboards/super-admin');

        $this->assertEquals('super_admin', session('role'));

        $this->assertDatabaseHas('users', [
            'email' => 'superadmin@marriott.edu',
        ]);
    }
}
