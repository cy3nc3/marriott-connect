<?php

namespace App\Livewire\Finance;

use Livewire\Component;

class ExpenseManager extends Component
{
    public $expenses = [
        ['id' => 1, 'date' => '2023-01-15', 'category' => 'Utility', 'description' => 'Meralco Bill (Jan)', 'amount' => 15000.00, 'approved_by' => 'Admin'],
        ['id' => 2, 'date' => '2023-01-20', 'category' => 'Utility', 'description' => 'Internet Subscription', 'amount' => 2000.00, 'approved_by' => 'Admin'],
        ['id' => 3, 'date' => '2023-01-30', 'category' => 'Maintenance', 'description' => 'AC Repair', 'amount' => 3500.00, 'approved_by' => 'Finance Head'],
    ];

    public $date;
    public $category = 'Utility';
    public $description;
    public $amount;

    public function createExpense()
    {
        $this->expenses[] = [
            'id' => count($this->expenses) + 1,
            'date' => $this->date,
            'category' => $this->category,
            'description' => $this->description,
            'amount' => (float) $this->amount,
            'approved_by' => 'You',
        ];

        $this->reset(['date', 'category', 'description', 'amount']);
        session()->flash('message', 'Expense logged successfully.');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.finance.expense-manager')
            ->layout('layouts.app', ['header' => 'Expense Manager']);
    }
}
