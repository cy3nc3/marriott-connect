<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SectionManager extends Component
{
    // Fake Data
    public $sections = [
        ['id' => 1, 'name' => 'Rizal', 'grade_level' => 7, 'adviser' => 'Mr. Juan Cruz'],
        ['id' => 2, 'name' => 'Bonifacio', 'grade_level' => 7, 'adviser' => 'Ms. Maria Santos'],
        ['id' => 3, 'name' => 'Emerald', 'grade_level' => 8, 'adviser' => 'Mrs. Lorna Reyes'],
    ];

    public $teachers = [
        'Mr. Juan Cruz',
        'Ms. Maria Santos',
        'Mrs. Lorna Reyes',
        'Mr. Pedro Dizon',
        'Ms. Anna Lee',
    ];

    // Form Properties
    public $name = '';
    public $grade_level = 7;
    public $adviser = '';

    public function mount()
    {
        $this->adviser = $this->teachers[0];
    }

    public function createSection()
    {
        // Simulate creation
        $this->sections[] = [
            'id' => count($this->sections) + 1,
            'name' => $this->name,
            'grade_level' => $this->grade_level,
            'adviser' => $this->adviser,
        ];

        $this->reset(['name', 'grade_level']);
        $this->adviser = $this->teachers[0];

        session()->flash('message', 'Section created successfully.');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.admin.section-manager')
            ->layout('layouts.app', ['header' => 'Section Manager']);
    }
}
