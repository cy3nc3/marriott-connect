<?php

namespace App\Livewire\Parent;

use Livewire\Component;

class StudentGrades extends Component
{
    public function render()
    {
        return view('livewire.parent.student-grades')
            ->layout('layouts.app', ['header' => 'Report Card']);
    }
}
