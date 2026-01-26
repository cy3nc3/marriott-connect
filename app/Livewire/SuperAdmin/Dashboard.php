<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;

class Dashboard extends Component
{
    public $data = [
        'active_year' => '2025-2026',
        'total_users' => 152,
        'system_status' => 'Healthy',
    ];

    public function render()
    {
        return view('livewire.super-admin.dashboard')
            ->layout('layouts.app', ['header' => 'System Monitor']);
    }
}
