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
        $this->selectedStudents = [];

        // "Smart Loader" Logic
        if ($this->selectedGrade == '7' && $this->selectedSection == 'Rizal') {
            // Specific Mock Data: 4 Passing, 1 Failing
            $this->students = [
                ['id' => 101, 'name' => 'Alonzo, Bea', 'average' => 88],
                ['id' => 102, 'name' => 'Bartolome, Cris', 'average' => 92],
                ['id' => 103, 'name' => 'Cruz, John', 'average' => 74], // Retained (Avg < 75)
                ['id' => 104, 'name' => 'Dantes, Dingdong', 'average' => 85],
                ['id' => 106, 'name' => 'Faulkerson, Alden', 'average' => 89],
            ];
        } else {
            // Generic Mock Data: 5 Passing Students
            $this->students = [
                ['id' => 201, 'name' => 'Generic, Student A', 'average' => 80],
                ['id' => 202, 'name' => 'Generic, Student B', 'average' => 82],
                ['id' => 203, 'name' => 'Generic, Student C', 'average' => 85],
                ['id' => 204, 'name' => 'Generic, Student D', 'average' => 88],
                ['id' => 205, 'name' => 'Generic, Student E', 'average' => 90],
            ];
        }

        // Auto-select eligible students (Smart Pre-Selection)
        foreach ($this->students as $student) {
            if ($student['average'] >= 75) {
                $this->selectedStudents[] = (string) $student['id'];
            }
        }
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
        $validSelection = [];
        foreach ($this->selectedStudents as $id) {
            $student = collect($this->students)->firstWhere('id', $id);
            if ($student && $student['average'] >= 75) {
                $validSelection[] = $id;
            }
        }

        // In a real app, we would process $validSelection here.
        // For simulation, we assume all checked are valid since UI enforces it,
        // but we use the validated count just in case.
        $finalCount = count($validSelection);

        // Flash Message
        session()->flash('message', "Successfully promoted {$finalCount} students to Grade {$this->targetGrade}.");

        // Clear selection (optional, but usually good to reset or reload)
        // In this case, we might want to keep them visible or clear them.
        // Clearing them implies "done".
        $this->selectedStudents = [];

        // Reload to refresh state (simulating data update)
        $this->loadStudents();
    }

    public function render()
    {
        return view('livewire.registrar.batch-promotion');
    }
}
