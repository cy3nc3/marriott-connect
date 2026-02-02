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

    public function test_finance_user_can_login()
    {
        Livewire::test(Login::class)
            ->set('email', 'finance@marriott.edu')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/dashboards/finance');

        $this->assertEquals('finance', session('role'));
    }

    public function test_teacher_user_can_login()
    {
        Livewire::test(Login::class)
            ->set('email', 'teacher@marriott.edu')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/dashboards/teacher');

        $this->assertEquals('teacher', session('role'));
    }

    public function test_student_user_can_login()
    {
        Livewire::test(Login::class)
            ->set('email', 'student@marriott.edu')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/dashboards/student');

        $this->assertEquals('student', session('role'));
    }

    public function test_parent_user_can_login()
    {
        Livewire::test(Login::class)
            ->set('email', 'parent@marriott.edu')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect('/dashboards/parent');

        $this->assertEquals('parent', session('role'));
    }
}
