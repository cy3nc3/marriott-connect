<?php

namespace App\Livewire\Admin\Curriculum;

use Livewire\Component;

class CurriculumManager extends Component
{
    // State
    public $gradeLevel = 7; // Default
    public $subjects = [];

    // Form
    public $subjectCode = '';
    public $subjectName = '';
    public $hoursPerWeek = 4;
    public $isEditing = false;
    public $editingId = null;

    public function mount()
    {
        // Initialize Mock Data
        if (!session()->has('curriculum')) {
            $initialData = $this->getMockCurriculum();
            session()->put('curriculum', $initialData);
        }
        $this->loadSubjects();
    }

    public function updatedGradeLevel()
    {
        $this->loadSubjects();
    }

    public function loadSubjects()
    {
        $allSubjects = session('curriculum', []);
        $this->subjects = array_filter($allSubjects, fn($s) => $s['grade_level'] == $this->gradeLevel);
    }

    public function saveSubject()
    {
        $this->validate([
            'subjectCode' => 'required',
            'subjectName' => 'required',
            'hoursPerWeek' => 'required|numeric|min:1',
        ]);

        $allSubjects = session('curriculum', []);

        if ($this->isEditing) {
            foreach ($allSubjects as &$subject) {
                if ($subject['id'] == $this->editingId) {
                    $subject['code'] = $this->subjectCode;
                    $subject['name'] = $this->subjectName;
                    $subject['hours'] = $this->hoursPerWeek;
                    break;
                }
            }
        } else {
            $newId = count($allSubjects) + 1;
            $allSubjects[] = [
                'id' => $newId,
                'code' => $this->subjectCode,
                'name' => $this->subjectName,
                'grade_level' => $this->gradeLevel,
                'hours' => $this->hoursPerWeek
            ];
        }

        session()->put('curriculum', $allSubjects);
        $this->resetForm();
        $this->loadSubjects();
        session()->flash('message', 'Subject saved successfully.');
    }

    public function editSubject($id)
    {
        $subject = collect($this->subjects)->firstWhere('id', $id);
        if ($subject) {
            $this->subjectCode = $subject['code'];
            $this->subjectName = $subject['name'];
            $this->hoursPerWeek = $subject['hours'];
            $this->editingId = $id;
            $this->isEditing = true;
        }
    }

    public function deleteSubject($id)
    {
        $allSubjects = session('curriculum', []);
        $allSubjects = array_filter($allSubjects, fn($s) => $s['id'] != $id);
        session()->put('curriculum', $allSubjects);
        $this->loadSubjects();
    }

    public function resetForm()
    {
        $this->subjectCode = '';
        $this->subjectName = '';
        $this->hoursPerWeek = 4;
        $this->isEditing = false;
        $this->editingId = null;
    }

    private function getMockCurriculum()
    {
        $id = 1;
        return [
            ['id' => $id++, 'code' => 'MATH7', 'name' => 'Mathematics 7', 'grade_level' => 7, 'hours' => 4],
            ['id' => $id++, 'code' => 'SCI7', 'name' => 'Science 7', 'grade_level' => 7, 'hours' => 4],
            ['id' => $id++, 'code' => 'ENG7', 'name' => 'English 7', 'grade_level' => 7, 'hours' => 4],
            ['id' => $id++, 'code' => 'FIL7', 'name' => 'Filipino 7', 'grade_level' => 7, 'hours' => 4],
            ['id' => $id++, 'code' => 'AP7', 'name' => 'Araling Panlipunan 7', 'grade_level' => 7, 'hours' => 3],
            ['id' => $id++, 'code' => 'TLE7', 'name' => 'Technology and Livelihood Education 7', 'grade_level' => 7, 'hours' => 3],
            ['id' => $id++, 'code' => 'MAPEH7', 'name' => 'Music, Arts, PE, Health 7', 'grade_level' => 7, 'hours' => 3],
            ['id' => $id++, 'code' => 'ESP7', 'name' => 'Edukasyon sa Pagpapakatao 7', 'grade_level' => 7, 'hours' => 3],

            ['id' => $id++, 'code' => 'MATH8', 'name' => 'Mathematics 8', 'grade_level' => 8, 'hours' => 4],
            ['id' => $id++, 'code' => 'SCI8', 'name' => 'Science 8', 'grade_level' => 8, 'hours' => 4],
            ['id' => $id++, 'code' => 'ENG8', 'name' => 'English 8', 'grade_level' => 8, 'hours' => 4],
            ['id' => $id++, 'code' => 'FIL8', 'name' => 'Filipino 8', 'grade_level' => 8, 'hours' => 4],
            ['id' => $id++, 'code' => 'AP8', 'name' => 'Araling Panlipunan 8', 'grade_level' => 8, 'hours' => 3],
            ['id' => $id++, 'code' => 'TLE8', 'name' => 'Technology and Livelihood Education 8', 'grade_level' => 8, 'hours' => 3],
        ];
    }

    public function render()
    {
        return view('livewire.admin.curriculum.curriculum-manager')
            ->layout('layouts.app', ['header' => 'Curriculum Manager']);
    }
}
