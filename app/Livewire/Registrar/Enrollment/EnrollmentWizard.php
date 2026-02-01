<?php

namespace App\Livewire\Registrar\Enrollment;

use Livewire\Component;
use App\Services\Registrar\EnrollmentService;

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

    public function updatedDiscountType(EnrollmentService $service)
    {
        $this->calculateFees($service);
    }

    public function calculateFees(EnrollmentService $service)
    {
        $this->discountAmount = $service->calculateDiscount($this->tuitionFee, $this->discountType);
        $this->totalAssessment = $service->calculateTotalAssessment($this->tuitionFee, $this->miscFee, $this->discountAmount);
    }

    public function confirmEnrollment(EnrollmentService $service)
    {
        $this->validate([
            'downpayment' => 'required|numeric',
            'paymentPlan' => 'required',
        ]);

        // Ensure fees are up to date
        $this->calculateFees($service);

        // Prepare Data
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
        ];

        // Delegate to Service
        $service->processEnrollment($enrollmentData);

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
        return view('livewire.registrar.enrollment.enrollment-wizard')
            ->layout('layouts.app', ['header' => 'Enrollment Wizard']);
    }
}
