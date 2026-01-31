<?php

namespace App\Livewire\Registrar;

use Livewire\Component;

class StudentDirectory extends Component
{
    public $allStudents = [];
    public $filteredStudents = [];

    // Filters
    public $search = '';
    public $gradeFilter = '';
    public $statusFilter = 'all'; // all, missing, cleared

    // Modal State
    public $showModal = false;
    public $selectedStudentId = null;
    public $selectedStudentName = '';
    public $requirements = [
        'psa' => false,
        'sf9' => false,
        'good_moral' => false,
        'medical' => false,
    ];

    public function mount()
    {
        // Initialize Hardcoded Data
        $this->allStudents = [
            [
                'id' => 1,
                'lrn' => '109876543211',
                'name' => 'Cruz, Juan',
                'grade' => 'Grade 10',
                'section' => 'Rizal',
                'parent' => 'Maria Cruz',
                'contact' => '0917-111-2222',
                'requirements' => [
                    'psa' => true,
                    'sf9' => true,
                    'good_moral' => true,
                    'medical' => true,
                ]
            ],
            [
                'id' => 2,
                'lrn' => '109876543212',
                'name' => 'Santos, Ana',
                'grade' => 'Grade 8',
                'section' => 'Narra',
                'parent' => 'Pedro Santos',
                'contact' => '0918-222-3333',
                'requirements' => [
                    'psa' => true,
                    'sf9' => true,
                    'good_moral' => true,
                    'medical' => true,
                ]
            ],
            [
                'id' => 3,
                'lrn' => '109876543213',
                'name' => 'Dela Cruz, Miguel',
                'grade' => 'Grade 7',
                'section' => 'Sampaguita',
                'parent' => 'Jose Dela Cruz',
                'contact' => '0919-333-4444',
                'requirements' => [
                    'psa' => true,
                    'sf9' => false, // Missing
                    'good_moral' => true,
                    'medical' => false, // Missing
                ]
            ],
            [
                'id' => 4,
                'lrn' => '109876543214',
                'name' => 'Reyes, Elena',
                'grade' => 'Grade 10',
                'section' => 'Bonifacio',
                'parent' => 'Clara Reyes',
                'contact' => '0920-444-5555',
                'requirements' => [
                    'psa' => false, // Missing
                    'sf9' => false, // Missing
                    'good_moral' => false, // Missing
                    'medical' => false, // Missing
                ]
            ],
            [
                'id' => 5,
                'lrn' => '109876543215',
                'name' => 'Bautista, Marco',
                'grade' => 'Grade 9',
                'section' => 'Molave',
                'parent' => 'Lito Bautista',
                'contact' => '0921-555-6666',
                'requirements' => [
                    'psa' => true,
                    'sf9' => true,
                    'good_moral' => false, // Missing
                    'medical' => true,
                ]
            ],
        ];
    }

    public function manageRequirements($studentId)
    {
        $student = collect($this->allStudents)->firstWhere('id', $studentId);

        if ($student) {
            $this->selectedStudentId = $studentId;
            $this->selectedStudentName = $student['name'];
            $this->requirements = $student['requirements'];
            $this->showModal = true;
        }
    }

    public function saveRequirements()
    {
        // Update the student in the allStudents array
        foreach ($this->allStudents as &$student) {
            if ($student['id'] === $this->selectedStudentId) {
                $student['requirements'] = $this->requirements;
                break;
            }
        }

        $this->showModal = false;
        session()->flash('message', 'Requirements updated successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        // Filter Logic
        $this->filteredStudents = collect($this->allStudents)->filter(function ($student) {
            // Search Filter
            $matchesSearch = empty($this->search) ||
                stripos($student['name'], $this->search) !== false ||
                stripos($student['lrn'], $this->search) !== false;

            // Grade Filter
            $matchesGrade = empty($this->gradeFilter) || $student['grade'] === $this->gradeFilter;

            // Status Filter
            $matchesStatus = true;
            if ($this->statusFilter !== 'all') {
                $missingCount = 0;
                foreach ($student['requirements'] as $req) {
                    if (!$req) $missingCount++;
                }
                $isCleared = $missingCount === 0;

                if ($this->statusFilter === 'cleared') {
                    $matchesStatus = $isCleared;
                } elseif ($this->statusFilter === 'missing') {
                    $matchesStatus = !$isCleared;
                }
            }

            return $matchesSearch && $matchesGrade && $matchesStatus;
        })->values()->all();

        return view('livewire.registrar.student-directory')
            ->layout('layouts.app', ['header' => 'Student Directory']);
    }
}
