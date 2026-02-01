<?php

namespace App\Livewire\Finance\Cashier;

use Livewire\Component;

class CashierPanel extends Component
{
    public $search = '';
    public $student = null;
    public $cart = [];

    // Modal State
    public $showAddItemModal = false;
    public $newItemType = '';
    public $newItemAmount = '';
    public $isStoreItem = false;

    // Hardcoded Store Products
    public $storeItems = [
        'PE Uniform (Set)' => 850,
        'School ID / Lace' => 150,
        'Textbook (Science 7)' => 650,
        'School Patch' => 75,
        'Notebook' => 50,
    ];

    public function mount()
    {
        // Initialize Mock Data in Session if not exists
        if (!session()->has('mock_students')) {
            session()->put('mock_students', [
                'juan' => [
                    'id' => 'juan',
                    'name' => 'Juan Cruz',
                    'lrn' => '123456789012',
                    'grade' => 'Grade 10',
                    'section' => 'Tesla',
                    'balance' => 25000.00,
                    'avatar_params' => 'name=Juan+Cruz&background=random'
                ],
                'maria' => [
                    'id' => 'maria',
                    'name' => 'Maria Santos',
                    'lrn' => '987654321098',
                    'grade' => 'Grade 9',
                    'section' => 'Dalton',
                    'balance' => 4500.00,
                    'avatar_params' => 'name=Maria+Santos&background=random'
                ]
            ]);
        }
    }

    public function updatedSearch()
    {
        $term = trim($this->search);
        $mockStudents = session('mock_students');

        if (empty($term)) {
            $this->student = null;
            return;
        }

        // Smart Mock Search Logic
        if (stripos($term, 'Juan') !== false || stripos($term, '123') !== false) {
            $this->student = $mockStudents['juan'];
        } elseif (stripos($term, 'Maria') !== false) {
            $this->student = $mockStudents['maria'];
        } else {
            $this->student = null;
        }

        // Reset cart when switching students (optional, but cleaner)
        $this->cart = [];
    }

    public function updatedNewItemType($value)
    {
        if (array_key_exists($value, $this->storeItems)) {
            $this->newItemAmount = $this->storeItems[$value];
            $this->isStoreItem = true;
        } else {
            $this->newItemAmount = ''; // Start empty for Tuition/Misc
            $this->isStoreItem = false;
        }
    }

    public function addItem()
    {
        $this->validate([
            'newItemType' => 'required',
            'newItemAmount' => 'required|numeric|min:1',
        ]);

        $this->cart[] = [
            'name' => $this->newItemType,
            'amount' => (float) $this->newItemAmount,
        ];

        // Reset Modal Inputs
        $this->reset(['newItemType', 'newItemAmount', 'isStoreItem']);
        $this->dispatch('close-modal', 'add-item-modal'); // Dispatch event to close modal if using JS
        $this->showAddItemModal = false; // If using Livewire boolean control
    }

    public function removeItem($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
    }

    public function getTotalProperty()
    {
        return array_sum(array_column($this->cart, 'amount'));
    }

    public function processPayment()
    {
        if (!$this->student) {
            return;
        }

        if (empty($this->cart)) {
            $this->addError('cart', 'Cart is empty.');
            return;
        }

        // Deduct from Balance (Persist to Session)
        $mockStudents = session('mock_students');
        $studentId = $this->student['id'];

        $totalPaid = $this->getTotalProperty();
        $mockStudents[$studentId]['balance'] -= $totalPaid;

        // Ensure balance doesn't go below zero (optional, but good practice)
        // if ($mockStudents[$studentId]['balance'] < 0) $mockStudents[$studentId]['balance'] = 0;

        session()->put('mock_students', $mockStudents);

        // Update local state to reflect change immediately
        $this->student = $mockStudents[$studentId];

        // Clear Cart
        $this->cart = [];

        session()->flash('message', 'Receipt Generated! Payment processed successfully.');
    }

    public function render()
    {
        return view('livewire.finance.cashier.cashier-panel')
            ->layout('layouts.app', ['header' => 'Cashier Panel']);
    }
}
