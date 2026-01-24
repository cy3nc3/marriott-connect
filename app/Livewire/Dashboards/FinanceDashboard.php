<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class FinanceDashboard extends Component
{
    public $data = [
        'collection_efficiency' => 78,
        'cash_today' => 15000.00,
        'monthly_forecast' => 450000,
    ];

    public function render()
    {
        return view('livewire.dashboards.finance-dashboard')
            ->layout('layouts.app', ['header' => 'Revenue Analytics']);
    }
}
