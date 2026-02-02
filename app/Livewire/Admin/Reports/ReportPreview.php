<?php

namespace App\Livewire\Admin\Reports;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ReportPreview extends Component
{
    public $type;
    public $grade;
    public $section;
    public $student;

    public function mount()
    {
        $this->type = request('type');
        $this->grade = request('grade');
        $this->section = request('section');
        $this->student = request('student');
    }

    public function render()
    {
        return view('livewire.admin.reports.report-preview')
            ->layout('layouts.app', ['header' => 'Report Preview']);
    }
}
