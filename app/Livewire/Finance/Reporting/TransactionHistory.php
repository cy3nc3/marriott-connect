<?php

namespace App\Livewire\Finance\Reporting;

use Livewire\Component;

class TransactionHistory extends Component
{
    public $dateFrom;
    public $dateTo;
    public $paymentMode = 'All';

    public $transactions = [
        ['or_number' => 'OR-2023-1001', 'student' => 'Juan Cruz', 'type' => 'Tuition Fee', 'amount' => 3000.00, 'mode' => 'Cash', 'cashier' => 'Admin', 'timestamp' => '2023-10-01 08:30 AM'],
        ['or_number' => 'OR-2023-1002', 'student' => 'Maria Santos', 'type' => 'Books', 'amount' => 550.00, 'mode' => 'GCash', 'cashier' => 'Admin', 'timestamp' => '2023-10-01 09:15 AM'],
        ['or_number' => 'OR-2023-1003', 'student' => 'Pedro Dizon', 'type' => 'Tuition Fee', 'amount' => 3000.00, 'mode' => 'Cash', 'cashier' => 'Admin', 'timestamp' => '2023-10-01 10:00 AM'],
        ['or_number' => 'OR-2023-1004', 'student' => 'Ana Lee', 'type' => 'Uniform', 'amount' => 1200.00, 'mode' => 'Cash', 'cashier' => 'Admin', 'timestamp' => '2023-10-01 11:45 AM'],
        ['or_number' => 'OR-2023-1005', 'student' => 'Jose Rizal', 'type' => 'Tuition Fee', 'amount' => 3000.00, 'mode' => 'GCash', 'cashier' => 'Admin', 'timestamp' => '2023-10-02 08:00 AM'],
    ];

    public function render()
    {
        return view('livewire.finance.reporting.transaction-history')
            ->layout('layouts.app', ['header' => 'Transaction Log']);
    }
}
