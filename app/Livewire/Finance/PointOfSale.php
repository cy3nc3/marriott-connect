<?php

namespace App\Livewire\Finance;

use Livewire\Component;

class PointOfSale extends Component
{
    // Inventory Products
    public $products = [
        ['name' => 'Math Textbook 7', 'type' => 'Book', 'price' => 550.00],
        ['name' => 'PE Uniform (M)', 'type' => 'Uniform', 'price' => 350.00],
        ['name' => 'School ID Lace', 'type' => 'Stationery', 'price' => 50.00],
        ['name' => 'Notebook', 'type' => 'Stationery', 'price' => 25.00],
    ];

    // Fake Students with Unpaid Bills
    public $students = [
        [
            'id' => 1,
            'name' => 'Juan Cruz',
            'lrn' => '123456789012',
            'unpaid_bills' => [
                ['id' => 101, 'description' => 'Aug Tuition', 'amount' => 3000.00],
                ['id' => 102, 'description' => 'Sep Tuition', 'amount' => 3000.00],
                ['id' => 103, 'description' => 'Books Fee', 'amount' => 5000.00]
            ]
        ],
        [
            'id' => 2,
            'name' => 'Maria Santos',
            'lrn' => '987654321098',
            'unpaid_bills' => [
                ['id' => 201, 'description' => 'Sep Tuition', 'amount' => 3000.00]
            ]
        ]
    ];

    // Search & Selection
    public $search = '';
    public $selectedStudent = null;

    // Cart & Transaction
    public $cart = [];
    public $orNumber;
    public $paymentMode = 'Cash';
    public $remarks;
    public $cashTendered = 0;

    public function updatedSearch()
    {
        $this->selectedStudent = null; // Reset selection on new search
    }

    public function selectStudent($id)
    {
        $this->selectedStudent = collect($this->students)->firstWhere('id', $id);
        $this->search = $this->selectedStudent['name'];
    }

    public function addToCart($name, $price)
    {
        $this->cart[] = [
            'name' => $name,
            'price' => (float) $price,
        ];
    }

    public function removeItem($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart); // Re-index array
    }

    public function getTotalProperty()
    {
        return array_sum(array_column($this->cart, 'price'));
    }

    public function getChangeProperty()
    {
        return (float) $this->cashTendered - $this->getTotalProperty();
    }

    public function processPayment()
    {
        $this->validate([
            'orNumber' => 'nullable|string', // Optional as per request
            'paymentMode' => 'required',
            'cart' => 'required|array|min:1',
        ]);

        if ($this->paymentMode === 'Cash' && $this->getChangeProperty() < 0) {
            $this->addError('cashTendered', 'Insufficient cash.');
            return;
        }

        // Simulate Transaction Saving
        // ...

        $this->reset(['cart', 'search', 'selectedStudent', 'orNumber', 'remarks', 'cashTendered']);
        $this->paymentMode = 'Cash';

        session()->flash('message', 'Payment processed successfully.');
    }

    public function getFilteredStudentsProperty()
    {
        if (empty($this->search)) {
            return [];
        }

        return collect($this->students)->filter(function ($student) {
            return stripos($student['name'], $this->search) !== false ||
                   stripos($student['lrn'], $this->search) !== false;
        })->take(5);
    }

    public function render()
    {
        return view('livewire.finance.point-of-sale')
            ->layout('layouts.app', ['header' => 'Point of Sale']);
    }
}
