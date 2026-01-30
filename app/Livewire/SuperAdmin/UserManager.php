<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;

class UserManager extends Component
{
    public $users = [];

    // Form Fields
    public $name;
    public $email;
    public $password;
    public $role = 'teacher';
    public $grantEnrollmentAccess = false;

    // State
    public $editingIndex = null;
    public $showUserModal = false;

    // Reset Password Modal State
    public $showResetModal = false;
    public $resetUserName = '';
    public $resetPassword = '';

    public function mount()
    {
        $defaultUsers = [
            ['name' => 'Principal', 'email' => 'admin@marriott.edu', 'role' => 'admin', 'grant_enrollment_access' => true],
            ['name' => 'Mr. Tan', 'email' => 'registrar@marriott.edu', 'role' => 'registrar', 'grant_enrollment_access' => true],
            ['name' => 'Ms. Cash', 'email' => 'finance@marriott.edu', 'role' => 'finance', 'grant_enrollment_access' => false],
            ['name' => 'Ms. Reyes', 'email' => 'reyes@marriott.edu', 'role' => 'teacher', 'grant_enrollment_access' => false],
            ['name' => 'Mr. Garcia', 'email' => 'garcia@marriott.edu', 'role' => 'teacher', 'grant_enrollment_access' => false],
            ['name' => 'Mrs. Cruz', 'email' => 'parent@marriott.edu', 'role' => 'parent', 'grant_enrollment_access' => false],
        ];

        $this->users = session()->get('users', $defaultUsers);
    }

    public function openCreateModal()
    {
        $this->resetInputFields();
        $this->editingIndex = null;
        $this->showUserModal = true;
    }

    public function editUser($index)
    {
        $user = $this->users[$index];
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->role = $user['role'];
        $this->grantEnrollmentAccess = $user['grant_enrollment_access'] ?? false;
        // Password is not loaded for editing in this simple simulation

        $this->editingIndex = $index;
        $this->showUserModal = true;
    }

    public function saveUser()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ];

        // Only require password for new users
        if ($this->editingIndex === null) {
            $rules['password'] = 'required|min:8';
        }

        $this->validate($rules);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'grant_enrollment_access' => $this->grantEnrollmentAccess,
        ];

        if ($this->editingIndex !== null) {
            // Update existing
            // Preserve existing password if not changing (simulated)
            $userData['password'] = $this->users[$this->editingIndex]['password'] ?? 'default123';
            $this->users[$this->editingIndex] = $userData;
            session()->flash('message', 'User updated successfully.');
        } else {
            // Create new
            $userData['password'] = $this->password;
            $this->users[] = $userData;
            session()->flash('message', 'User created successfully.');
        }

        session()->put('users', $this->users);

        $this->showUserModal = false;
        $this->resetInputFields();
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->reset(['name', 'email', 'password', 'role', 'grantEnrollmentAccess', 'editingIndex']);
        $this->role = 'teacher'; // Reset to default
    }

    public function openResetModal($index)
    {
        $this->resetUserName = $this->users[$index]['name'];
        $this->resetPassword = 'marriottconnect2026'; // Default value
        $this->showResetModal = true;
    }

    public function closeResetModal()
    {
        $this->showResetModal = false;
        $this->reset(['resetUserName', 'resetPassword']);
    }

    public function savePassword()
    {
        // Prototype: No actual data update needed for this demo requirement, just flash message
        session()->flash('message', "Success: Password reset to '{$this->resetPassword}'.");
        $this->closeResetModal();
    }

    public function render()
    {
        return view('livewire.super-admin.user-manager')
            ->layout('layouts.app', ['header' => 'User Management']);
    }
}
