<?php

namespace App\Livewire\Finance;

use Livewire\Component;
use Carbon\Carbon;

class DailyRemittance extends Component
{
    public $date;
    public $transactions = [];

    public function mount()
    {
        $this->date = Carbon::now()->format('F j, Y');

        // Mock Transaction Data
        $this->transactions = [
            ['category' => 'Tuition', 'amount' => 15000, 'type' => 'Cash'],
            ['category' => 'Tuition', 'amount' => 12000, 'type' => 'Check'],
            ['category' => 'Books', 'amount' => 5000, 'type' => 'Cash'],
            ['category' => 'Books', 'amount' => 2500, 'type' => 'GCash'],
            ['category' => 'Uniforms', 'amount' => 3000, 'type' => 'Cash'],
            ['category' => 'Misc Fees', 'amount' => 1500, 'type' => 'Cash'],
            ['category' => 'Tuition', 'amount' => 6000, 'type' => 'GCash'],
            ['category' => 'Uniforms', 'amount' => 1200, 'type' => 'GCash'],
        ];
    }

    public function render()
    {
        // Calculate Totals
        $totalCollected = 0;
        $cashOnHand = 0;
        $digitalTotal = 0;
        $breakdown = [];

        foreach ($this->transactions as $txn) {
            $amount = $txn['amount'];
            $totalCollected += $amount;

            // Payment Method Split
            if ($txn['type'] === 'Cash') {
                $cashOnHand += $amount;
            } else {
                $digitalTotal += $amount;
            }

            // Category Breakdown
            $cat = $txn['category'];
            if (!isset($breakdown[$cat])) {
                $breakdown[$cat] = ['count' => 0, 'amount' => 0];
            }
            $breakdown[$cat]['count']++;
            $breakdown[$cat]['amount'] += $amount;
        }

        return view('livewire.finance.daily-remittance', [
            'totalCollected' => $totalCollected,
            'cashOnHand' => $cashOnHand,
            'digitalTotal' => $digitalTotal,
            'breakdown' => $breakdown
        ]);
    }
}
