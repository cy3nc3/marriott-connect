<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class CurriculumManager extends Component
{
    public $subjects = [];

    // Form Properties
    public $code = '';
    public $name = '';
    public $grade_level = 7;
    public $hours = 3;

    // State Management
    public $isEditMode = false;
    public $editingId = null;

    public function mount()
    {
        $this->subjects = $this->getInitialSubjects();
    }

    private function getInitialSubjects()
    {
        $data = [];
        $id = 1;

        // Grade 7
        $data = array_merge($data, [
            ['id' => $id++, 'code' => 'MATH7', 'name' => 'Mathematics 7', 'grade_level' => 7, 'hours' => 4],
            ['id' => $id++, 'code' => 'SCI7', 'name' => 'Science 7', 'grade_level' => 7, 'hours' => 4],
            ['id' => $id++, 'code' => 'ENG7', 'name' => 'English 7', 'grade_level' => 7, 'hours' => 4],
            ['id' => $id++, 'code' => 'FIL7', 'name' => 'Filipino 7', 'grade_level' => 7, 'hours' => 4],
            ['id' => $id++, 'code' => 'AP7', 'name' => 'Araling Panlipunan 7', 'grade_level' => 7, 'hours' => 3],
            ['id' => $id++, 'code' => 'TLE7', 'name' => 'Technology and Livelihood Education 7', 'grade_level' => 7, 'hours' => 3],
            ['id' => $id++, 'code' => 'MAPEH7', 'name' => 'MAPEH 7', 'grade_level' => 7, 'hours' => 3],
            ['id' => $id++, 'code' => 'ESP7', 'name' => 'Edukasyon sa Pagpapakatao 7', 'grade_level' => 7, 'hours' => 3],
        ]);

        // Grade 8
        $data = array_merge($data, [
            ['id' => $id++, 'code' => 'MATH8', 'name' => 'Mathematics 8', 'grade_level' => 8, 'hours' => 4],
            ['id' => $id++, 'code' => 'SCI8', 'name' => 'Science 8', 'grade_level' => 8, 'hours' => 4],
            ['id' => $id++, 'code' => 'ENG8', 'name' => 'English 8', 'grade_level' => 8, 'hours' => 4],
            ['id' => $id++, 'code' => 'FIL8', 'name' => 'Filipino 8', 'grade_level' => 8, 'hours' => 4],
            ['id' => $id++, 'code' => 'AP8', 'name' => 'Araling Panlipunan 8', 'grade_level' => 8, 'hours' => 3],
            ['id' => $id++, 'code' => 'TLE8', 'name' => 'Technology and Livelihood Education 8', 'grade_level' => 8, 'hours' => 3],
            ['id' => $id++, 'code' => 'MAPEH8', 'name' => 'MAPEH 8', 'grade_level' => 8, 'hours' => 3],
            ['id' => $id++, 'code' => 'ESP8', 'name' => 'Edukasyon sa Pagpapakatao 8', 'grade_level' => 8, 'hours' => 3],
        ]);

        // Grade 9
        $data = array_merge($data, [
            ['id' => $id++, 'code' => 'MATH9', 'name' => 'Mathematics 9', 'grade_level' => 9, 'hours' => 4],
            ['id' => $id++, 'code' => 'SCI9', 'name' => 'Science 9', 'grade_level' => 9, 'hours' => 4],
            ['id' => $id++, 'code' => 'ENG9', 'name' => 'English 9', 'grade_level' => 9, 'hours' => 4],
            ['id' => $id++, 'code' => 'FIL9', 'name' => 'Filipino 9', 'grade_level' => 9, 'hours' => 4],
            ['id' => $id++, 'code' => 'AP9', 'name' => 'Araling Panlipunan 9', 'grade_level' => 9, 'hours' => 3],
            ['id' => $id++, 'code' => 'TLE9', 'name' => 'Technology and Livelihood Education 9', 'grade_level' => 9, 'hours' => 3],
            ['id' => $id++, 'code' => 'MAPEH9', 'name' => 'MAPEH 9', 'grade_level' => 9, 'hours' => 3],
            ['id' => $id++, 'code' => 'ESP9', 'name' => 'Edukasyon sa Pagpapakatao 9', 'grade_level' => 9, 'hours' => 3],
        ]);

        // Grade 10
        $data = array_merge($data, [
            ['id' => $id++, 'code' => 'MATH10', 'name' => 'Mathematics 10', 'grade_level' => 10, 'hours' => 4],
            ['id' => $id++, 'code' => 'SCI10', 'name' => 'Science 10', 'grade_level' => 10, 'hours' => 4],
            ['id' => $id++, 'code' => 'ENG10', 'name' => 'English 10', 'grade_level' => 10, 'hours' => 4],
            ['id' => $id++, 'code' => 'FIL10', 'name' => 'Filipino 10', 'grade_level' => 10, 'hours' => 4],
            ['id' => $id++, 'code' => 'AP10', 'name' => 'Araling Panlipunan 10', 'grade_level' => 10, 'hours' => 3],
            ['id' => $id++, 'code' => 'TLE10', 'name' => 'Technology and Livelihood Education 10', 'grade_level' => 10, 'hours' => 3],
            ['id' => $id++, 'code' => 'MAPEH10', 'name' => 'MAPEH 10', 'grade_level' => 10, 'hours' => 3],
            ['id' => $id++, 'code' => 'ESP10', 'name' => 'Edukasyon sa Pagpapakatao 10', 'grade_level' => 10, 'hours' => 3],
            ['id' => $id++, 'code' => 'RES1', 'name' => 'Research I', 'grade_level' => 10, 'hours' => 3],
        ]);

        return $data;
    }

    public function openModal($gradeLevel = null)
    {
        $this->resetForm();
        if ($gradeLevel) {
            $this->grade_level = $gradeLevel;
        }
        $this->dispatch('open-modal-window');
    }

    public function editSubject($id)
    {
        $subject = collect($this->subjects)->firstWhere('id', $id);

        if ($subject) {
            $this->editingId = $id;
            $this->code = $subject['code'];
            $this->name = $subject['name'];
            $this->grade_level = $subject['grade_level'];
            $this->hours = $subject['hours'];
            $this->isEditMode = true;

            $this->dispatch('open-modal-window');
        }
    }

    public function saveSubject()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'grade_level' => 'required|in:7,8,9,10',
            'hours' => 'required|numeric|min:1',
        ]);

        if ($this->isEditMode) {
            // Update
            foreach ($this->subjects as &$subject) {
                if ($subject['id'] == $this->editingId) {
                    $subject['code'] = $this->code;
                    $subject['name'] = $this->name;
                    $subject['grade_level'] = $this->grade_level;
                    $subject['hours'] = $this->hours;
                    break;
                }
            }
            session()->flash('message', 'Subject updated successfully.');
        } else {
            // Create
            $this->subjects[] = [
                'id' => count($this->subjects) + 1, // Simple ID generation
                'code' => $this->code,
                'name' => $this->name,
                'grade_level' => $this->grade_level,
                'hours' => $this->hours,
            ];
            session()->flash('message', 'Subject added successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function deleteSubject($id)
    {
        $this->subjects = collect($this->subjects)->reject(function ($subject) use ($id) {
            return $subject['id'] == $id;
        })->values()->all();

        session()->flash('message', 'Subject deleted successfully.');
    }

    public function resetForm()
    {
        $this->reset(['code', 'name', 'grade_level', 'hours', 'isEditMode', 'editingId']);
        $this->grade_level = 7; // Default reset
        $this->hours = 3;
    }

    public function render()
    {
        return view('livewire.admin.curriculum-manager')
            ->layout('layouts.app', ['header' => 'Junior High School Curriculum']);
    }
}
