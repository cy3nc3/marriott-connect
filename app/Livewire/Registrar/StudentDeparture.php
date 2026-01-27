<?php

namespace App\Livewire\Registrar;

use Livewire\Component;

class StudentDeparture extends Component
{
    // Search
    public $searchQuery = '';
    public $selectedStudent = null;

    // Form
    public $reason = '';
    public $effectivityDate = '';
    public $credentialsReleased = false;
    public $remarks = '';

    // Hardcoded Data Source
    protected $students = [
        [
            'id' => 1,
            'name' => 'Juan Dela Cruz',
            'lrn' => '109876543212',
            'grade_level' => 'Grade 10',
            'section' => 'Section A',
            'status' => 'Active'
        ],
        [
            'id' => 2,
            'name' => 'Maria Santos',
            'lrn' => '109876543213',
            'grade_level' => 'Grade 8',
            'section' => 'Section B',
            'status' => 'Active'
        ]
    ];

    public function search()
    {
        // Simple mock search: Finds the first student or defaults to Juan if query is generic
        if (empty($this->searchQuery)) {
            $this->selectedStudent = null;
            return;
        }

        // Simulate finding a student
        // For simplicity, if they type "Maria", they get Maria, otherwise Juan
        if (str_contains(strtolower($this->searchQuery), 'maria')) {
            $this->selectedStudent = $this->students[1];
        } else {
            $this->selectedStudent = $this->students[0];
        }

        $this->resetForm();
    }

    public function processDeparture()
    {
        $this->validate([
            'reason' => 'required',
            'effectivityDate' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        // Simulate processing
        $name = $this->selectedStudent['name'];

        // Reset Everything
        $this->selectedStudent = null;
        $this->searchQuery = '';
        $this->resetForm();

        session()->flash('message', "Success: {$name} has been marked as Dropped/Transferred.");
    }

    private function resetForm()
    {
        $this->reason = '';
        $this->effectivityDate = '';
        $this->credentialsReleased = false;
        $this->remarks = '';
    }

    public function render()
    {
        return view('livewire.registrar.student-departure')
            ->layout('layouts.app', ['header' => 'Student Departure (Dropping/Transfer)']);
    }
}
