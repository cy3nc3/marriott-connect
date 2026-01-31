<?php

namespace App\Livewire\Finance;

use Livewire\Component;

class FeeStructure extends Component
{
    // Data Store
    public $feeMatrix = [];
    public $gradeLevels = [7, 8, 9, 10];

    // Modal State
    public $showFeeModal = false;
    public $isEditing = false;

    // Form Inputs
    public $editingFeeId = null;
    public $editingGrade = null;
    public $editingDescription = '';
    public $editingAmount = '';
    public $editingType = 'Miscellaneous'; // Default

    public function mount()
    {
        // Load from session or initialize default data
        $this->feeMatrix = session()->get('fee_structure', $this->getDefaultFees());
    }

    private function getDefaultFees()
    {
        return [
            // Grade 7
            ['id' => 1, 'grade' => 7, 'description' => 'Tuition Fee', 'amount' => 12000.00, 'type' => 'Tuition'],
            ['id' => 2, 'grade' => 7, 'description' => 'Miscellaneous Fee', 'amount' => 3000.00, 'type' => 'Miscellaneous'],
            ['id' => 3, 'grade' => 7, 'description' => 'ID Fee', 'amount' => 500.00, 'type' => 'Miscellaneous'],

            // Grade 8
            ['id' => 4, 'grade' => 8, 'description' => 'Tuition Fee', 'amount' => 12500.00, 'type' => 'Tuition'],
            ['id' => 5, 'grade' => 8, 'description' => 'Miscellaneous Fee', 'amount' => 3000.00, 'type' => 'Miscellaneous'],
            ['id' => 6, 'grade' => 8, 'description' => 'ID Fee', 'amount' => 500.00, 'type' => 'Miscellaneous'],

            // Grade 9
            ['id' => 7, 'grade' => 9, 'description' => 'Tuition Fee', 'amount' => 13000.00, 'type' => 'Tuition'],
            ['id' => 8, 'grade' => 9, 'description' => 'Miscellaneous Fee', 'amount' => 3000.00, 'type' => 'Miscellaneous'],
            ['id' => 9, 'grade' => 9, 'description' => 'ID Fee', 'amount' => 500.00, 'type' => 'Miscellaneous'],

            // Grade 10
            ['id' => 10, 'grade' => 10, 'description' => 'Tuition Fee', 'amount' => 14000.00, 'type' => 'Tuition'],
            ['id' => 11, 'grade' => 10, 'description' => 'Laboratory Fee', 'amount' => 2000.00, 'type' => 'Miscellaneous'],
            ['id' => 12, 'grade' => 10, 'description' => 'Miscellaneous Fee', 'amount' => 3000.00, 'type' => 'Miscellaneous'],
            ['id' => 13, 'grade' => 10, 'description' => 'Graduation Fee', 'amount' => 1500.00, 'type' => 'Miscellaneous'],
        ];
    }

    // --- Actions ---

    public function openAddFeeModal($grade)
    {
        $this->resetValidation();
        $this->reset(['editingFeeId', 'editingDescription', 'editingAmount']);

        $this->editingGrade = $grade;
        $this->editingType = 'Miscellaneous';
        $this->isEditing = false;
        $this->showFeeModal = true;
    }

    public function editFee($id)
    {
        $fee = collect($this->feeMatrix)->firstWhere('id', $id);

        if ($fee) {
            $this->resetValidation();
            $this->editingFeeId = $fee['id'];
            $this->editingGrade = $fee['grade'];
            $this->editingDescription = $fee['description'];
            $this->editingAmount = $fee['amount'];
            $this->editingType = $fee['type'] ?? 'Miscellaneous';

            $this->isEditing = true;
            $this->showFeeModal = true;
        }
    }

    public function saveFee()
    {
        $this->validate([
            'editingDescription' => 'required|string|min:2',
            'editingAmount' => 'required|numeric|min:0',
            'editingType' => 'required|in:Tuition,Miscellaneous',
        ]);

        if ($this->isEditing) {
            // Update Existing
            $key = collect($this->feeMatrix)->search(fn($item) => $item['id'] === $this->editingFeeId);

            if ($key !== false) {
                $this->feeMatrix[$key]['description'] = $this->editingDescription;
                $this->feeMatrix[$key]['amount'] = (float) $this->editingAmount;
                $this->feeMatrix[$key]['type'] = $this->editingType;
                session()->flash('message', 'Fee updated successfully.');
            }
        } else {
            // Create New
            $newId = empty($this->feeMatrix) ? 1 : max(array_column($this->feeMatrix, 'id')) + 1;

            $this->feeMatrix[] = [
                'id' => $newId,
                'grade' => $this->editingGrade,
                'description' => $this->editingDescription,
                'amount' => (float) $this->editingAmount,
                'type' => $this->editingType,
            ];
            session()->flash('message', 'Fee added successfully.');
        }

        // Persist to Session
        session()->put('fee_structure', $this->feeMatrix);

        $this->showFeeModal = false;
    }

    public function deleteFee($id)
    {
        $this->feeMatrix = collect($this->feeMatrix)
            ->reject(fn($item) => $item['id'] === $id)
            ->values()
            ->all();

        // Persist to Session
        session()->put('fee_structure', $this->feeMatrix);
        session()->flash('message', 'Fee removed successfully.');
    }

    public function render()
    {
        return view('livewire.finance.fee-structure', [
            'fees' => $this->feeMatrix,
        ]);
    }
}
