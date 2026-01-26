<?php

namespace App\Livewire\Finance;

use Livewire\Component;

class Dashboard extends Component
{
    public $data = [
        'collection_efficiency' => 78,
        'cash_today' => 15000.00,
        'monthly_forecast' => 450000,
    ];

    public function render()
    {
        return view('livewire.finance.dashboard')
            ->layout('layouts.app', ['header' => 'Revenue Analytics']);
    }
}
