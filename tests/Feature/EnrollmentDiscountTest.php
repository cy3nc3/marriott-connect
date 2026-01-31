<?php

namespace Tests\Feature;

use App\Livewire\Registrar\EnrollmentWizard;
use Livewire\Livewire;
use Tests\TestCase;

class EnrollmentDiscountTest extends TestCase
{
    /** @test */
    public function it_calculates_discounts_correctly()
    {
        Livewire::test(EnrollmentWizard::class)
            // Initial State
            ->assertSet('tuitionFee', 20000)
            ->assertSet('miscFee', 5000)
            ->assertSet('totalAssessment', 25000)

            // Sibling Discount (10%)
            ->set('discountType', 'Sibling Discount')
            ->assertSet('discountAmount', 2000) // 10% of 20000
            ->assertSet('totalAssessment', 23000) // 25000 - 2000

            // Academic Scholar (100%)
            ->set('discountType', 'Academic Scholar')
            ->assertSet('discountAmount', 20000)
            ->assertSet('totalAssessment', 5000) // 25000 - 20000 = 5000 (Misc only)

            // Employee Dependent (50%)
            ->set('discountType', 'Employee Dependent')
            ->assertSet('discountAmount', 10000)
            ->assertSet('totalAssessment', 15000) // 25000 - 10000

            // None
            ->set('discountType', 'None')
            ->assertSet('discountAmount', 0)
            ->assertSet('totalAssessment', 25000);
    }

    /** @test */
    public function it_stores_enrollment_data_in_session_on_confirm()
    {
        Livewire::test(EnrollmentWizard::class)
            ->set('step', 3)
            ->set('studentName', 'Test Student')
            ->set('lrn', '123456789012')
            ->set('gradeLevel', '7')
            ->set('section', 'A')
            ->set('downpayment', 5000)
            ->set('paymentPlan', 'Cash')
            ->set('discountType', 'Sibling Discount') // 2000 discount
            ->call('confirmEnrollment')
            ->assertSet('step', 4)
            ->assertSessionHas('enrollment_details', function ($data) {
                // dump($data);
                return $data['studentName'] === 'Test Student'
                    && $data['discountType'] === 'Sibling Discount'
                    && (int)$data['discountAmount'] === 2000
                    && (int)$data['totalAssessment'] === 23000;
            });
    }
}
