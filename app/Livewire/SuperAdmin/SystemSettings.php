<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Livewire\WithFileUploads;

class SystemSettings extends Component
{
    use WithFileUploads;

    public $logo;
    public $letterhead;

    public $data = [
        'school_name' => 'Marriott School',
        'school_id' => '101010',
        'address' => 'Tolentino Street, Quezon City',
        'maintenance_mode' => false,
        'allow_parent_portal' => true,
    ];

    public function saveSettings()
    {
        // specific simulation logic could go here
        session()->flash('message', 'System configuration saved successfully.');
    }

    public function render()
    {
        return view('livewire.super-admin.system-settings')
            ->layout('layouts.app', ['header' => 'System Settings']);
    }
}
