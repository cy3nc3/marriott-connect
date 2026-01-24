<?php

namespace App\Livewire\Dashboards;

use Livewire\Component;

class TeacherDashboard extends Component
{
    public $data = [
        'schedule' => [
            ['time' => '8:00 AM', 'subject' => 'Science 8'],
            ['time' => '10:00 AM', 'subject' => 'Math 7 - Rizal (Up Next)'],
            ['time' => '1:00 PM', 'subject' => 'Physics 9'],
        ],
        'pending_grades' => 3,
    ];

    public function render()
    {
        return view('livewire.dashboards.teacher-dashboard')
            ->layout('layouts.app', ['header' => 'Academic Overview']);
    }
}
