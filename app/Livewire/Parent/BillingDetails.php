<?php

namespace App\Livewire\Parent;

use Livewire\Component;

class BillingDetails extends Component
{
    public $outstandingBalance = 6000.00;

    public $bills = [
        ['description' => 'Tuition Fee (Aug)', 'due_date' => '2023-08-15', 'amount' => 3000.00, 'status' => 'Paid'],
        ['description' => 'Books & Uniform', 'due_date' => '2023-08-20', 'amount' => 5000.00, 'status' => 'Paid'],
        ['description' => 'Tuition Fee (Sep)', 'due_date' => '2023-09-15', 'amount' => 3000.00, 'status' => 'Unpaid'],
        ['description' => 'Tuition Fee (Oct)', 'due_date' => '2023-10-15', 'amount' => 3000.00, 'status' => 'Unpaid'],
    ];

    public $transactions = [
        ['date' => '2023-08-14', 'ref_no' => 'OR-2023-001', 'mode' => 'Cash', 'amount' => 3000.00],
        ['date' => '2023-08-20', 'ref_no' => 'GCASH-123456', 'mode' => 'GCash', 'amount' => 5000.00],
        ['date' => '2023-07-30', 'ref_no' => 'OR-2023-000', 'mode' => 'Cash', 'amount' => 1000.00], // Downpayment
    ];

    public function render()
    {
        return view('livewire.parent.billing-details')
            ->layout('layouts.app', ['header' => 'Statement of Account']);
    }
}
