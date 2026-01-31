<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Dashboard extends Component
{
    public $data = [
        'forecast_next_year' => 520,
        'current_enrollees' => 450,
        'collected' => 1500000,
        'receivables' => 1000000,
    ];

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.app', ['header' => 'DSS & Analytics']);
    }
}
