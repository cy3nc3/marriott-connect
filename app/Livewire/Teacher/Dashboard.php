<?php

namespace App\Livewire\Teacher;

use Livewire\Component;

class Dashboard extends Component
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
        return view('livewire.teacher.dashboard')
            ->layout('layouts.app', ['header' => 'Academic Overview']);
    }
}
