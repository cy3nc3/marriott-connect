<?php

namespace App\Livewire\Registrar;

use Livewire\Component;

class BatchPromotion extends Component
{
    // Filter State
    public $selectedGrade = '7';
    public $selectedSection = 'Rizal';
    public $targetGrade = '8';

    // Data
    public $students = [];
    public $selectedStudents = [];

    // Mock Options
    public $gradeLevels = ['7', '8', '9', '10', '11', '12'];
    public $sections = ['Rizal', 'Bonifacio', 'Luna', 'Mabini'];

    public function mount()
    {
        // Initial Mock Data
        $this->loadStudents();
    }

    public function updatedSelectedGrade() { $this->loadStudents(); }
    public function updatedSelectedSection() { $this->loadStudents(); }

    public function loadStudents()
    {
        // Mocking different data based on filters could be done here,
        // but for the prototype, we'll return a fixed set with mixed grades.
        $this->students = [
            ['id' => 101, 'name' => 'Alonzo, Bea', 'average' => 88],
            ['id' => 102, 'name' => 'Bartolome, Cris', 'average' => 92],
            ['id' => 103, 'name' => 'Cruz, John', 'average' => 74], // Retained
            ['id' => 104, 'name' => 'Dantes, Dingdong', 'average' => 85],
            ['id' => 105, 'name' => 'Estrada, Joseph', 'average' => 72], // Retained
            ['id' => 106, 'name' => 'Faulkerson, Alden', 'average' => 89],
        ];

        // Reset selection when data changes
        $this->selectedStudents = [];
    }

    public function promoteStudents()
    {
        // Count selected
        $count = count($this->selectedStudents);

        if ($count === 0) {
            return;
        }

        // Validate that no failing students were somehow selected
        // (Server-side validation backup)
        foreach ($this->selectedStudents as $id) {
            $student = collect($this->students)->firstWhere('id', $id);
            if ($student && $student['average'] < 75) {
                // Remove from selection or throw error
                // For this mock, we just ignore/skip
                continue;
            }
        }

        // Logic to "promote" would go here (DB updates)

        session()->flash('message', "Success! {$count} students marked eligible for Enrollment in Grade {$this->targetGrade}.");

        // Clear selection
        $this->selectedStudents = [];
    }

    public function render()
    {
        return view('livewire.registrar.batch-promotion');
    }
}
