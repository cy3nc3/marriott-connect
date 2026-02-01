<?php

namespace Tests\Feature;

use App\Livewire\Finance\Cashier\CashierPanel;
use Livewire\Livewire;
use Tests\TestCase;

class CashierPanelTest extends TestCase
{
    public function test_component_mounts_correctly()
    {
        Livewire::test(CashierPanel::class)
            ->assertSet('search', '')
            ->assertSet('cart', []);
    }

    public function test_search_finds_juan()
    {
        Livewire::test(CashierPanel::class)
            ->set('search', 'Juan')
            ->assertSet('student.name', 'Juan Cruz')
            ->assertSet('student.balance', 25000);
    }

    public function test_search_finds_maria()
    {
        Livewire::test(CashierPanel::class)
            ->set('search', 'Maria')
            ->assertSet('student.name', 'Maria Santos')
            ->assertSet('student.balance', 4500);
    }

    public function test_search_not_found()
    {
        Livewire::test(CashierPanel::class)
            ->set('search', 'Unknown')
            ->assertSet('student', null);
    }

    public function test_add_tuition_item()
    {
        Livewire::test(CashierPanel::class)
            ->set('newItemType', 'Tuition Fee')
            ->set('newItemAmount', 5000)
            ->call('addItem')
            ->assertCount('cart', 1)
            ->assertSet('cart.0.name', 'Tuition Fee')
            ->assertSet('cart.0.amount', 5000);
    }

    public function test_add_store_item_sets_fixed_price()
    {
        Livewire::test(CashierPanel::class)
            ->set('newItemType', 'PE Uniform (Set)')
            ->assertSet('newItemAmount', 850)
            ->assertSet('isStoreItem', true)
            ->call('addItem')
            ->assertCount('cart', 1)
            ->assertSet('cart.0.amount', 850);
    }

    public function test_process_payment_deducts_balance()
    {
        Livewire::test(CashierPanel::class)
            ->set('search', 'Juan') // Select Student
            ->set('newItemType', 'Tuition Fee')
            ->set('newItemAmount', 5000)
            ->call('addItem')
            ->call('processPayment')
            ->assertSet('student.balance', 20000) // 25000 - 5000
            ->assertCount('cart', 0)
            ->assertSee('Receipt Generated! Payment processed successfully.');
    }
}
