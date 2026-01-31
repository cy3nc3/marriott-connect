<?php

namespace App\Livewire\Parent;

use Livewire\Component;

class StudentSchedule extends Component
{
    public function render()
    {
        return view('livewire.parent.student-schedule')
            ->layout('layouts.app', ['header' => 'Student Schedule']);
    }
}
