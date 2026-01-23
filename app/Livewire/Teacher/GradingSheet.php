<?php

namespace App\Livewire\Teacher;

use Livewire\Component;

class GradingSheet extends Component
{
    public $subject = 'Mathematics 7';
    public $section = 'Emerald';

    // Assessment Columns
    // Types: ww (Written Work), pt (Performance Task), qa (Quarterly Assessment)
    public $columns = [
        ['id' => 1, 'name' => 'Quiz 1', 'type' => 'ww', 'max' => 20],
        ['id' => 2, 'name' => 'Quiz 2', 'type' => 'ww', 'max' => 25],
        ['id' => 3, 'name' => 'Activity 1', 'type' => 'pt', 'max' => 50],
        ['id' => 4, 'name' => 'Project', 'type' => 'pt', 'max' => 100],
        ['id' => 5, 'name' => '1st Quarter Exam', 'type' => 'qa', 'max' => 50],
    ];

    // Students and Scores
    public $students = [
        [
            'id' => 1,
            'name' => 'Cruz, Juan',
            'scores' => [1 => 18, 2 => 20, 3 => 45, 4 => 85, 5 => 40],
            'grade' => 0
        ],
        [
            'id' => 2,
            'name' => 'Santos, Maria',
            'scores' => [1 => 20, 2 => 25, 3 => 50, 4 => 95, 5 => 48],
            'grade' => 0
        ],
        [
            'id' => 3,
            'name' => 'Dizon, Pedro',
            'scores' => [1 => 10, 2 => 15, 3 => 30, 4 => 70, 5 => 25],
            'grade' => 0
        ],
    ];

    public function mount()
    {
        $this->calculateGrades();
    }

    public function updatedStudents()
    {
        $this->calculateGrades();
    }

    public function calculateGrades()
    {
        // DepEd Weights: WW 40%, PT 40%, QA 20%
        $weights = ['ww' => 0.40, 'pt' => 0.40, 'qa' => 0.20];

        foreach ($this->students as $index => $student) {
            $totals = ['ww' => 0, 'pt' => 0, 'qa' => 0];
            $max_totals = ['ww' => 0, 'pt' => 0, 'qa' => 0];

            // Sum scores and max scores by type
            foreach ($this->columns as $col) {
                $score = (float) ($student['scores'][$col['id']] ?? 0);
                $totals[$col['type']] += $score;
                $max_totals[$col['type']] += $col['max'];
            }

            // Calculate weighted grade
            $final_grade = 0;
            foreach ($weights as $type => $weight) {
                if ($max_totals[$type] > 0) {
                    $percentage = ($totals[$type] / $max_totals[$type]) * 100;
                    $final_grade += $percentage * $weight;
                }
            }

            // Transmutation (Simplified: just using the raw weighted average for now,
            // or we could mock a transmutation table, but raw is fine for this demo)
            $this->students[$index]['grade'] = round($final_grade, 2);
        }
    }

    public function render()
    {
        return view('livewire.teacher.grading-sheet')
            ->layout('layouts.app', ['header' => 'Grading Sheet', 'role' => 'teacher']);
    }
}
