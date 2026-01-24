<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class AdminDashboard extends Component
{
    public $data = [
        'forecast_next_year' => 520,
        'current_enrollees' => 450,
        'revenue' => 1500000,
        'expenses' => 1200000,
    ];

    public function render()
    {
        return view('livewire.dashboards.admin-dashboard')
            ->layout('layouts.app', ['header' => 'DSS & Analytics']);
    }
}
