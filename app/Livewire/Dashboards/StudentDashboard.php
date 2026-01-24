<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class StudentDashboard extends Component
{
    public $data = [
        'current_subject' => 'Science 9',
        'teacher' => 'Mr. Anderson',
    ];

    public function render()
    {
        return view('livewire.dashboards.student-dashboard')
            ->layout('layouts.app', ['header' => 'My Dashboard']);
    }
}
