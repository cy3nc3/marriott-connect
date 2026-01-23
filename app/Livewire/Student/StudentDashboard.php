<?php

namespace App\Livewire\Student;

use Livewire\Component;

class StudentDashboard extends Component
{
    public $schedule = [
        ['time' => '8:00 AM - 9:00 AM', 'subject' => 'Mathematics', 'teacher' => 'Mr. Cruz'],
        ['time' => '9:00 AM - 10:00 AM', 'subject' => 'Science', 'teacher' => 'Ms. Reyes'],
        ['time' => '10:00 AM - 10:20 AM', 'subject' => 'Recess', 'teacher' => '-'],
        ['time' => '10:20 AM - 11:20 AM', 'subject' => 'English', 'teacher' => 'Mrs. Santos'],
        ['time' => '11:20 AM - 12:20 PM', 'subject' => 'Filipino', 'teacher' => 'Mr. Ramos'],
    ];

    public $grades = [
        ['subject' => 'Mathematics', 'q1' => 88, 'q2' => 90, 'q3' => null, 'q4' => null, 'final' => null],
        ['subject' => 'Science', 'q1' => 85, 'q2' => 87, 'q3' => null, 'q4' => null, 'final' => null],
        ['subject' => 'English', 'q1' => 92, 'q2' => 93, 'q3' => null, 'q4' => null, 'final' => null],
        ['subject' => 'Filipino', 'q1' => 89, 'q2' => 88, 'q3' => null, 'q4' => null, 'final' => null],
        ['subject' => 'Araling Panlipunan', 'q1' => 90, 'q2' => 91, 'q3' => null, 'q4' => null, 'final' => null],
    ];

    public function render()
    {
        return view('livewire.student.student-dashboard')
            ->layout('layouts.app', ['header' => 'My Dashboard']);
    }
}
