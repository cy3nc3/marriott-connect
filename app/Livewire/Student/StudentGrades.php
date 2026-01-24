<?php

namespace App\Livewire\Student;

use Livewire\Component;

class StudentGrades extends Component
{
    public $grades = [
        ['subject' => 'Mathematics', 'q1' => 88, 'q2' => 90, 'q3' => null, 'q4' => null, 'final' => null],
        ['subject' => 'Science', 'q1' => 85, 'q2' => 87, 'q3' => null, 'q4' => null, 'final' => null],
        ['subject' => 'English', 'q1' => 92, 'q2' => 93, 'q3' => null, 'q4' => null, 'final' => null],
        ['subject' => 'Filipino', 'q1' => 89, 'q2' => 88, 'q3' => null, 'q4' => null, 'final' => null],
        ['subject' => 'Araling Panlipunan', 'q1' => 90, 'q2' => 91, 'q3' => null, 'q4' => null, 'final' => null],
    ];

    public function render()
    {
        return view('livewire.student.student-grades')
            ->layout('layouts.app', ['header' => 'Report Card']);
    }
}
