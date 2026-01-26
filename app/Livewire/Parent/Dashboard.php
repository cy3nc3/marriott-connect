<?php

namespace App\Livewire\Parent;

use Livewire\Component;

class Dashboard extends Component
{
    public $data = [
        'billing_status' => 'Action Needed',
        'child' => 'Juan Cruz',
        'status' => 'Enrolled - Grade 10',
    ];

    public function render()
    {
        return view('livewire.parent.dashboard')
            ->layout('layouts.app', ['header' => 'Parent Portal']);
    }
}
