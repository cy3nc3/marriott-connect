<?php

namespace App\Livewire\Teacher;

use Livewire\Component;

class AdvisoryBoard extends Component
{
    public $students = [];

    public function mount()
    {
        // Mock Data: Grade 10 - Rizal
        $this->students = [
            [
                'id' => 1,
                'name' => 'Juan Dela Cruz',
                'grades' => [
                    'Math' => 85,
                    'Science' => 88,
                    'English' => 90,
                    'Filipino' => 92,
                    'History' => 89
                ],
                'behavior' => [
                    'Maka-Diyos' => 'AO',
                    'Makatao' => 'AO',
                    'Makakalikasan' => 'AO',
                    'Makabansa' => 'AO'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Maria Clara',
                'grades' => [
                    'Math' => 95,
                    'Science' => 96,
                    'English' => 98,
                    'Filipino' => 97,
                    'History' => 95
                ],
                'behavior' => [
                    'Maka-Diyos' => 'AO',
                    'Makatao' => 'AO',
                    'Makakalikasan' => 'AO',
                    'Makabansa' => 'AO'
                ]
            ],
            [
                'id' => 3,
                'name' => 'Pedro Penduko',
                'grades' => [
                    'Math' => 74,
                    'Science' => 76,
                    'English' => 73,
                    'Filipino' => 80,
                    'History' => 75
                ],
                'behavior' => [
                    'Maka-Diyos' => 'SO',
                    'Makatao' => 'SO',
                    'Makakalikasan' => 'SO',
                    'Makabansa' => 'SO'
                ]
            ],
            [
                'id' => 4,
                'name' => 'Crisostomo Ibarra',
                'grades' => [
                    'Math' => 90,
                    'Science' => 92,
                    'English' => 91,
                    'Filipino' => 88,
                    'History' => 95
                ],
                'behavior' => [
                    'Maka-Diyos' => 'AO',
                    'Makatao' => 'AO',
                    'Makakalikasan' => 'AO',
                    'Makabansa' => 'AO'
                ]
            ],
        ];
    }

    public function releaseReportCards()
    {
        // Simulation logic
        session()->flash('message', 'Report Cards have been successfully released to parents and students.');
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
