<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;

class SchoolYearManager extends Component
{
    public $data = [
        'school_year' => '2024-2025',
        'quarter' => '1',
        'enrollment_open' => false,
        'target_enrollment_year' => '2025-2026',
    ];

    public function updateStatus()
    {
        dd('updated');
    }

    public function saveSettings()
    {
        session()->flash('message', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.super-admin.school-year-manager')
            ->layout('layouts.app', ['header' => 'School Year Manager']);
    }
}
