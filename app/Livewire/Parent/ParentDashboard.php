<?php

namespace App\Livewire\Parent;

use Livewire\Component;

class ParentDashboard extends Component
{
    public $selectedChildId;

    public $children = [
        [
            'id' => 1,
            'name' => 'Juan Cruz',
            'grade' => 'Grade 7 - Emerald',
            'ledger' => [
                ['date' => '2023-08-15', 'description' => 'Tuition Fee (Aug)', 'amount' => 3000, 'status' => 'Paid'],
                ['date' => '2023-09-15', 'description' => 'Tuition Fee (Sep)', 'amount' => 3000, 'status' => 'Unpaid'],
                ['date' => '2023-10-15', 'description' => 'Tuition Fee (Oct)', 'amount' => 3000, 'status' => 'Unpaid'],
                ['date' => '2023-08-20', 'description' => 'Books & Uniform', 'amount' => 5000, 'status' => 'Paid'],
            ]
        ],
        [
            'id' => 2,
            'name' => 'Ana Cruz',
            'grade' => 'Grade 4 - Pearl',
            'ledger' => [
                ['date' => '2023-08-15', 'description' => 'Tuition Fee (Aug)', 'amount' => 2500, 'status' => 'Paid'],
                ['date' => '2023-09-15', 'description' => 'Tuition Fee (Sep)', 'amount' => 2500, 'status' => 'Paid'],
                ['date' => '2023-10-15', 'description' => 'Tuition Fee (Oct)', 'amount' => 2500, 'status' => 'Unpaid'],
            ]
        ]
    ];

    public function mount()
    {
        $this->selectedChildId = $this->children[0]['id'];
    }

    public function getSelectedChildProperty()
    {
        return collect($this->children)->firstWhere('id', $this->selectedChildId);
    }

    public function getTotalRemainingBalanceProperty()
    {
        return collect($this->selectedChild['ledger'])
            ->where('status', 'Unpaid')
            ->sum('amount');
    }

    public function render()
    {
        return view('livewire.parent.parent-dashboard')
            ->layout('layouts.app', ['header' => 'Parent Portal', 'role' => 'parent']);
    }
}
