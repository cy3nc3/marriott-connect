<?php

namespace App\Livewire\Finance\Fees;

use Livewire\Component;

class DiscountManager extends Component
{
    // Mock Discount Types
    public $discounts = [
        ['id' => 1, 'name' => 'Sibling Discount', 'type' => 'Percentage', 'value' => '10%'],
        ['id' => 2, 'name' => 'Academic Scholar', 'type' => 'Percentage', 'value' => '100%'],
        ['id' => 3, 'name' => 'ESC Voucher', 'type' => 'Fixed', 'value' => '₱ 9,000.00'],
    ];

    // Scholars List
    public $scholars = [
        ['id' => 101, 'name' => 'Ana Lee', 'grade' => 'Grade 7', 'discount' => 'Sibling Discount', 'deducted' => 3000.00],
        ['id' => 102, 'name' => 'Jose Rizal', 'grade' => 'Grade 10', 'discount' => 'Academic Scholar', 'deducted' => 30000.00],
    ];

    // Form Properties (Create Discount)
    public $newDiscountName;
    public $newDiscountType = 'Percentage';
    public $newDiscountValue;

    // Form Properties (Tag Student)
    public $tagStudentName;
    public $tagDiscountId;

    public function createDiscount()
    {
        $this->validate([
            'newDiscountName' => 'required',
            'newDiscountValue' => 'required',
        ]);

        $valueDisplay = $this->newDiscountType === 'Percentage' ? $this->newDiscountValue . '%' : '₱ ' . number_format((float)$this->newDiscountValue, 2);

        $this->discounts[] = [
            'id' => count($this->discounts) + 1,
            'name' => $this->newDiscountName,
            'type' => $this->newDiscountType,
            'value' => $valueDisplay,
        ];

        $this->reset(['newDiscountName', 'newDiscountType', 'newDiscountValue']);
        $this->dispatch('close-discount-modal');
        session()->flash('message', 'Discount type created.');
    }

    public function tagStudent()
    {
        $this->validate([
            'tagStudentName' => 'required',
            'tagDiscountId' => 'required',
        ]);

        $selectedDiscount = collect($this->discounts)->firstWhere('id', $this->tagDiscountId);

        $this->scholars[] = [
            'id' => count($this->scholars) + 100,
            'name' => $this->tagStudentName,
            'grade' => 'Grade 7', // Default for mock
            'discount' => $selectedDiscount['name'],
            'deducted' => 0.00, // Mock calculation
        ];

        $this->reset(['tagStudentName', 'tagDiscountId']);
        $this->dispatch('close-tag-modal');
        session()->flash('message', 'Student tagged successfully.');
    }

    public function render()
    {
        return view('livewire.finance.fees.discount-manager')
            ->layout('layouts.app', ['header' => 'Scholarship & Discounts']);
    }
}
