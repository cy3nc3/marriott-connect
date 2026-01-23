<?php

namespace App\Livewire\Finance;

use Livewire\Component;

class PointOfSale extends Component
{
    // Duplicated Fake Data as requested
    public $products = [
        ['name' => 'Math Textbook 7', 'type' => 'Book', 'price' => 550.00],
        ['name' => 'PE Uniform (M)', 'type' => 'Uniform', 'price' => 350.00],
    ];

    public $unpaidBills = [
        ['name' => 'August Tuition', 'amount' => 3000.00],
        ['name' => 'Books Fee', 'amount' => 5000.00],
    ];

    public $cart = [];
    public $cashTendered = 0;

    public function addToCart($name, $price)
    {
        $this->cart[] = [
            'name' => $name,
            'price' => (float) $price,
        ];
    }

    public function getTotalProperty()
    {
        return array_sum(array_column($this->cart, 'price'));
    }

    public function getChangeProperty()
    {
        return (float) $this->cashTendered - $this->getTotalProperty();
    }

    public function processPayment()
    {
        if (empty($this->cart)) {
            return;
        }

        if ($this->getChangeProperty() < 0) {
            $this->addError('cashTendered', 'Insufficient cash.');
            return;
        }

        $this->reset(['cart', 'cashTendered']);

        session()->flash('message', 'Payment processed successfully.');
    }

    public function render()
    {
        return view('livewire.finance.point-of-sale')
            ->layout('layouts.app', ['header' => 'Point of Sale']);
    }
}
