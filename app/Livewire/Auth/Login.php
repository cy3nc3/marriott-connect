<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $credentials = [
            'superadmin@marriott.edu' => ['role' => 'super_admin', 'redirect' => '/super-admin/dashboard'],
            'admin@marriott.edu' => ['role' => 'admin', 'redirect' => '/admin/dashboard'],
            'registrar@marriott.edu' => ['role' => 'registrar', 'redirect' => '/registrar/dashboard'],
            'finance@marriott.edu' => ['role' => 'finance', 'redirect' => '/finance/dashboard'],
            'teacher@marriott.edu' => ['role' => 'teacher', 'redirect' => '/teacher/dashboard'],
            'student@marriott.edu' => ['role' => 'student', 'redirect' => '/student/dashboard'],
            'parent@marriott.edu' => ['role' => 'parent', 'redirect' => '/parent/dashboard'],
        ];

        if (array_key_exists($this->email, $credentials)) {
            $roleData = $credentials[$this->email];

            // Create or update the user
            $user = User::firstOrCreate(
                ['email' => $this->email],
                [
                    'name' => ucfirst($roleData['role']) . ' User',
                    'password' => Hash::make('password'),
                ]
            );

            // Log in the user
            Auth::login($user);

            // Store role in session
            session(['role' => $roleData['role']]);

            // Redirect
            return redirect($roleData['redirect']);
        }

        // Fallback or Error
        $this->addError('email', 'Invalid credentials.');
    }

    #[Layout('layouts.standalone')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
