<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Standard School Fees</h1>
        <div>
            <!-- Breadcrumb or other header actions if needed -->
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Left Column: Fee Categories -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 h-fit">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class='bx bx-category mr-2 text-indigo-600'></i> Fee Categories
                </h2>
                <button wire:click="openAddCategoryModal" class="p-1 rounded-full hover:bg-gray-100 transition-colors text-indigo-600">
                    <i class='bx bx-plus text-xl'></i>
                </button>
            </div>

            <div class="space-y-3">
                @forelse($categories as $index => $category)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-md border border-gray-100 group hover:border-indigo-200 transition-all">
                        <span class="text-gray-700 font-medium">{{ $category }}</span>
                        <button wire:click="deleteCategory({{ $index }})"
                                class="text-gray-400 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity"
                                title="Remove Category">
                            <i class='bx bx-trash'></i>
                        </button>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-4 italic">No categories defined.</div>
                @endforelse
            </div>

            <button wire:click="openAddCategoryModal" class="w-full mt-6 flex items-center justify-center px-4 py-2 border border-dashed border-gray-300 rounded-md text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-indigo-600 hover:border-indigo-300 transition-all">
                <i class='bx bx-plus mr-2'></i> Add Category
            </button>
        </div>

        <!-- Right Column: Fee Matrix -->
        <div class="md:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                    <i class='bx bx-table mr-2 text-indigo-600'></i> Fee Matrix
                </h2>

                <div class="flex items-center gap-2">
                    <label for="gradeFilter" class="text-sm font-medium text-gray-600 whitespace-nowrap">Filter by Grade:</label>
                    <select id="gradeFilter" wire:model.live="selectedGradeFilter" class="form-select text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="All">All Grades</option>
                        @foreach($gradeLevels as $level)
                            <option value="{{ $level }}">Grade {{ $level }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Level</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee Description</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($fees as $fee)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                    Grade {{ $fee['grade'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $fee['description'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-mono">
                                    ₱{{ number_format($fee['amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <button wire:click="editFee({{ $fee['id'] }})" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-1.5 rounded hover:bg-indigo-100 transition-colors" title="Edit Amount">
                                        <i class='bx bx-edit text-lg'></i>
                                    </button>
                                    <button wire:click="deleteFee({{ $fee['id'] }})" class="text-red-600 hover:text-red-900 bg-red-50 p-1.5 rounded hover:bg-red-100 transition-colors" title="Delete">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class='bx bx-search-alt text-4xl mb-2 text-gray-300'></i>
                                        <p>No fees found for this selection.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div x-data="{ show: @entangle('showAddCategoryModal') }"
         x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="show = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class='bx bx-plus text-indigo-600 text-xl'></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Add Fee Category
                            </h3>
                            <div class="mt-4">
                                <label for="categoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
                                <input type="text" wire:model="newCategoryName" id="categoryName" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Sports Fee">
                                @error('newCategoryName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="addCategory" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Add Category
                    </button>
                    <button @click="show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Fee Modal -->
    <div x-data="{ show: @entangle('showEditFeeModal') }"
         x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="show = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class='bx bx-edit text-indigo-600 text-xl'></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Edit Fee Amount
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Grade Level</label>
                                    <p class="text-gray-900 font-semibold">Grade {{ $editingFeeGrade }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Fee Description</label>
                                    <p class="text-gray-900 font-semibold">{{ $editingFeeDescription }}</p>
                                </div>
                                <div>
                                    <label for="feeAmount" class="block text-sm font-medium text-gray-700">Amount (₱)</label>
                                    <input type="number" step="0.01" wire:model="editingAmount" id="feeAmount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                                    @error('editingAmount') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="updateFee" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save Changes
                    </button>
                    <button @click="show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
