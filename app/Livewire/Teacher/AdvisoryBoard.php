<?php

namespace App\Livewire\Teacher;

use Livewire\Component;

class AdvisoryBoard extends Component
{
    public $students = [];
    public $selectedQuarter;

    public function mount()
    {
        $this->selectedQuarter = session('selected_quarter', '1st');
        $this->loadStudents();
    }

    public function updatedSelectedQuarter($value)
    {
        session(['selected_quarter' => $value]);
        $this->loadStudents();
    }

    public function loadStudents()
    {
        $subjects = ['Math', 'Science', 'English', 'Filipino', 'AP', 'TLE', 'MAPEH'];
        $baseStudents = [
            1 => 'Juan Dela Cruz',
            2 => 'Maria Clara',
            3 => 'Pedro Penduko',
            4 => 'Crisostomo Ibarra',
            5 => 'Sisa',
            6 => 'Basilio',
            7 => 'Elias'
        ];

        $this->students = [];

        foreach ($baseStudents as $id => $name) {
            $grades = [];
            foreach ($subjects as $subject) {
                if ($this->selectedQuarter == '1st') {
                    // Q1: Good grades
                    $grades[$subject] = rand(85, 98);
                } elseif ($this->selectedQuarter == '2nd') {
                    // Q2: Lower grades, some failing
                    if ($id == 3 || $id == 5) { // Pedro and Sisa struggle in Q2
                         // Force failing in Math/Science
                         if (in_array($subject, ['Math', 'Science'])) {
                             $grades[$subject] = rand(65, 74);
                         } else {
                             $grades[$subject] = rand(75, 82);
                         }
                    } else {
                         $grades[$subject] = rand(80, 92);
                    }
                } else {
                    // Default for 3rd/4th
                    $grades[$subject] = rand(75, 95);
                }
            }

            // Mock Behavior
            $behavior = [
                'Maka-Diyos' => 'AO',
                'Makatao' => 'AO',
                'Makakalikasan' => 'AO',
                'Makabansa' => 'AO'
            ];
             if ($this->selectedQuarter == '2nd' && ($id == 3 || $id == 5)) {
                 $behavior = [
                    'Maka-Diyos' => 'SO',
                    'Makatao' => 'SO',
                    'Makakalikasan' => 'SO',
                    'Makabansa' => 'SO'
                ];
             }

            $this->students[] = [
                'id' => $id,
                'name' => $name,
                'grades' => $grades,
                'behavior' => $behavior
            ];
        }
    }

    public function releaseReportCards()
    {
        $count = count($this->students);
        session()->flash('message', "Report cards for {$count} students generated successfully.");
    }

    public function render()
    {
        // Calculate averages on the fly for display
        $studentsWithAverages = collect($this->students)->map(function ($student) {
            $grades = collect($student['grades']);
            $student['average'] = $grades->avg();
            return $student;
        });

        return view('livewire.teacher.advisory-board', [
            'studentsWithAverages' => $studentsWithAverages
        ]);
    }
}
