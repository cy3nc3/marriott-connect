<?php

namespace App\Livewire\Admin;

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
        return view('livewire.admin.report-preview');
    }
}
