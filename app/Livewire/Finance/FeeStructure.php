<?php

namespace App\Livewire\Finance;

use Livewire\Component;

class FeeStructure extends Component
{
    // Data Stores
    public $categories = [];
    public $feeMatrix = [];
    public $gradeLevels = [7, 8, 9, 10, 11, 12];

    // Filters
    public $selectedGradeFilter = 'All';

    // Modal Visibility
    public $showAddCategoryModal = false;
    public $showEditFeeModal = false;

    // Form Inputs
    public $newCategoryName = '';

    public $editingFeeId = null;
    public $editingFeeGrade = null;
    public $editingFeeDescription = '';
    public $editingAmount = '';

    public function mount()
    {
        $this->categories = [
            'Tuition Fee',
            'Miscellaneous Fee',
            'Laboratory Fee',
            'Books',
            'Uniform',
        ];

        // Initialize Hardcoded Fee Matrix
        $this->feeMatrix = [
            ['id' => 1, 'grade' => 7, 'description' => 'Tuition Fee', 'amount' => 25000.00],
            ['id' => 2, 'grade' => 7, 'description' => 'Miscellaneous Fee', 'amount' => 3500.00],
            ['id' => 3, 'grade' => 7, 'description' => 'Books', 'amount' => 5000.00],
            ['id' => 4, 'grade' => 8, 'description' => 'Tuition Fee', 'amount' => 26000.00],
            ['id' => 5, 'grade' => 8, 'description' => 'Miscellaneous Fee', 'amount' => 3500.00],
            ['id' => 6, 'grade' => 8, 'description' => 'Laboratory Fee', 'amount' => 1500.00],
            ['id' => 7, 'grade' => 9, 'description' => 'Tuition Fee', 'amount' => 27000.00],
            ['id' => 8, 'grade' => 9, 'description' => 'Miscellaneous Fee', 'amount' => 3500.00],
            ['id' => 9, 'grade' => 9, 'description' => 'Laboratory Fee', 'amount' => 2000.00],
            ['id' => 10, 'grade' => 10, 'description' => 'Tuition Fee', 'amount' => 28000.00],
            ['id' => 11, 'grade' => 10, 'description' => 'Miscellaneous Fee', 'amount' => 4000.00],
            ['id' => 12, 'grade' => 10, 'description' => 'Laboratory Fee', 'amount' => 2500.00],
            ['id' => 13, 'grade' => 11, 'description' => 'Tuition Fee', 'amount' => 30000.00],
            ['id' => 14, 'grade' => 11, 'description' => 'Miscellaneous Fee', 'amount' => 5000.00],
            ['id' => 15, 'grade' => 11, 'description' => 'Laboratory Fee', 'amount' => 3000.00],
            ['id' => 16, 'grade' => 12, 'description' => 'Tuition Fee', 'amount' => 32000.00],
            ['id' => 17, 'grade' => 12, 'description' => 'Miscellaneous Fee', 'amount' => 5000.00],
            ['id' => 18, 'grade' => 12, 'description' => 'Laboratory Fee', 'amount' => 3500.00],
        ];
    }

    // --- Actions ---

    public function openAddCategoryModal()
    {
        $this->reset('newCategoryName');
        $this->showAddCategoryModal = true;
    }

    public function addCategory()
    {
        $this->validate([
            'newCategoryName' => 'required|string|min:2',
        ]);

        if (!in_array($this->newCategoryName, $this->categories)) {
            $this->categories[] = $this->newCategoryName;
            session()->flash('message', 'Fee Category added successfully.');
        } else {
            session()->flash('error', 'Category already exists.');
        }

        $this->showAddCategoryModal = false;
        $this->reset('newCategoryName');
    }

    public function deleteCategory($index)
    {
        unset($this->categories[$index]);
        $this->categories = array_values($this->categories); // Re-index
        session()->flash('message', 'Fee Category deleted.');
    }

    public function editFee($id)
    {
        $fee = collect($this->feeMatrix)->firstWhere('id', $id);

        if ($fee) {
            $this->editingFeeId = $fee['id'];
            $this->editingFeeGrade = $fee['grade'];
            $this->editingFeeDescription = $fee['description'];
            $this->editingAmount = $fee['amount'];
            $this->showEditFeeModal = true;
        }
    }

    public function updateFee()
    {
        $this->validate([
            'editingAmount' => 'required|numeric|min:0',
        ]);

        $key = collect($this->feeMatrix)->search(fn($item) => $item['id'] === $this->editingFeeId);

        if ($key !== false) {
            $this->feeMatrix[$key]['amount'] = (float) $this->editingAmount;
            session()->flash('message', 'Fee updated successfully.');
        }

        $this->showEditFeeModal = false;
        $this->reset(['editingFeeId', 'editingFeeGrade', 'editingFeeDescription', 'editingAmount']);
    }

    public function deleteFee($id)
    {
        $this->feeMatrix = collect($this->feeMatrix)
            ->reject(fn($item) => $item['id'] === $id)
            ->values()
            ->all();

        session()->flash('message', 'Fee removed from matrix.');
    }

    public function render()
    {
        $filteredFees = $this->feeMatrix;

        if ($this->selectedGradeFilter !== 'All') {
            $filteredFees = array_filter($this->feeMatrix, function ($fee) {
                return $fee['grade'] == $this->selectedGradeFilter;
            });
        }

        return view('livewire.finance.fee-structure', [
            'fees' => $filteredFees,
        ]);
    }
}
