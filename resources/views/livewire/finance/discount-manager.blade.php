<div class="py-12" x-data="{ openDiscountModal: false, openTagModal: false }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Section 1: Discount Types -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full">
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Discount Types</h3>
                    <button
                        @click="openDiscountModal = true"
                        class="text-indigo-600 hover:text-indigo-900" title="Create Discount">
                        <i class='bx bx-plus-circle text-2xl'></i>
                    </button>
                </div>
                <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                    @foreach($discounts as $discount)
                        <div class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                            <div>
                                <h4 class="font-bold text-gray-800">{{ $discount['name'] }}</h4>
                                <span class="text-xs text-gray-500 uppercase">{{ $discount['type'] }}</span>
                            </div>
                            <div class="text-green-600 font-bold">
                                {{ $discount['value'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section 2: Scholar List -->
            <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full">
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Scholar List</h3>
                    <button
                        @click="openTagModal = true"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Tag Student
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Deducted</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($scholars as $scholar)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $scholar['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $scholar['grade'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 font-semibold">{{ $scholar['discount'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($scholar['deducted'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Create Discount Modal -->
    <div x-show="openDiscountModal"
         @close-discount-modal.window="openDiscountModal = false"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openDiscountModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Create New Discount</h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <x-input-label :value="__('Name')" />
                            <x-text-input wire:model="newDiscountName" class="block mt-1 w-full" type="text" placeholder="e.g. Loyalty Award" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label :value="__('Type')" />
                                <select wire:model="newDiscountType" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Percentage">Percentage (%)</option>
                                    <option value="Fixed">Fixed Amount (₱)</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label :value="__('Value')" />
                                <x-text-input wire:model="newDiscountValue" class="block mt-1 w-full" type="number" step="0.01" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="createDiscount" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Create</button>
                    <button @click="openDiscountModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tag Student Modal -->
    <div x-show="openTagModal"
         @close-tag-modal.window="openTagModal = false"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openTagModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Tag Student</h3>
                    <div class="mt-4 space-y-4">
                        <div>
                            <x-input-label :value="__('Student Name')" />
                            <x-text-input wire:model="tagStudentName" class="block mt-1 w-full" type="text" placeholder="Search student..." />
                        </div>
                        <div>
                            <x-input-label :value="__('Select Discount')" />
                            <select wire:model="tagDiscountId" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select a discount</option>
                                @foreach($discounts as $d)
                                    <option value="{{ $d['id'] }}">{{ $d['name'] }} ({{ $d['value'] }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="tagStudent" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">Tag</button>
                    <button @click="openTagModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</div>
