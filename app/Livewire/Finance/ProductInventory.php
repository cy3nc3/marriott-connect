<?php

namespace App\Livewire\Finance;

use Livewire\Component;

class ProductInventory extends Component
{
    public $products = [
        ['name' => 'Math Textbook 7', 'type' => 'Book', 'price' => 550.00],
        ['name' => 'PE Uniform (M)', 'type' => 'Uniform', 'price' => 350.00],
    ];

    public $name;
    public $type = 'Book';
    public $price;

    public function addItem()
    {
        $this->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
        ]);

        $this->products[] = [
            'name' => $this->name,
            'type' => $this->type,
            'price' => (float) $this->price,
        ];

        $this->reset(['name', 'type', 'price']);

        $this->dispatch('item-added');

        session()->flash('message', 'Item added successfully.');
    }

    public function render()
    {
        return view('livewire.finance.product-inventory')
            ->layout('layouts.app', ['header' => 'Product Inventory']);
    }
}
