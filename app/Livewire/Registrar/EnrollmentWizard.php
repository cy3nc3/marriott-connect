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

    // Billing Details
    public $tuitionFee = 20000;
    public $miscFee = 5000;
    public $discountType = 'None';
    public $discountAmount = 0;
    public $totalAssessment = 25000;

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

    public function updatedDiscountType()
    {
        $this->calculateFees();
    }

    public function calculateFees()
    {
        // Reset base
        $this->discountAmount = 0;

        switch ($this->discountType) {
            case 'Sibling Discount':
                $this->discountAmount = $this->tuitionFee * 0.10; // 10% off Tuition
                break;
            case 'Academic Scholar':
                $this->discountAmount = $this->tuitionFee * 1.00; // 100% off Tuition
                break;
            case 'Employee Dependent':
                $this->discountAmount = $this->tuitionFee * 0.50; // 50% off Tuition
                break;
            default:
                $this->discountAmount = 0;
                break;
        }

        $this->totalAssessment = ($this->tuitionFee + $this->miscFee) - $this->discountAmount;
    }

    public function confirmEnrollment()
    {
        $this->validate([
            'downpayment' => 'required|numeric',
            'paymentPlan' => 'required',
        ]);

        // Ensure fees are up to date
        $this->calculateFees();

        // Simulate Saving & Store for Print
        $enrollmentData = [
            'studentName' => $this->studentName,
            'lrn' => $this->lrn,
            'gradeLevel' => $this->gradeLevel,
            'section' => $this->section,
            'tuitionFee' => $this->tuitionFee,
            'miscFee' => $this->miscFee,
            'discountType' => $this->discountType,
            'discountAmount' => $this->discountAmount,
            'totalAssessment' => $this->totalAssessment,
            'paymentPlan' => $this->paymentPlan,
            'date' => now()->format('F j, Y'),
        ];

        session()->put('enrollment_details', $enrollmentData);
        session()->flash('message', 'Enrollment Successful');

        // Move to Success Step
        $this->step = 4;
    }

    public function enrollNext()
    {
        $this->reset();
        $this->step = 1;
        // Re-initialize default values if needed (though reset() handles public props)
        $this->tuitionFee = 20000;
        $this->miscFee = 5000;
        $this->discountType = 'None';
        $this->discountAmount = 0;
        $this->totalAssessment = 25000;
    }

    public function render()
    {
        return view('livewire.registrar.enrollment-wizard')
            ->layout('layouts.app', ['header' => 'Enrollment Wizard']);
    }
}
