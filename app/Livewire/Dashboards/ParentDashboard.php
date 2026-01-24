<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class ParentDashboard extends Component
{
    public $data = [
        'billing_status' => 'Action Needed',
        'child' => 'Juan Cruz',
        'status' => 'Enrolled - Grade 10',
    ];

    public function render()
    {
        return view('livewire.dashboards.parent-dashboard')
            ->layout('layouts.app', ['header' => 'Parent Portal']);
    }
}
