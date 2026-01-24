<?php

namespace App\Livewire\Student;

use Livewire\Component;

class StudentSchedule extends Component
{
    public $schedule = [
        ['time' => '8:00 AM - 9:00 AM', 'subject' => 'Mathematics', 'teacher' => 'Mr. Cruz'],
        ['time' => '9:00 AM - 10:00 AM', 'subject' => 'Science', 'teacher' => 'Ms. Reyes'],
        ['time' => '10:00 AM - 10:20 AM', 'subject' => 'Recess', 'teacher' => '-'],
        ['time' => '10:20 AM - 11:20 AM', 'subject' => 'English', 'teacher' => 'Mrs. Santos'],
        ['time' => '11:20 AM - 12:20 PM', 'subject' => 'Filipino', 'teacher' => 'Mr. Ramos'],
    ];

    public function render()
    {
        return view('livewire.student.student-schedule')
            ->layout('layouts.app', ['header' => 'My Schedule']);
    }
}
