<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent transition-colors duration-300">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Placeholder</h3>
                <x-primary-button wire:click="create">
                    <i class='bx bx-plus mr-2'></i> {{ __('Create New School Year') }}
                </x-primary-button>
            </div>

            <!-- Unified Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                School Year
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Start/End Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Admissions
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($school_years as $year)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <!-- School Year -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $year['name'] }}
                                </td>

                                <!-- Start/End Date -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $this->formatDateRange($year['start_date'], $year['end_date']) }}
                                </td>

                                <!-- Status (Radio + Quarter) -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <input
                                                type="radio"
                                                name="active_year"
                                                wire:click="setActiveYear({{ $year['id'] }})"
                                                {{ $year['status'] === 'active' ? 'checked' : '' }}
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                            >
                                            <span class="ml-2 text-sm {{ $year['status'] === 'active' ? 'font-bold text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                                {{ $year['status'] === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>

                                        @if($year['status'] === 'active')
                                            <div>
                                                <select
                                                    wire:change="updateQuarter({{ $year['id'] }}, $event.target.value)"
                                                    class="block w-full pl-3 pr-10 py-1 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                                >
                                                    <option value="1" {{ $year['quarter'] == '1' ? 'selected' : '' }}>1st Quarter</option>
                                                    <option value="2" {{ $year['quarter'] == '2' ? 'selected' : '' }}>2nd Quarter</option>
                                                    <option value="3" {{ $year['quarter'] == '3' ? 'selected' : '' }}>3rd Quarter</option>
                                                    <option value="4" {{ $year['quarter'] == '4' ? 'selected' : '' }}>4th Quarter</option>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Admissions Toggle -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button
                                        type="button"
                                        wire:click="toggleAdmissions({{ $year['id'] }})"
                                        class="{{ $year['admissions_open'] ? 'bg-indigo-600' : 'bg-gray-200' }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                                        role="switch"
                                        aria-checked="{{ $year['admissions_open'] ? 'true' : 'false' }}"
                                    >
                                        <span class="sr-only">Toggle Admissions</span>
                                        <span
                                            aria-hidden="true"
                                            class="{{ $year['admissions_open'] ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                        ></span>
                                    </button>
                                    <span class="ml-2 text-sm {{ $year['admissions_open'] ? 'text-green-600 font-medium' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $year['admissions_open'] ? 'OPEN' : 'Closed' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="edit({{ $year['id'] }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                        <i class='bx bx-edit text-xl'></i>
                                    </button>
                                    <button
                                        wire:click="delete({{ $year['id'] }})"
                                        wire:confirm="Are you sure you want to delete this school year?"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                    >
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ open: @entangle('showModal') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true">

        <!-- Backdrop -->
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100" id="modal-title">
                                {{ $isEditing ? 'Edit School Year' : 'Create New School Year' }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <!-- School Year Label -->
                                <div>
                                    <x-input-label for="name" :value="__('School Year Label (e.g. 2027-2028)')" />
                                    <x-text-input wire:model="form.name" id="name" class="block mt-1 w-full" type="text" placeholder="YYYY-YYYY" />
                                    @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Start Date -->
                                <div>
                                    <x-input-label for="start_date" :value="__('Start Date')" />
                                    <x-text-input wire:model="form.start_date" id="start_date" class="block mt-1 w-full" type="date" />
                                    @error('form.start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- End Date -->
                                <div>
                                    <x-input-label for="end_date" :value="__('End Date')" />
                                    <x-text-input wire:model="form.end_date" id="end_date" class="block mt-1 w-full" type="date" />
                                    @error('form.end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button wire:click="save" type="button" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto">
                        Save
                    </button>
                    <button wire:click="$set('showModal', false)" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
