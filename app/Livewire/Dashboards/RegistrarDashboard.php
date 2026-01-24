<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class RegistrarDashboard extends Component
{
    public $data = [
        'grade_7' => 120,
        'grade_8' => 110,
        'capacity_alert' => 'Grade 7 - Rizal (98% Full)',
    ];

    public function render()
    {
        return view('livewire.dashboards.registrar-dashboard')
            ->layout('layouts.app', ['header' => 'Population Analytics']);
    }
}
