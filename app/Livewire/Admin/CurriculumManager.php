<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class CurriculumManager extends Component
{
    // Fake Data
    public $subjects = [
        ['id' => 1, 'code' => 'MATH7', 'name' => 'Mathematics 7', 'grade_level' => 7],
        ['id' => 2, 'code' => 'ENG7', 'name' => 'English 7', 'grade_level' => 7],
        ['id' => 3, 'code' => 'SCI7', 'name' => 'Science 7', 'grade_level' => 7],
        ['id' => 4, 'code' => 'FIL8', 'name' => 'Filipino 8', 'grade_level' => 8],
    ];

    // Form Properties
    public $code = '';
    public $name = '';
    public $grade_level = 7;

    public function createSubject()
    {
        // dd('createSubject called');
        // Simulate creation
        $this->subjects[] = [
            'id' => count($this->subjects) + 1,
            'code' => $this->code,
            'name' => $this->name,
            'grade_level' => $this->grade_level,
        ];

        $this->reset(['code', 'name', 'grade_level']);
        session()->flash('message', 'Subject added successfully.');
        $this->dispatch('close-modal'); // Dispatch event to close Alpine modal
    }

    public function render()
    {
        return view('livewire.admin.curriculum-manager')
            ->layout('layouts.app', ['header' => 'Curriculum Manager']);
    }
}
