<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-[calc(100vh-8rem)]" x-data="{ tab: 'tuition' }">

    <!-- Success Message Simulation -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 h-full">
        <!-- Left Column: Store -->
        <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full">
            <!-- Tabs -->
            <div class="flex border-b border-gray-200">
                <button @click="tab = 'tuition'"
                        :class="{ 'border-indigo-500 text-indigo-600': tab === 'tuition', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'tuition' }"
                        class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-200">
                    Pay Tuition
                </button>
                <button @click="tab = 'items'"
                        :class="{ 'border-indigo-500 text-indigo-600': tab === 'items', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'items' }"
                        class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors duration-200">
                    Buy Items
                </button>
            </div>

            <!-- Tab Content -->
            <div class="p-6 flex-1 overflow-y-auto">
                <!-- Tuition Tab -->
                <div x-show="tab === 'tuition'" class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Unpaid Bills</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($unpaidBills as $bill)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $bill['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($bill['amount'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="addToCart('{{ $bill['name'] }}', {{ $bill['amount'] }})" class="text-indigo-600 hover:text-indigo-900">Add to Cart</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Items Tab -->
                <div x-show="tab === 'items'" style="display: none;">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Products</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($products as $product)
                            <button wire:click="addToCart('{{ $product['name'] }}', {{ $product['price'] }})"
                                    class="flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-center h-32">
                                <span class="font-medium text-gray-900">{{ $product['name'] }}</span>
                                <span class="text-sm text-gray-500 mt-1">{{ number_format($product['price'], 2) }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Cart -->
        <div class="md:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full">
            <div class="p-6 flex-1 flex flex-col">
                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Current Cart</h3>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto space-y-3 mb-4">
                    @forelse($cart as $item)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-800">{{ $item['name'] }}</span>
                            <span class="font-medium text-gray-900">{{ number_format($item['price'], 2) }}</span>
                        </div>
                    @empty
                        <div class="text-gray-500 text-center py-8">Cart is empty</div>
                    @endforelse
                </div>

                <!-- Totals & Checkout -->
                <div class="border-t pt-4 space-y-4">
                    <div class="flex justify-between items-center text-lg font-bold">
                        <span>Total Due:</span>
                        <span>{{ number_format($this->total, 2) }}</span>
                    </div>

                    <div>
                        <x-input-label for="cashTendered" :value="__('Cash Tendered')" />
                        <x-text-input wire:model.live="cashTendered" id="cashTendered" class="block mt-1 w-full text-right" type="number" step="0.01" />
                        <x-input-error :messages="$errors->get('cashTendered')" class="mt-2" />
                    </div>

                    <div class="flex justify-between items-center font-medium">
                        <span>Change:</span>
                        <span class="{{ $this->change < 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ number_format($this->change, 2) }}
                        </span>
                    </div>

                    <x-primary-button wire:click="processPayment" class="w-full justify-center h-12 text-lg" :disabled="empty($cart)">
                        {{ __('Process Payment') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>
