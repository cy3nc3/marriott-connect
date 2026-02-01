<?php

namespace App\Livewire\Admin\Curriculum;

use Livewire\Component;

class SectionManager extends Component
{
    // Data Storage
    public $sections = [];

    public $teachers = [
        'Mr. Juan Cruz',
        'Ms. Maria Santos',
        'Mrs. Lorna Reyes',
        'Mr. Pedro Dizon',
        'Ms. Anna Lee',
    ];

    // Filter
    public $filterGrade = 'All';

    // Form Properties
    public $sectionId = null;
    public $name = '';
    public $grade_level = 7;
    public $adviser = '';
    public $capacity = 40;

    // State
    public $isEditing = false;

    public function mount()
    {
        // Initialize default data if session is empty
        $defaultSections = [
            ['id' => 1, 'name' => 'Rizal', 'grade_level' => 7, 'adviser' => 'Mr. Juan Cruz', 'capacity' => 40],
            ['id' => 2, 'name' => 'Bonifacio', 'grade_level' => 7, 'adviser' => 'Ms. Maria Santos', 'capacity' => 42],
            ['id' => 3, 'name' => 'Emerald', 'grade_level' => 8, 'adviser' => 'Mrs. Lorna Reyes', 'capacity' => 38],
            ['id' => 4, 'name' => 'Ruby', 'grade_level' => 8, 'adviser' => 'Mr. Pedro Dizon', 'capacity' => 40],
            ['id' => 5, 'name' => 'Newton', 'grade_level' => 9, 'adviser' => 'Ms. Anna Lee', 'capacity' => 45],
            ['id' => 6, 'name' => 'Einstein', 'grade_level' => 9, 'adviser' => 'Mr. Juan Cruz', 'capacity' => 45],
            ['id' => 7, 'name' => 'Apollo', 'grade_level' => 10, 'adviser' => 'Mrs. Lorna Reyes', 'capacity' => 40],
            ['id' => 8, 'name' => 'Athena', 'grade_level' => 10, 'adviser' => 'Ms. Maria Santos', 'capacity' => 40],
        ];

        // Load from session or use default
        $this->sections = session()->get('sections', $defaultSections);

        // Initialize default adviser
        $this->adviser = $this->teachers[0];
    }

    public function updatedGradeLevel()
    {
        // Optional: Filter advisers based on expertise?
        // For now, keep it simple.
    }

    public function createMode()
    {
        $this->resetForm();
        $this->dispatch('open-modal');
    }

    public function saveSection()
    {
        $this->validate([
            'name' => 'required',
            'grade_level' => 'required',
            'adviser' => 'required',
            'capacity' => 'required|numeric|min:1',
        ]);

        if ($this->isEditing) {
            // Update
            foreach ($this->sections as &$section) {
                if ($section['id'] == $this->sectionId) {
                    $section['name'] = $this->name;
                    $section['grade_level'] = $this->grade_level;
                    $section['adviser'] = $this->adviser;
                    $section['capacity'] = $this->capacity;
                    break;
                }
            }
            session()->flash('message', 'Section updated successfully.');
        } else {
            // Create
            $newId = empty($this->sections) ? 1 : max(array_column($this->sections, 'id')) + 1;
            $this->sections[] = [
                'id' => $newId,
                'name' => $this->name,
                'grade_level' => $this->grade_level,
                'adviser' => $this->adviser,
                'capacity' => $this->capacity,
            ];
            session()->flash('message', 'Section created successfully.');
        }

        session()->put('sections', $this->sections);
        $this->dispatch('close-modal');
        $this->resetForm();
    }

    public function editSection($id)
    {
        $section = collect($this->sections)->firstWhere('id', $id);
        if ($section) {
            $this->sectionId = $section['id'];
            $this->name = $section['name'];
            $this->grade_level = $section['grade_level'];
            $this->adviser = $section['adviser'];
            $this->capacity = $section['capacity'];
            $this->isEditing = true;
            $this->dispatch('open-modal');
        }
    }

    public function deleteSection($id)
    {
        $this->sections = array_filter($this->sections, fn($s) => $s['id'] != $id);
        session()->put('sections', $this->sections);
        session()->flash('message', 'Section deleted.');
    }

    public function resetForm()
    {
        $this->sectionId = null;
        $this->name = '';
        $this->grade_level = 7;
        $this->adviser = $this->teachers[0];
        $this->capacity = 40;
        $this->isEditing = false;
    }

    public function render()
    {
        $displaySections = $this->sections;

        if ($this->filterGrade != 'All') {
            $displaySections = array_filter($displaySections, fn($s) => $s['grade_level'] == $this->filterGrade);
        }

        // Sort by Grade Level then Name
        usort($displaySections, function ($a, $b) {
            if ($a['grade_level'] == $b['grade_level']) {
                return strcmp($a['name'], $b['name']);
            }
            return $a['grade_level'] - $b['grade_level'];
        });

        return view('livewire.admin.curriculum.section-manager', [
            'filteredSections' => $displaySections
        ])->layout('layouts.app', ['header' => 'Section Manager']);
    }
}
