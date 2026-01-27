<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

class CustomLogin extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        return redirect()->route('dashboard');
    }

    #[Layout('layouts.standalone')]
    public function render()
    {
        return view('livewire.auth.custom-login');
    }
}
