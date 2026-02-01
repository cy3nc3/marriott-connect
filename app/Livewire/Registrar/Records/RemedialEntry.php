<?php

namespace App\Livewire\Registrar\Records;

use Livewire\Component;

class RemedialEntry extends Component
{
    // Search State
    public $searchQuery = '';
    public $selectedStudentId = null;

    // Form State
    public $remedialGrade = null;

    // Mock Data
    public $students = [];

    public function mount()
    {
        // Mock Retained Students
        $this->students = [
            [
                'id' => 101,
                'name' => 'Dizon, Pedro',
                'subject' => 'Mathematics 7',
                'final_grade' => 70,
                'status' => 'Retained'
            ],
            [
                'id' => 102,
                'name' => 'Reyes, Anna',
                'subject' => 'Science 8',
                'final_grade' => 72,
                'status' => 'Retained'
            ],
            [
                'id' => 103,
                'name' => 'Santos, Miguel',
                'subject' => 'English 9',
                'final_grade' => 68,
                'status' => 'Retained'
            ],
        ];
    }

    // Computed Property: Filtered Students
    public function getFilteredStudentsProperty()
    {
        if (empty($this->searchQuery)) {
            return [];
        }

        return collect($this->students)
            ->filter(function ($student) {
                return stripos($student['name'], $this->searchQuery) !== false;
            })
            ->all();
    }

    // Computed Property: Selected Student
    public function getSelectedStudentProperty()
    {
        if (!$this->selectedStudentId) {
            return null;
        }

        return collect($this->students)->firstWhere('id', $this->selectedStudentId);
    }

    // Computed Property: Recomputed Grade
    public function getRecomputedFinalGradeProperty()
    {
        $student = $this->selectedStudent;

        if (!$student || !is_numeric($this->remedialGrade)) {
            return null;
        }

        $oldGrade = $student['final_grade'];
        $newGrade = $this->remedialGrade;

        // DepEd Formula: (Old + Remedial) / 2
        // We assume simple average logic as requested
        return ($oldGrade + $newGrade) / 2;
    }

    public function selectStudent($id)
    {
        $this->selectedStudentId = $id;
        $this->searchQuery = ''; // Clear search
        $this->remedialGrade = null; // Reset form
    }

    public function clearSelection()
    {
        $this->selectedStudentId = null;
        $this->remedialGrade = null;
    }

    public function updateStatus()
    {
        $student = $this->selectedStudent;
        $finalGrade = $this->recomputedFinalGrade;

        if (!$student || !$finalGrade) {
            return;
        }

        if ($finalGrade >= 75) {
            session()->flash('message', "Student {$student['name']} status updated to Promoted. New Final Grade: {$finalGrade}");
            $this->clearSelection();
        } else {
            session()->flash('error', "Recomputed grade is {$finalGrade}. Student remains Retained.");
        }
    }

    public function render()
    {
        return view('livewire.registrar.records.remedial-entry')
            ->layout('layouts.app', ['header' => 'Remedial / Summer Class Entry']);
    }
}
