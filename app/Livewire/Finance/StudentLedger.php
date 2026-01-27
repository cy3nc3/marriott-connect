<?php

namespace App\Livewire\Finance;

use Livewire\Component;

class StudentLedger extends Component
{
    public $search = '';
    public $selectedStudent = null;

    // Hardcoded Data
    public $students = [
        [
            'id' => 1,
            'name' => 'Juan Cruz',
            'lrn' => '123456789012',
            'grade_section' => 'Grade 7 - Rizal',
            'guardian' => 'Pedro Cruz',
            'contact' => '09123456789',
            'ledger' => [
                ['date' => '2023-08-01', 'description' => 'Tuition Fee', 'amount' => 25000, 'type' => 'Debit'],
                ['date' => '2023-08-01', 'description' => 'Misc Fee', 'amount' => 5000, 'type' => 'Debit'],
                ['date' => '2023-08-05', 'description' => 'Payment (Cash) - OR#1001', 'amount' => 10000, 'type' => 'Credit'],
                ['date' => '2023-09-01', 'description' => 'Book Payment', 'amount' => 5000, 'type' => 'Credit'],
                ['date' => '2023-09-15', 'description' => 'Uniform', 'amount' => 1500, 'type' => 'Debit'],
            ]
        ],
        [
            'id' => 2,
            'name' => 'Maria Santos',
            'lrn' => '987654321098',
            'grade_section' => 'Grade 8 - Bonifacio',
            'guardian' => 'Juana Santos',
            'contact' => '09987654321',
            'ledger' => [
                ['date' => '2023-08-01', 'description' => 'Tuition Fee', 'amount' => 28000, 'type' => 'Debit'],
                ['date' => '2023-08-10', 'description' => 'Full Payment - OR#1002', 'amount' => 28000, 'type' => 'Credit'],
            ]
        ],
    ];

    public function searchStudent()
    {
        $this->selectedStudent = null;

        if (empty($this->search)) {
            return;
        }

        $found = collect($this->students)->first(function ($student) {
            return stripos($student['name'], $this->search) !== false ||
                   stripos($student['lrn'], $this->search) !== false;
        });

        if ($found) {
            // Process ledger to add running balance
            $runningBalance = 0;
            $processedLedger = [];
            $totalFees = 0;
            $totalPayments = 0;

            foreach ($found['ledger'] as $entry) {
                if ($entry['type'] === 'Debit') {
                    $runningBalance += $entry['amount'];
                    $totalFees += $entry['amount'];
                } else {
                    $runningBalance -= $entry['amount'];
                    $totalPayments += $entry['amount'];
                }

                $entry['running_balance'] = $runningBalance;
                $processedLedger[] = $entry;
            }

            $this->selectedStudent = $found;
            $this->selectedStudent['ledger'] = $processedLedger;
            $this->selectedStudent['total_fees'] = $totalFees;
            $this->selectedStudent['total_payments'] = $totalPayments;
            $this->selectedStudent['current_balance'] = $runningBalance;
        } else {
             session()->flash('error', 'Student not found.');
        }
    }

    public function render()
    {
        return view('livewire.finance.student-ledger')
            ->layout('layouts.app', ['header' => 'Student Ledger']);
    }
}
