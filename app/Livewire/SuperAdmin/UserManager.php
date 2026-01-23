<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;

class UserManager extends Component
{
    public $data = [
        ['name' => 'John Doe', 'email' => 'admin@marriott.edu', 'role' => 'admin'],
        ['name' => 'Jane Smith', 'email' => 'teacher@marriott.edu', 'role' => 'teacher'],
    ];

    public $name;
    public $email;
    public $password;
    public $role = 'teacher';

    public function createUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'role' => 'required',
        ]);

        $this->data[] = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        $this->reset(['name', 'email', 'password', 'role']);

        $this->dispatch('user-created');

        session()->flash('message', 'User created successfully.');
    }

    public function render()
    {
        return view('livewire.super-admin.user-manager')
            ->layout('layouts.app', ['header' => 'User Management']);
    }
}
