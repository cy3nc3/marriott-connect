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
            'superadmin@marriott.edu' => ['role' => 'super_admin', 'redirect' => '/dashboards/super-admin'],
            'admin@marriott.edu' => ['role' => 'admin', 'redirect' => '/dashboards/admin'],
            'registrar@marriott.edu' => ['role' => 'registrar', 'redirect' => '/dashboards/registrar'],
            'finance@marriott.edu' => ['role' => 'finance', 'redirect' => '/dashboards/finance'],
            'teacher@marriott.edu' => ['role' => 'teacher', 'redirect' => '/dashboards/teacher'],
            'student@marriott.edu' => ['role' => 'student', 'redirect' => '/dashboards/student'],
            'parent@marriott.edu' => ['role' => 'parent', 'redirect' => '/dashboards/parent'],
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
