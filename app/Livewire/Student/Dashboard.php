<?php

namespace App\Livewire\Student;

use Livewire\Component;

class Dashboard extends Component
{
    public $data = [
        'current_subject' => 'Science 9',
        'teacher' => 'Mr. Anderson',
    ];

    public function render()
    {
        return view('livewire.student.dashboard')
            ->layout('layouts.app', ['header' => 'My Dashboard']);
    }
}
