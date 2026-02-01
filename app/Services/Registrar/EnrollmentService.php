<?php

namespace App\Services\Registrar;

class EnrollmentService
{
    /**
     * Calculate the discount amount based on tuition fee and discount type.
     */
    public function calculateDiscount(float $tuitionFee, string $discountType): float
    {
        return match ($discountType) {
            'Sibling Discount' => $tuitionFee * 0.10, // 10% off Tuition
            'Academic Scholar' => $tuitionFee * 1.00, // 100% off Tuition
            'Employee Dependent' => $tuitionFee * 0.50, // 50% off Tuition
            default => 0.0,
        };
    }

    /**
     * Calculate total assessment.
     */
    public function calculateTotalAssessment(float $tuitionFee, float $miscFee, float $discountAmount): float
    {
        return ($tuitionFee + $miscFee) - $discountAmount;
    }

    /**
     * Persist enrollment data.
     */
    public function processEnrollment(array $data): void
    {
        // Add date
        $data['date'] = now()->format('F j, Y');

        // Simulate Saving to DB
        // In real app: Student::create($data); Enrollment::create($data);

        // Store for Print (Session)
        session()->put('enrollment_details', $data);
    }
}
