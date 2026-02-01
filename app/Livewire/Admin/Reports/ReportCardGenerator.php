<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;

class ReportCardGenerator extends Component
{
    public $schoolYear = '2025-2026';
    public $gradeSection = 'Grade 7 - Rizal';
    public $quarter = 'Final';
    public $selectAll = false;
    public $selectedStudents = [];

    // Mock Data
    public $students = [
        [
            'name' => 'Juan Dela Cruz',
            'lrn' => '123456789012',
            'sex' => 'M',
            'age' => 13,
            'grade_section' => 'Grade 7 - Rizal',
            'school_year' => '2025-2026',
            'status' => 'Complete',
            'attendance' => [
                'Jun' => ['days' => 20, 'present' => 20],
                'Jul' => ['days' => 22, 'present' => 21],
                'Aug' => ['days' => 20, 'present' => 20],
                'Sep' => ['days' => 21, 'present' => 21],
                'Oct' => ['days' => 23, 'present' => 23],
                'Nov' => ['days' => 19, 'present' => 19],
                'Dec' => ['days' => 15, 'present' => 15],
                'Jan' => ['days' => 20, 'present' => 18],
                'Feb' => ['days' => 18, 'present' => 18],
                'Mar' => ['days' => 22, 'present' => 22],
                'Apr' => ['days' => 20, 'present' => 20],
            ],
            'grades' => [
                'Filipino' => ['Q1' => 85, 'Q2' => 86, 'Q3' => 87, 'Q4' => 88, 'Final' => 87],
                'English' => ['Q1' => 88, 'Q2' => 89, 'Q3' => 88, 'Q4' => 90, 'Final' => 89],
                'Mathematics' => ['Q1' => 82, 'Q2' => 84, 'Q3' => 85, 'Q4' => 86, 'Final' => 84],
                'Science' => ['Q1' => 84, 'Q2' => 85, 'Q3' => 86, 'Q4' => 87, 'Final' => 86],
                'Araling Panlipunan' => ['Q1' => 89, 'Q2' => 90, 'Q3' => 91, 'Q4' => 92, 'Final' => 91],
                'Edukasyon sa Pagpapakatao' => ['Q1' => 90, 'Q2' => 91, 'Q3' => 92, 'Q4' => 93, 'Final' => 92],
                'TLE' => ['Q1' => 86, 'Q2' => 87, 'Q3' => 88, 'Q4' => 89, 'Final' => 88],
                'MAPEH' => ['Q1' => 87, 'Q2' => 88, 'Q3' => 89, 'Q4' => 90, 'Final' => 89],
            ],
            'values' => [
                'Maka-Diyos' => [
                    ['statement' => 'Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                    ['statement' => 'Shows adherence to ethical acts', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                ],
                'Maka-tao' => [
                    ['statement' => 'Is sensitive to individual, social, and cultural differences', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                ],
                'Makakalikasan' => [
                    ['statement' => 'Cares for the environment and utilizes resources wisely, judiciously, and economically', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                ],
                'Makabansa' => [
                    ['statement' => 'Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                ],
            ]
        ],
        // Student 2 (Complete)
        [
            'name' => 'Maria Santos',
            'lrn' => '987654321098',
            'sex' => 'F',
            'age' => 13,
            'grade_section' => 'Grade 7 - Rizal',
            'school_year' => '2025-2026',
            'status' => 'Complete',
            'attendance' => [
                'Jun' => ['days' => 20, 'present' => 19],
                'Jul' => ['days' => 22, 'present' => 22],
                'Aug' => ['days' => 20, 'present' => 20],
                'Sep' => ['days' => 21, 'present' => 21],
                'Oct' => ['days' => 23, 'present' => 23],
                'Nov' => ['days' => 19, 'present' => 19],
                'Dec' => ['days' => 15, 'present' => 15],
                'Jan' => ['days' => 20, 'present' => 20],
                'Feb' => ['days' => 18, 'present' => 18],
                'Mar' => ['days' => 22, 'present' => 22],
                'Apr' => ['days' => 20, 'present' => 20],
            ],
            'grades' => [
                'Filipino' => ['Q1' => 90, 'Q2' => 91, 'Q3' => 92, 'Q4' => 93, 'Final' => 92],
                'English' => ['Q1' => 92, 'Q2' => 93, 'Q3' => 94, 'Q4' => 95, 'Final' => 94],
                'Mathematics' => ['Q1' => 88, 'Q2' => 89, 'Q3' => 90, 'Q4' => 91, 'Final' => 90],
                'Science' => ['Q1' => 89, 'Q2' => 90, 'Q3' => 91, 'Q4' => 92, 'Final' => 91],
                'Araling Panlipunan' => ['Q1' => 93, 'Q2' => 94, 'Q3' => 95, 'Q4' => 96, 'Final' => 95],
                'Edukasyon sa Pagpapakatao' => ['Q1' => 94, 'Q2' => 95, 'Q3' => 96, 'Q4' => 97, 'Final' => 96],
                'TLE' => ['Q1' => 91, 'Q2' => 92, 'Q3' => 93, 'Q4' => 94, 'Final' => 93],
                'MAPEH' => ['Q1' => 92, 'Q2' => 93, 'Q3' => 94, 'Q4' => 95, 'Final' => 94],
            ],
             'values' => [
                'Maka-Diyos' => [['statement' => 'Expresses one\'s spiritual beliefs...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO'], ['statement' => 'Shows adherence to ethical acts', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Maka-tao' => [['statement' => 'Is sensitive to individual...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Makakalikasan' => [['statement' => 'Cares for the environment...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Makabansa' => [['statement' => 'Demonstrates pride...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
            ]
        ],
        // Student 3 (Complete)
        [
            'name' => 'Pedro Penduko',
            'lrn' => '112233445566',
            'sex' => 'M',
            'age' => 14,
            'grade_section' => 'Grade 7 - Rizal',
            'school_year' => '2025-2026',
            'status' => 'Complete',
            'attendance' => [
                'Jun' => ['days' => 20, 'present' => 15], 'Jul' => ['days' => 22, 'present' => 18], 'Aug' => ['days' => 20, 'present' => 15],
                'Sep' => ['days' => 21, 'present' => 16], 'Oct' => ['days' => 23, 'present' => 19], 'Nov' => ['days' => 19, 'present' => 15],
                'Dec' => ['days' => 15, 'present' => 10], 'Jan' => ['days' => 20, 'present' => 15], 'Feb' => ['days' => 18, 'present' => 14],
                'Mar' => ['days' => 22, 'present' => 18], 'Apr' => ['days' => 20, 'present' => 16],
            ],
            'grades' => [
                'Filipino' => ['Q1' => 75, 'Q2' => 76, 'Q3' => 77, 'Q4' => 78, 'Final' => 77],
                'English' => ['Q1' => 76, 'Q2' => 77, 'Q3' => 78, 'Q4' => 79, 'Final' => 78],
                'Mathematics' => ['Q1' => 75, 'Q2' => 75, 'Q3' => 76, 'Q4' => 76, 'Final' => 76],
                'Science' => ['Q1' => 76, 'Q2' => 76, 'Q3' => 77, 'Q4' => 77, 'Final' => 77],
                'Araling Panlipunan' => ['Q1' => 78, 'Q2' => 79, 'Q3' => 80, 'Q4' => 81, 'Final' => 80],
                'Edukasyon sa Pagpapakatao' => ['Q1' => 80, 'Q2' => 81, 'Q3' => 82, 'Q4' => 83, 'Final' => 82],
                'TLE' => ['Q1' => 77, 'Q2' => 78, 'Q3' => 79, 'Q4' => 80, 'Final' => 79],
                'MAPEH' => ['Q1' => 79, 'Q2' => 80, 'Q3' => 81, 'Q4' => 82, 'Final' => 81],
            ],
             'values' => [
                'Maka-Diyos' => [['statement' => 'Expresses one\'s spiritual beliefs...', 'Q1'=>'NO','Q2'=>'NO','Q3'=>'NO','Q4'=>'NO'], ['statement' => 'Shows adherence to ethical acts', 'Q1'=>'NO','Q2'=>'NO','Q3'=>'NO','Q4'=>'NO']],
                'Maka-tao' => [['statement' => 'Is sensitive to individual...', 'Q1'=>'NO','Q2'=>'NO','Q3'=>'NO','Q4'=>'NO']],
                'Makakalikasan' => [['statement' => 'Cares for the environment...', 'Q1'=>'NO','Q2'=>'NO','Q3'=>'NO','Q4'=>'NO']],
                'Makabansa' => [['statement' => 'Demonstrates pride...', 'Q1'=>'NO','Q2'=>'NO','Q3'=>'NO','Q4'=>'NO']],
            ]
        ],
        // Student 4 (Complete)
        [
            'name' => 'Jose Rizal',
            'lrn' => '554433221100',
            'sex' => 'M',
            'age' => 13,
            'grade_section' => 'Grade 7 - Rizal',
            'school_year' => '2025-2026',
            'status' => 'Complete',
            'attendance' => [
                'Jun' => ['days' => 20, 'present' => 20], 'Jul' => ['days' => 22, 'present' => 22], 'Aug' => ['days' => 20, 'present' => 20],
                'Sep' => ['days' => 21, 'present' => 21], 'Oct' => ['days' => 23, 'present' => 23], 'Nov' => ['days' => 19, 'present' => 19],
                'Dec' => ['days' => 15, 'present' => 15], 'Jan' => ['days' => 20, 'present' => 20], 'Feb' => ['days' => 18, 'present' => 18],
                'Mar' => ['days' => 22, 'present' => 22], 'Apr' => ['days' => 20, 'present' => 20],
            ],
            'grades' => [
                'Filipino' => ['Q1' => 95, 'Q2' => 96, 'Q3' => 97, 'Q4' => 98, 'Final' => 97],
                'English' => ['Q1' => 94, 'Q2' => 95, 'Q3' => 96, 'Q4' => 97, 'Final' => 96],
                'Mathematics' => ['Q1' => 96, 'Q2' => 97, 'Q3' => 98, 'Q4' => 99, 'Final' => 98],
                'Science' => ['Q1' => 95, 'Q2' => 96, 'Q3' => 97, 'Q4' => 98, 'Final' => 97],
                'Araling Panlipunan' => ['Q1' => 93, 'Q2' => 94, 'Q3' => 95, 'Q4' => 96, 'Final' => 95],
                'Edukasyon sa Pagpapakatao' => ['Q1' => 97, 'Q2' => 98, 'Q3' => 99, 'Q4' => 99, 'Final' => 98],
                'TLE' => ['Q1' => 92, 'Q2' => 93, 'Q3' => 94, 'Q4' => 95, 'Final' => 94],
                'MAPEH' => ['Q1' => 94, 'Q2' => 95, 'Q3' => 96, 'Q4' => 97, 'Final' => 96],
            ],
             'values' => [
                'Maka-Diyos' => [['statement' => 'Expresses one\'s spiritual beliefs...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO'], ['statement' => 'Shows adherence to ethical acts', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Maka-tao' => [['statement' => 'Is sensitive to individual...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Makakalikasan' => [['statement' => 'Cares for the environment...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Makabansa' => [['statement' => 'Demonstrates pride...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
            ]
        ],
        // Student 6 (Incomplete)
        [
            'name' => 'Maria Clara',
            'lrn' => '987654321098',
            'sex' => 'F',
            'age' => 13,
            'grade_section' => 'Grade 7 - Rizal',
            'school_year' => '2025-2026',
            'status' => 'Incomplete Grades',
            'attendance' => [
                'Jun' => ['days' => 20, 'present' => 18],
                'Jul' => ['days' => 22, 'present' => 20],
                'Aug' => ['days' => 20, 'present' => 19],
                'Sep' => ['days' => 21, 'present' => 20],
                'Oct' => ['days' => 23, 'present' => 22],
                'Nov' => ['days' => 19, 'present' => 18],
                'Dec' => ['days' => 15, 'present' => 14],
                'Jan' => ['days' => 20, 'present' => 19],
                'Feb' => ['days' => 18, 'present' => 17],
                'Mar' => ['days' => 22, 'present' => 21],
                'Apr' => ['days' => 20, 'present' => 19],
            ],
            'grades' => [
                'Filipino' => ['Q1' => 88, 'Q2' => 89, 'Q3' => 90, 'Q4' => '', 'Final' => ''],
                'English' => ['Q1' => 90, 'Q2' => 91, 'Q3' => 92, 'Q4' => '', 'Final' => ''],
                'Mathematics' => ['Q1' => 85, 'Q2' => 86, 'Q3' => 87, 'Q4' => '', 'Final' => ''],
                'Science' => ['Q1' => 87, 'Q2' => 88, 'Q3' => 89, 'Q4' => '', 'Final' => ''],
                'Araling Panlipunan' => ['Q1' => 91, 'Q2' => 92, 'Q3' => 93, 'Q4' => '', 'Final' => ''],
                'Edukasyon sa Pagpapakatao' => ['Q1' => 92, 'Q2' => 93, 'Q3' => 94, 'Q4' => '', 'Final' => ''],
                'TLE' => ['Q1' => 88, 'Q2' => 89, 'Q3' => 90, 'Q4' => '', 'Final' => ''],
                'MAPEH' => ['Q1' => 89, 'Q2' => 90, 'Q3' => 91, 'Q4' => '', 'Final' => ''],
            ],
             'values' => [
                'Maka-Diyos' => [
                    ['statement' => 'Expresses one\'s spiritual beliefs while respecting the spiritual beliefs of others', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                    ['statement' => 'Shows adherence to ethical acts', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                ],
                'Maka-tao' => [
                    ['statement' => 'Is sensitive to individual, social, and cultural differences', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                ],
                'Makakalikasan' => [
                    ['statement' => 'Cares for the environment and utilizes resources wisely, judiciously, and economically', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                ],
                'Makabansa' => [
                    ['statement' => 'Demonstrates pride in being a Filipino; exercises the rights and responsibilities of a Filipino citizen', 'Q1' => 'AO', 'Q2' => 'AO', 'Q3' => 'AO', 'Q4' => 'AO'],
                ],
            ]
        ],
        // Student 4 (Complete)
        [
            'name' => 'Andres Bonifacio',
            'lrn' => '665544332211',
            'sex' => 'M',
            'age' => 13,
            'grade_section' => 'Grade 7 - Rizal',
            'school_year' => '2025-2026',
            'status' => 'Complete',
            'attendance' => [
                'Jun' => ['days' => 20, 'present' => 19], 'Jul' => ['days' => 22, 'present' => 21], 'Aug' => ['days' => 20, 'present' => 19],
                'Sep' => ['days' => 21, 'present' => 20], 'Oct' => ['days' => 23, 'present' => 22], 'Nov' => ['days' => 19, 'present' => 18],
                'Dec' => ['days' => 15, 'present' => 15], 'Jan' => ['days' => 20, 'present' => 19], 'Feb' => ['days' => 18, 'present' => 17],
                'Mar' => ['days' => 22, 'present' => 21], 'Apr' => ['days' => 20, 'present' => 20],
            ],
            'grades' => [
                'Filipino' => ['Q1' => 80, 'Q2' => 81, 'Q3' => 82, 'Q4' => 83, 'Final' => 82],
                'English' => ['Q1' => 81, 'Q2' => 82, 'Q3' => 83, 'Q4' => 84, 'Final' => 83],
                'Mathematics' => ['Q1' => 78, 'Q2' => 79, 'Q3' => 80, 'Q4' => 81, 'Final' => 80],
                'Science' => ['Q1' => 79, 'Q2' => 80, 'Q3' => 81, 'Q4' => 82, 'Final' => 81],
                'Araling Panlipunan' => ['Q1' => 85, 'Q2' => 86, 'Q3' => 87, 'Q4' => 88, 'Final' => 87],
                'Edukasyon sa Pagpapakatao' => ['Q1' => 88, 'Q2' => 89, 'Q3' => 90, 'Q4' => 91, 'Final' => 90],
                'TLE' => ['Q1' => 82, 'Q2' => 83, 'Q3' => 84, 'Q4' => 85, 'Final' => 84],
                'MAPEH' => ['Q1' => 84, 'Q2' => 85, 'Q3' => 86, 'Q4' => 87, 'Final' => 86],
            ],
             'values' => [
                'Maka-Diyos' => [['statement' => 'Expresses one\'s spiritual beliefs...', 'Q1'=>'SO','Q2'=>'SO','Q3'=>'SO','Q4'=>'SO'], ['statement' => 'Shows adherence to ethical acts', 'Q1'=>'SO','Q2'=>'SO','Q3'=>'SO','Q4'=>'SO']],
                'Maka-tao' => [['statement' => 'Is sensitive to individual...', 'Q1'=>'SO','Q2'=>'SO','Q3'=>'SO','Q4'=>'SO']],
                'Makakalikasan' => [['statement' => 'Cares for the environment...', 'Q1'=>'SO','Q2'=>'SO','Q3'=>'SO','Q4'=>'SO']],
                'Makabansa' => [['statement' => 'Demonstrates pride...', 'Q1'=>'SO','Q2'=>'SO','Q3'=>'SO','Q4'=>'SO']],
            ]
        ],
        // Student 5 (Complete)
        [
            'name' => 'Gabriela Silang',
            'lrn' => '778899001122',
            'sex' => 'F',
            'age' => 14,
            'grade_section' => 'Grade 7 - Rizal',
            'school_year' => '2025-2026',
            'status' => 'Complete',
            'attendance' => [
                'Jun' => ['days' => 20, 'present' => 20], 'Jul' => ['days' => 22, 'present' => 22], 'Aug' => ['days' => 20, 'present' => 20],
                'Sep' => ['days' => 21, 'present' => 21], 'Oct' => ['days' => 23, 'present' => 23], 'Nov' => ['days' => 19, 'present' => 19],
                'Dec' => ['days' => 15, 'present' => 15], 'Jan' => ['days' => 20, 'present' => 20], 'Feb' => ['days' => 18, 'present' => 18],
                'Mar' => ['days' => 22, 'present' => 22], 'Apr' => ['days' => 20, 'present' => 20],
            ],
            'grades' => [
                'Filipino' => ['Q1' => 89, 'Q2' => 90, 'Q3' => 91, 'Q4' => 92, 'Final' => 91],
                'English' => ['Q1' => 91, 'Q2' => 92, 'Q3' => 93, 'Q4' => 94, 'Final' => 93],
                'Mathematics' => ['Q1' => 88, 'Q2' => 89, 'Q3' => 90, 'Q4' => 91, 'Final' => 90],
                'Science' => ['Q1' => 90, 'Q2' => 91, 'Q3' => 92, 'Q4' => 93, 'Final' => 92],
                'Araling Panlipunan' => ['Q1' => 92, 'Q2' => 93, 'Q3' => 94, 'Q4' => 95, 'Final' => 94],
                'Edukasyon sa Pagpapakatao' => ['Q1' => 94, 'Q2' => 95, 'Q3' => 96, 'Q4' => 97, 'Final' => 96],
                'TLE' => ['Q1' => 89, 'Q2' => 90, 'Q3' => 91, 'Q4' => 92, 'Final' => 91],
                'MAPEH' => ['Q1' => 91, 'Q2' => 92, 'Q3' => 93, 'Q4' => 94, 'Final' => 93],
            ],
             'values' => [
                'Maka-Diyos' => [['statement' => 'Expresses one\'s spiritual beliefs...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO'], ['statement' => 'Shows adherence to ethical acts', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Maka-tao' => [['statement' => 'Is sensitive to individual...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Makakalikasan' => [['statement' => 'Cares for the environment...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
                'Makabansa' => [['statement' => 'Demonstrates pride...', 'Q1'=>'AO','Q2'=>'AO','Q3'=>'AO','Q4'=>'AO']],
            ]
        ],
    ];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedStudents = array_column($this->students, 'lrn');
        } else {
            $this->selectedStudents = [];
        }
    }

    public function render()
    {
        return view('livewire.admin.reports.report-card-generator')
            ->layout('layouts.app');
    }
}
