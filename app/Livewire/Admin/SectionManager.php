<?php

namespace App\Livewire\Admin;

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

    public function getFilteredSectionsProperty()
    {
        if ($this->filterGrade === 'All') {
            return $this->sections;
        }

        return array_filter($this->sections, function ($section) {
            return $section['grade_level'] == $this->filterGrade;
        });
    }

    public function createMode()
    {
        $this->resetInputFields();
        $this->dispatch('open-modal');
    }

    public function editSection($id)
    {
        $this->isEditing = true;
        $this->sectionId = $id;

        // Find section data
        $section = collect($this->sections)->firstWhere('id', $id);

        if ($section) {
            $this->name = $section['name'];
            $this->grade_level = $section['grade_level'];
            $this->adviser = $section['adviser'];
            $this->capacity = $section['capacity'];

            $this->dispatch('open-modal');
        }
    }

    public function saveSection()
    {
        $this->validate([
            'name' => 'required',
            'grade_level' => 'required|in:7,8,9,10',
            'adviser' => 'required',
            'capacity' => 'required|integer|min:1',
        ]);

        if ($this->isEditing) {
            // Update existing
            foreach ($this->sections as $key => $section) {
                if ($section['id'] == $this->sectionId) {
                    $this->sections[$key] = [
                        'id' => $this->sectionId,
                        'name' => $this->name,
                        'grade_level' => $this->grade_level,
                        'adviser' => $this->adviser,
                        'capacity' => $this->capacity,
                    ];
                    break;
                }
            }
            session()->flash('message', 'Section updated successfully.');
        } else {
            // Create new
            $newId = count($this->sections) > 0 ? max(array_column($this->sections, 'id')) + 1 : 1;

            $this->sections[] = [
                'id' => $newId,
                'name' => $this->name,
                'grade_level' => $this->grade_level,
                'adviser' => $this->adviser,
                'capacity' => $this->capacity,
            ];
            session()->flash('message', 'Section created successfully.');
        }

        // Save to session
        session()->put('sections', $this->sections);

        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function deleteSection($id)
    {
        $this->sections = array_filter($this->sections, function($section) use ($id) {
            return $section['id'] != $id;
        });

        // Re-index array
        $this->sections = array_values($this->sections);

        // Save to session
        session()->put('sections', $this->sections);

        session()->flash('message', 'Section deleted successfully.');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->grade_level = 7;
        $this->adviser = $this->teachers[0];
        $this->capacity = 40;
        $this->sectionId = null;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.admin.section-manager', [
            'filteredSections' => $this->filteredSections,
        ])
        ->layout('layouts.app', ['header' => 'Section Manager']);
    }
}
