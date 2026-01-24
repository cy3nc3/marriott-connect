<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class SuperAdminDashboard extends Component
{
    public $data = [
        'active_year' => '2025-2026',
        'total_users' => 152,
        'system_status' => 'Healthy',
    ];

    public function render()
    {
        return view('livewire.dashboards.super-admin-dashboard')
            ->layout('layouts.app', ['header' => 'System Monitor']);
    }
}
