<?php

namespace App\Livewire\Admin\Scheduling;

use Livewire\Component;
use Carbon\Carbon;

class ClassListManager extends Component
{
    public $selectedGrade = null;
    public $selectedSection = null;

    // Hardcoded Data
    public $grades = [7, 8, 9, 10];
    public $sectionMap = [
        7 => ['Rizal', 'Bonifacio'],
        8 => ['Newton', 'Einstein'],
        9 => ['Dalton'],
        10 => ['Tesla'],
    ];

    public $students = [];

    public function mount()
    {
        // Mock Student Database
        $this->students = [
            // Grade 7 - Rizal
            ['lrn' => '100000000001', 'name' => 'Abad, Anthony', 'gender' => 'Male', 'status' => 'Enrolled', 'grade' => 7, 'section' => 'Rizal'],
            ['lrn' => '100000000002', 'name' => 'Bautista, Ben', 'gender' => 'Male', 'status' => 'Enrolled', 'grade' => 7, 'section' => 'Rizal'],
            ['lrn' => '100000000003', 'name' => 'Alonzo, Bea', 'gender' => 'Female', 'status' => 'Enrolled', 'grade' => 7, 'section' => 'Rizal'],
            ['lrn' => '100000000004', 'name' => 'Bernardo, Kathryn', 'gender' => 'Female', 'status' => 'Enrolled', 'grade' => 7, 'section' => 'Rizal'],

            // Grade 7 - Bonifacio
            ['lrn' => '100000000005', 'name' => 'Castro, Charles', 'gender' => 'Male', 'status' => 'Enrolled', 'grade' => 7, 'section' => 'Bonifacio'],
            ['lrn' => '100000000006', 'name' => 'Curtis, Anne', 'gender' => 'Female', 'status' => 'Enrolled', 'grade' => 7, 'section' => 'Bonifacio'],

            // Grade 8 - Newton
            ['lrn' => '100000000007', 'name' => 'Ignacio, Ivan', 'gender' => 'Male', 'status' => 'Enrolled', 'grade' => 8, 'section' => 'Newton'],
            ['lrn' => '100000000008', 'name' => 'Imperial, Iza', 'gender' => 'Female', 'status' => 'Enrolled', 'grade' => 8, 'section' => 'Newton'],

            // Grade 8 - Einstein
            ['lrn' => '100000000009', 'name' => 'Javier, Jose', 'gender' => 'Male', 'status' => 'Enrolled', 'grade' => 8, 'section' => 'Einstein'],

            // Grade 9 - Dalton
            ['lrn' => '100000000010', 'name' => 'Manalo, Mark', 'gender' => 'Male', 'status' => 'Enrolled', 'grade' => 9, 'section' => 'Dalton'],
            ['lrn' => '100000000011', 'name' => 'Lim, Liza', 'gender' => 'Female', 'status' => 'Dropped', 'grade' => 9, 'section' => 'Dalton'],

            // Grade 10 - Tesla
            ['lrn' => '100000000012', 'name' => 'Navarro, Nathan', 'gender' => 'Male', 'status' => 'Enrolled', 'grade' => 10, 'section' => 'Tesla'],
        ];
    }

    public function updatedSelectedGrade($value)
    {
        // Reset section when grade changes
        $this->selectedSection = null;
    }

    public function render()
    {
        $filteredStudents = collect($this->students);

        if ($this->selectedGrade) {
            $filteredStudents = $filteredStudents->where('grade', $this->selectedGrade);
        }

        if ($this->selectedSection) {
            $filteredStudents = $filteredStudents->where('section', $this->selectedSection);
        }

        $printData = [
            'adviser' => 'TBA', // Mock adviser logic could go here
            'boys' => $filteredStudents->where('gender', 'Male')->values(),
            'girls' => $filteredStudents->where('gender', 'Female')->values(),
        ];

        return view('livewire.admin.scheduling.class-list-manager', [
            'filteredStudents' => $filteredStudents->values(),
            'currentSections' => $this->selectedGrade ? ($this->sectionMap[$this->selectedGrade] ?? []) : [],
            'printData' => $printData,
            'availableSections' => $this->selectedGrade ? ($this->sectionMap[$this->selectedGrade] ?? []) : [],
            'dateGenerated' => date('F d, Y'),
        ])->layout('layouts.app', ['header' => 'Class Lists']);
    }
}
