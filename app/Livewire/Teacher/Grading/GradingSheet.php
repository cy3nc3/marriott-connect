<?php

namespace App\Livewire\Teacher\Grading;

use Livewire\Component;
use Illuminate\Support\Str;

class GradingSheet extends Component
{
    // Filters
    public $quarter = '1st';
    public $grade = 'Grade 7';
    public $section = 'Rizal';
    public $subject = 'Math';

    // Data
    public $columns = [];
    public $students = [];
    public $showData = false;

    // Modal State
    public $showAddModal = false;
    public $newActivityTitle = '';
    public $newActivityType = 'ww'; // ww, pt, qa
    public $newActivityMax = 10;

    public function mount()
    {
        $this->loadData();
    }

    public function updated($property)
    {
        if (in_array($property, ['quarter', 'grade', 'section', 'subject'])) {
            $this->loadData();
        }
    }

    public function loadData()
    {
        // Happy Path Check: Grade 7 - Rizal - Math
        if ($this->grade === 'Grade 7' && $this->section === 'Rizal' && $this->subject === 'Math') {
            $this->showData = true;

            // Try loading from session first to persist data across reloads
            if (session()->has('grading_sheet_data')) {
                $data = session('grading_sheet_data');
                $this->columns = $data['columns'];
                $this->students = $data['students'];
            } else {
                // Initialize Mock Data
                $this->columns = [
                    ['id' => 'ww1', 'name' => 'Quiz 1', 'type' => 'ww', 'max' => 20],
                    ['id' => 'ww2', 'name' => 'Quiz 2', 'type' => 'ww', 'max' => 30],
                    ['id' => 'pt1', 'name' => 'Group Project', 'type' => 'pt', 'max' => 50],
                ];

                $this->students = [
                    ['id' => 1, 'name' => 'Cruz, Juan', 'scores' => ['ww1' => 18, 'ww2' => 25, 'pt1' => 45], 'grade' => 0],
                    ['id' => 2, 'name' => 'Santos, Maria', 'scores' => ['ww1' => 20, 'ww2' => 30, 'pt1' => 50], 'grade' => 0],
                    ['id' => 3, 'name' => 'Dizon, Pedro', 'scores' => ['ww1' => 15, 'ww2' => 20, 'pt1' => 40], 'grade' => 0],
                    ['id' => 4, 'name' => 'Reyes, Jose', 'scores' => ['ww1' => 10, 'ww2' => 15, 'pt1' => 35], 'grade' => 0],
                    ['id' => 5, 'name' => 'Lim, Anna', 'scores' => ['ww1' => 19, 'ww2' => 28, 'pt1' => 48], 'grade' => 0],
                ];

                $this->calculateGrades();
            }
        } else {
            $this->showData = false;
            $this->columns = [];
            $this->students = [];
        }
    }

    public function updatedStudents()
    {
        $this->calculateGrades();
        $this->persist();
    }

    public function calculateGrades()
    {
        // Standard Weights: WW 40%, PT 40%, QA 20%
        $weights = ['ww' => 0.40, 'pt' => 0.40, 'qa' => 0.20];

        foreach ($this->students as $index => $student) {
            $totals = ['ww' => 0, 'pt' => 0, 'qa' => 0];
            $max_totals = ['ww' => 0, 'pt' => 0, 'qa' => 0];

            // Sum scores and max scores by type
            foreach ($this->columns as $col) {
                $score = (float) ($student['scores'][$col['id']] ?? 0);
                // Ensure score doesn't exceed max
                if ($score > $col['max']) {
                    $score = $col['max'];
                    $this->students[$index]['scores'][$col['id']] = $score;
                }

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

            $this->students[$index]['grade'] = round($final_grade, 2);
        }
    }

    public function openAddModal()
    {
        $this->reset(['newActivityTitle', 'newActivityType', 'newActivityMax']);
        $this->showAddModal = true;
    }

    public function saveEntry()
    {
        $this->validate([
            'newActivityTitle' => 'required|string',
            'newActivityType' => 'required|in:ww,pt,qa',
            'newActivityMax' => 'required|numeric|min:1',
        ]);

        $newId = (string) Str::uuid();

        $this->columns[] = [
            'id' => $newId,
            'name' => $this->newActivityTitle,
            'type' => $this->newActivityType,
            'max' => $this->newActivityMax,
        ];

        // Initialize score for this new column for all students
        foreach ($this->students as $index => $student) {
            $this->students[$index]['scores'][$newId] = 0;
        }

        $this->showAddModal = false;
        $this->calculateGrades();
        $this->persist();
    }

    public function persist()
    {
        if ($this->showData) {
            session()->put('grading_sheet_data', [
                'columns' => $this->columns,
                'students' => $this->students,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.teacher.grading.grading-sheet')
            ->layout('layouts.app', ['header' => 'Grading Sheet']);
    }
}
