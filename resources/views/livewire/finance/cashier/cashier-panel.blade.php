<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 h-[calc(100vh-8rem)]">

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">

        <!-- Left Column: Student Context -->
        <div class="lg:col-span-1 flex flex-col space-y-4">

            <!-- Search Bar -->
            <div class="bg-white dark:bg-gray-800 p-4 shadow-sm sm:rounded-lg transition-colors duration-300">
                <label for="search" class="block text-medium font-medium text-gray-700 dark:text-gray-200 mb-1">Find Student</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class='bx bx-search text-gray-400'></i>
                    </div>
                    <input type="text"
                           wire:model.live="search"
                           id="search"
                           placeholder="Enter Student LRN or Name..."
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out"
                           autocomplete="off">
                </div>
            </div>

            <!-- Student Card -->
            @if($student)
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden flex-1 flex flex-col transition-colors duration-300">
                    <div class="p-6 flex flex-col items-center border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                        <img class="h-24 w-24 rounded-full border-4 border-white dark:border-gray-600 shadow-md mb-4"
                             src="https://ui-avatars.com/api/?{{ $student['avatar_params'] }}&size=128"
                             alt="{{ $student['name'] }}">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white text-center">{{ $student['name'] }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student['lrn'] }}</p>
                        <div class="mt-2 flex space-x-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                {{ $student['grade'] }}
                            </span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                {{ $student['section'] }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col justify-center items-center text-center text-gray-900 dark:text-gray-100">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Outstanding Balance</p>
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700 border w-full {{ $student['balance'] > 0 ? 'border-red-200 dark:border-red-800' : 'border-green-200 dark:border-green-800' }}">
                            <span class="block text-3xl font-extrabold {{ $student['balance'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                ₱ {{ number_format($student['balance'], 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            @elseif(!empty($search))
                <div class="bg-white dark:bg-gray-800 p-8 shadow-sm sm:rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 flex-1 transition-colors duration-300">
                    <div class="text-center">
                        <i class='bx bx-user-x text-4xl mb-2'></i>
                        <p>Student Not Found</p>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 p-8 shadow-sm sm:rounded-lg flex items-center justify-center text-gray-400 dark:text-gray-500 flex-1 transition-colors duration-300">
                    <div class="text-center">
                        <i class='bx bx-search-alt text-4xl mb-2 opacity-50'></i>
                        <p>Search for a student to begin</p>
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Column: Transaction Cart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full border border-gray-200 dark:border-gray-700 transition-colors duration-300">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                    <i class='bx bx-cart-alt mr-2 text-indigo-600 dark:text-indigo-400'></i>
                    Current Transaction
                </h3>
                <button wire:click="$set('showAddItemModal', true)"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        @if(!$student) disabled class="opacity-50 cursor-not-allowed" @endif>
                    <i class='bx bx-plus mr-1'></i> Add Item
                </button>
            </div>

            <!-- Cart List -->
            <div class="flex-1 overflow-auto p-0">
                @if(count($cart) > 0)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Item Details</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($cart as $index => $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $item['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-right font-mono">₱ {{ number_format($item['amount'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button wire:click="removeItem({{ $index }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                            <i class='bx bx-trash text-lg'></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                        <i class='bx bx-basket text-5xl mb-3 opacity-30'></i>
                        <p>Cart is empty</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-end mb-4">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-300 uppercase">Total Amount Due</span>
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">₱ {{ number_format($this->total, 2) }}</span>
                </div>
                <button wire:click="processPayment"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        @if(empty($cart) || !$student) disabled @endif>
                    Process Payment
                </button>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    @if($showAddItemModal)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showAddItemModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                    Add Item to Transaction
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <!-- Item Type -->
                                    <div>
                                        <label for="itemType" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item Type</label>
                                        <select wire:model.live="newItemType" id="itemType" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="" selected>Select Item...</option>
                                            <option value="Tuition Fee">Tuition Fee</option>
                                            <option value="Miscellaneous">Miscellaneous</option>
                                            <optgroup label="School Store">
                                                @foreach($storeItems as $name => $price)
                                                    <option value="{{ $name }}">{{ $name }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        @error('newItemType') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Amount -->
                                    <div>
                                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 dark:text-gray-400 sm:text-sm">₱</span>
                                            </div>
                                            <input type="number"
                                                   wire:model="newItemAmount"
                                                   id="amount"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-gray-300 {{ $isStoreItem ? 'bg-gray-100 dark:bg-gray-600 cursor-not-allowed' : '' }}"
                                                   placeholder="Enter Amount"
                                                   {{ $isStoreItem ? 'readonly' : '' }}>
                                        </div>
                                        @if($isStoreItem)
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Fixed price for this item.</p>
                                        @else
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter payment amount.</p>
                                        @endif
                                        @error('newItemAmount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                                wire:click="addItem"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Add to Cart
                        </button>
                        <button type="button"
                                wire:click="$set('showAddItemModal', false)"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
