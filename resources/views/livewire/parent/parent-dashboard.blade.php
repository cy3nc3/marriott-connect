<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Child Switcher -->
        <div class="bg-white p-4 shadow-sm sm:rounded-lg flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <label for="childSelect" class="text-sm font-medium text-gray-700">Select Child:</label>
                <select wire:model.live="selectedChildId" id="childSelect" class="mt-1 block w-64 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    @foreach($children as $child)
                        <option value="{{ $child['id'] }}">{{ $child['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text-sm text-gray-500">
                Currently Viewing: <span class="font-bold text-gray-800">{{ $this->selectedChild['name'] }}</span> ({{ $this->selectedChild['grade'] }})
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Billing Summary Card -->
            <div class="md:col-span-1 bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Total Remaining Balance</h3>
                    <div class="mt-4 flex items-baseline">
                        <span class="text-3xl font-extrabold text-red-600">
                            ₱ {{ number_format($this->totalRemainingBalance, 2) }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Due immediately</p>
                </div>
            </div>

            <!-- Recent Activity / Ledger -->
            <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Account Ledger</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($this->selectedChild['ledger'] as $entry)
                                <tr class="{{ $entry['status'] === 'Unpaid' ? 'bg-red-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ date('M d, Y', strtotime($entry['date'])) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $entry['description'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        {{ number_format($entry['amount'], 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $entry['status'] === 'Paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $entry['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
