<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use Carbon\Carbon;

class SchoolYearManager extends Component
{
    public $school_years = [];

    // Modal State
    public $showModal = false;
    public $isEditing = false;
    public $editingId = null;

    // Form Data
    public $form = [
        'name' => '',
        'start_date' => '',
        'end_date' => '',
    ];

    public function mount()
    {
        // Initialize Hardcoded Data
        $this->school_years = [
            [
                'id' => 1,
                'name' => '2024-2025',
                'start_date' => '2024-08-01',
                'end_date' => '2025-05-31',
                'status' => 'inactive', // active or inactive
                'quarter' => null,
                'admissions_open' => false,
            ],
            [
                'id' => 2,
                'name' => '2025-2026',
                'start_date' => '2025-08-01',
                'end_date' => '2026-05-31',
                'status' => 'active',
                'quarter' => '3',
                'admissions_open' => false,
            ],
            [
                'id' => 3,
                'name' => '2026-2027',
                'start_date' => '2026-08-01',
                'end_date' => '2027-05-31',
                'status' => 'inactive',
                'quarter' => '1',
                'admissions_open' => true,
            ],
        ];
    }

    public function setActiveYear($id)
    {
        foreach ($this->school_years as &$year) {
            if ($year['id'] == $id) {
                $year['status'] = 'active';
                // Default to Q1 if no quarter is set when making active
                if (empty($year['quarter'])) {
                    $year['quarter'] = '1';
                }
            } else {
                $year['status'] = 'inactive';
            }
        }
    }

    public function updateQuarter($id, $value)
    {
        foreach ($this->school_years as &$year) {
            if ($year['id'] == $id) {
                $year['quarter'] = $value;
                break;
            }
        }
    }

    public function toggleAdmissions($id)
    {
        foreach ($this->school_years as &$year) {
            if ($year['id'] == $id) {
                $year['admissions_open'] = !$year['admissions_open'];
                break;
            }
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $year = collect($this->school_years)->firstWhere('id', $id);
        if ($year) {
            $this->form = [
                'name' => $year['name'],
                'start_date' => $year['start_date'],
                'end_date' => $year['end_date'],
            ];
            $this->editingId = $id;
            $this->isEditing = true;
            $this->showModal = true;
        }
    }

    public function save()
    {
        $this->validate([
            'form.name' => 'required|string',
            'form.start_date' => 'required|date',
            'form.end_date' => 'required|date|after:form.start_date',
        ]);

        if ($this->isEditing) {
            // Update existing
            foreach ($this->school_years as &$year) {
                if ($year['id'] == $this->editingId) {
                    $year['name'] = $this->form['name'];
                    $year['start_date'] = $this->form['start_date'];
                    $year['end_date'] = $this->form['end_date'];
                    break;
                }
            }
            session()->flash('message', 'School year updated successfully.');
        } else {
            // Create new
            $newId = collect($this->school_years)->max('id') + 1;
            $this->school_years[] = [
                'id' => $newId,
                'name' => $this->form['name'],
                'start_date' => $this->form['start_date'],
                'end_date' => $this->form['end_date'],
                'status' => 'inactive',
                'quarter' => '1',
                'admissions_open' => false,
            ];
            session()->flash('message', 'School year created successfully.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        $this->school_years = collect($this->school_years)
            ->reject(function ($year) use ($id) {
                return $year['id'] == $id;
            })
            ->values()
            ->toArray();

        session()->flash('message', 'School year deleted successfully.');
    }

    private function resetForm()
    {
        $this->form = [
            'name' => '',
            'start_date' => '',
            'end_date' => '',
        ];
        $this->editingId = null;
    }

    public function formatDateRange($start, $end)
    {
        $startDate = Carbon::parse($start);
        $endDate = Carbon::parse($end);

        return $startDate->format('M Y') . ' - ' . $endDate->format('M Y');
    }

    public function render()
    {
        return view('livewire.super-admin.school-year-manager')
            ->layout('layouts.app', ['header' => 'Academic Calendar Management']);
    }
}
