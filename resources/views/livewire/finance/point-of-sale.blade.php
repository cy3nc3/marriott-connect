<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-[calc(100vh-8rem)]">

    <!-- Success Message Simulation -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 h-full">
        <!-- Left Column: Selection Area -->
        <div class="md:col-span-2 flex flex-col space-y-4 h-full overflow-hidden">

            <!-- Top Section: Student Search -->
            <div class="bg-white p-4 shadow-sm sm:rounded-lg shrink-0 z-20 relative">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Student</label>
                <div class="relative">
                    <input type="text"
                           wire:model.live="search"
                           placeholder="Search by Name or LRN..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           autocomplete="off">

                    <!-- Search Results Dropdown -->
                    @if(!empty($this->filteredStudents) && !$selectedStudent)
                        <div class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                            @foreach($this->filteredStudents as $student)
                                <div wire:click="selectStudent({{ $student['id'] }})" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-50 text-gray-900">
                                    <span class="block truncate font-semibold">{{ $student['name'] }}</span>
                                    <span class="block truncate text-xs text-gray-500">LRN: {{ $student['lrn'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Middle Section: Outstanding Balances -->
            <div class="bg-white shadow-sm sm:rounded-lg flex-1 overflow-hidden flex flex-col min-h-[150px]">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                        Outstanding Balances
                        @if($selectedStudent)
                            <span class="text-indigo-600 normal-case">- {{ $selectedStudent['name'] }}</span>
                        @endif
                    </h3>
                </div>
                <div class="p-0 overflow-y-auto flex-1">
                    @if($selectedStudent)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Add</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($selectedStudent['unpaid_bills'] as $bill)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $bill['description'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($bill['amount'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="addToCart('{{ $bill['description'] }} ({{ $selectedStudent['name'] }})', {{ $bill['amount'] }})" class="text-indigo-600 hover:text-indigo-900 font-semibold">Add</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-400 italic">
                            Select a student to view balances.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Bottom Section: School Store -->
            <div class="bg-white shadow-sm sm:rounded-lg flex-1 overflow-hidden flex flex-col min-h-[200px]">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">School Store</h3>
                </div>
                <div class="p-4 overflow-y-auto flex-1">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($products as $product)
                            <button wire:click="addToCart('{{ $product['name'] }}', {{ $product['price'] }})"
                                    class="flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg hover:bg-indigo-50 hover:border-indigo-200 transition-all duration-200 text-center bg-white group h-full">
                                <span class="font-medium text-gray-900 group-hover:text-indigo-700 text-sm mb-1">{{ $product['name'] }}</span>
                                <span class="text-xs text-gray-500">{{ $product['type'] }}</span>
                                <span class="text-sm font-bold text-gray-800 mt-2">{{ number_format($product['price'], 2) }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Cart -->
        <div class="md:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full border border-gray-200">
            <div class="p-4 bg-gray-800 text-white">
                <h3 class="text-lg font-bold">Current Cart</h3>
            </div>

            <!-- Cart Items -->
            <div class="p-4 flex-1 overflow-y-auto space-y-2 bg-gray-50">
                @forelse($cart as $index => $item)
                    <div class="flex justify-between items-center text-sm bg-white p-2 rounded shadow-sm border border-gray-100">
                        <div class="flex flex-col overflow-hidden">
                            <span class="text-gray-800 font-medium truncate">{{ $item['name'] }}</span>
                        </div>
                        <div class="flex items-center space-x-3 shrink-0 ml-2">
                            <span class="font-bold text-gray-900">{{ number_format($item['price'], 2) }}</span>
                            <button wire:click="removeItem({{ $index }})" class="text-red-400 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-400 text-center py-8 italic text-sm">Cart is empty</div>
                @endforelse
            </div>

            <!-- Transaction Inputs & Checkout -->
            <div class="p-4 border-t border-gray-200 bg-white space-y-3 z-10 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">

                <!-- Totals -->
                <div class="flex justify-between items-center text-xl font-bold text-gray-800 pb-2 border-b border-gray-100">
                    <span>Total Due:</span>
                    <span>{{ number_format($this->total, 2) }}</span>
                </div>

                <!-- Inputs -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-1">
                         <x-input-label for="orNumber" :value="__('OR / Ref No.')" class="text-xs" />
                         <x-text-input wire:model="orNumber" id="orNumber" class="block mt-1 w-full py-1 text-sm" type="text" />
                         <x-input-error :messages="$errors->get('orNumber')" class="mt-1 text-xs" />
                    </div>
                    <div class="col-span-1">
                        <x-input-label for="paymentMode" :value="__('Payment Mode')" class="text-xs" />
                        <select wire:model.live="paymentMode" id="paymentMode" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-1 text-sm">
                            <option value="Cash">Cash</option>
                            <option value="GCash">GCash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                         <x-input-error :messages="$errors->get('paymentMode')" class="mt-1 text-xs" />
                    </div>
                </div>

                <div>
                    <x-input-label for="remarks" :value="__('Remarks (Optional)')" class="text-xs" />
                    <textarea wire:model="remarks" id="remarks" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm"></textarea>
                </div>

                @if($paymentMode === 'Cash')
                    <div>
                        <x-input-label for="cashTendered" :value="__('Cash Tendered')" class="text-xs" />
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                              <span class="text-gray-500 sm:text-sm">₱</span>
                            </div>
                            <x-text-input wire:model.live="cashTendered" id="cashTendered" class="block w-full pl-7 text-right font-mono text-lg font-bold" type="number" step="0.01" />
                        </div>
                        <x-input-error :messages="$errors->get('cashTendered')" class="mt-1 text-xs" />
                    </div>

                    <div class="flex justify-between items-center font-medium text-sm pt-1">
                        <span>Change:</span>
                        <span class="{{ $this->change < 0 ? 'text-red-600' : 'text-green-600' }} font-bold text-lg">
                            {{ number_format($this->change, 2) }}
                        </span>
                    </div>
                @endif

                <x-primary-button wire:click="processPayment" class="w-full justify-center h-12 text-lg uppercase tracking-widest mt-2" :disabled="empty($cart)">
                    {{ __('Process Payment') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
