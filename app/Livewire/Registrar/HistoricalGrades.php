<?php

namespace App\Livewire\Registrar;

use Livewire\Component;

class HistoricalGrades extends Component
{
    // Search
    public $studentQuery = '';
    public $selectedStudent = null;

    // Mock Data Store
    public $history = [
        [
            'id' => 1,
            'school_name' => "St. Mary's Academy",
            'school_year' => '2022-2023',
            'grade_level' => 'Grade 7',
            'subjects' => [
                ['name' => 'Mathematics', 'grade' => 85],
                ['name' => 'English', 'grade' => 88],
                ['name' => 'Science', 'grade' => 86],
                ['name' => 'Filipino', 'grade' => 90],
                ['name' => 'Araling Panlipunan', 'grade' => 89],
            ]
        ],
        [
            'id' => 2,
            'school_name' => "St. Mary's Academy",
            'school_year' => '2023-2024',
            'grade_level' => 'Grade 8',
            'subjects' => [
                ['name' => 'Mathematics', 'grade' => 87],
                ['name' => 'English', 'grade' => 91],
                ['name' => 'Science', 'grade' => 88],
                ['name' => 'Filipino', 'grade' => 92],
                ['name' => 'Araling Panlipunan', 'grade' => 90],
            ]
        ]
    ];

    // New Record Form
    public $newSchoolName = '';
    public $newSchoolYear = '';
    public $newGradeLevel = 'Grade 7';
    public $newSubjects = [
        ['name' => '', 'grade' => '']
    ];

    public function selectStudent()
    {
        // Mock selection
        $this->selectedStudent = [
            'name' => 'Juan Cruz',
            'current_level' => 'Grade 10',
            'lrn' => '123456789012'
        ];
    }

    public function addSubjectRow()
    {
        $this->newSubjects[] = ['name' => '', 'grade' => ''];
    }

    public function removeSubjectRow($index)
    {
        unset($this->newSubjects[$index]);
        $this->newSubjects = array_values($this->newSubjects);
    }

    public function saveRecord()
    {
        $this->validate([
            'newSchoolName' => 'required',
            'newSchoolYear' => 'required',
            'newSubjects.*.name' => 'required',
            'newSubjects.*.grade' => 'required|numeric',
        ]);

        $this->history[] = [
            'id' => count($this->history) + 1,
            'school_name' => $this->newSchoolName,
            'school_year' => $this->newSchoolYear,
            'grade_level' => $this->newGradeLevel,
            'subjects' => $this->newSubjects
        ];

        // Reset form
        $this->reset(['newSchoolName', 'newSchoolYear', 'newGradeLevel']);
        $this->newSubjects = [['name' => '', 'grade' => '']];

        session()->flash('message', 'Historical record saved successfully.');
        $this->dispatch('record-saved');
    }

    public function render()
    {
        return view('livewire.registrar.historical-grades')
            ->layout('layouts.app', ['header' => 'Permanent Record (SF10)']);
    }
}
