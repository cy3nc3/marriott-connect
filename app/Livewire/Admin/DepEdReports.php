<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DepEdReports extends Component
{
    // SF1 Filters
    public $sf1_grade = '7';
    public $sf1_section = 'A';

    // SF5 Filters
    public $sf5_grade = '7';
    public $sf5_section = 'A';

    // SF10 Filters
    public $sf10_student = '';

    public function render()
    {
        return view('livewire.admin.dep-ed-reports');
    }

    public function generateSf1()
    {
        return redirect()->route('admin.reports.preview', [
            'type' => 'SF1',
            'grade' => $this->sf1_grade,
            'section' => $this->sf1_section
        ]);
    }

    public function generateSf5()
    {
        return redirect()->route('admin.reports.preview', [
            'type' => 'SF5',
            'grade' => $this->sf5_grade,
            'section' => $this->sf5_section
        ]);
    }

    public function generateSf10()
    {
        return redirect()->route('admin.reports.preview', [
            'type' => 'SF10',
            'student' => $this->sf10_student
        ]);
    }
}
