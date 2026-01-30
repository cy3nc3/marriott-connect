<?php

namespace App\Livewire\Admin;

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
            ['lrn' => '100000000013', 'name' => 'Padilla, Pia', 'gender' => 'Female', 'status' => 'Enrolled', 'grade' => 10, 'section' => 'Tesla'],
        ];
    }

    public function updatedSelectedGrade()
    {
        $this->selectedSection = null;
    }

    public function getAvailableSectionsProperty()
    {
        return $this->sectionMap[$this->selectedGrade] ?? [];
    }

    public function getFilteredStudentsProperty()
    {
        if (!$this->selectedGrade || !$this->selectedSection) {
            return [];
        }

        return array_filter($this->students, function ($student) {
            return $student['grade'] == $this->selectedGrade &&
                   $student['section'] == $this->selectedSection;
        });
    }

    public function getPrintDataProperty()
    {
        $students = $this->filteredStudents;

        $boys = array_filter($students, fn($s) => $s['gender'] === 'Male');
        $girls = array_filter($students, fn($s) => $s['gender'] === 'Female');

        // Sort by name
        usort($boys, fn($a, $b) => strcmp($a['name'], $b['name']));
        usort($girls, fn($a, $b) => strcmp($a['name'], $b['name']));

        return [
            'boys' => $boys,
            'girls' => $girls,
            'adviser' => $this->getAdviser($this->selectedGrade, $this->selectedSection),
        ];
    }

    private function getAdviser($grade, $section)
    {
        // Mock Adviser Logic
        $advisers = [
            '7-Rizal' => 'Mr. Juan Cruz',
            '7-Bonifacio' => 'Ms. Maria Santos',
            '8-Newton' => 'Dr. Albert Einstein',
            '8-Einstein' => 'Mr. Isaac Newton',
            '9-Dalton' => 'Mrs. Chem Is Try',
            '10-Tesla' => 'Mr. Elon Musk',
        ];

        return $advisers["$grade-$section"] ?? 'TBA';
    }

    public function render()
    {
        return view('livewire.admin.class-list-manager', [
            'availableSections' => $this->availableSections,
            'filteredStudents' => $this->filteredStudents,
            'printData' => $this->printData,
            'dateGenerated' => Carbon::now()->format('F j, Y'),
        ]);
    }
}
