<?php

namespace App\Livewire\Registrar;

use Livewire\Component;

class EnrollmentWizard extends Component
{
    public $step = 1;

    // Step 1: Identity
    public $studentName;
    public $lrn;
    public $parentName;
    public $parentEmail;

    // Step 2: Academic
    public $gradeLevel;
    public $section;

    // Step 3: Billing
    public $downpayment;
    public $paymentPlan;

    public function nextStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'studentName' => 'required',
                'lrn' => 'required',
                'parentName' => 'required',
                'parentEmail' => 'required|email',
            ]);
        } elseif ($this->step === 2) {
            $this->validate([
                'gradeLevel' => 'required',
                'section' => 'required',
            ]);
        }

        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function confirmEnrollment()
    {
        $this->validate([
            'downpayment' => 'required|numeric',
            'paymentPlan' => 'required',
        ]);

        // Simulate Saving
        session()->flash('message', 'Enrollment Successful');

        $this->reset();
        $this->step = 1;
    }

    public function render()
    {
        return view('livewire.registrar.enrollment-wizard')
            ->layout('layouts.app', ['header' => 'Enrollment Wizard']);
    }
}
