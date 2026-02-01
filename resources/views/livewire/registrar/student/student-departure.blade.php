<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Search Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-300">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Search Active Student</h2>
            <div class="flex gap-4">
                <div class="flex-1">
                    <x-text-input wire:model="searchQuery"
                                  wire:keydown.enter="search"
                                  id="searchQuery"
                                  class="block w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                  type="text"
                                  placeholder="Enter Student Name or LRN..." />
                </div>
                <x-primary-button wire:click="search">
                    <i class='bx bx-search mr-2'></i> Search
                </x-primary-button>
            </div>
        </div>

        <!-- Feedback Message -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if($selectedStudent)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-down">

                <!-- Student Info Card -->
                <div class="col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500 transition-colors duration-300">
                        <div class="flex items-center justify-center mb-4">
                            <div class="h-20 w-20 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold text-3xl">
                                {{ substr($selectedStudent['name'], 0, 1) }}
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-center text-gray-900 dark:text-white">{{ $selectedStudent['name'] }}</h3>
                        <p class="text-center text-gray-500 dark:text-gray-400 text-sm mb-4">{{ $selectedStudent['lrn'] }}</p>

                        <div class="border-t border-gray-100 dark:border-gray-700 pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Grade Level:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedStudent['grade_level'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Section:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedStudent['section'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                <span class="font-medium text-green-600 dark:text-green-400">{{ $selectedStudent['status'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Warning Card -->
                    <div class="mt-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class='bx bx-error-circle text-red-600 dark:text-red-400 text-2xl mr-3'></i>
                            <div>
                                <h4 class="text-sm font-bold text-red-800 dark:text-red-300">Warning</h4>
                                <p class="text-xs text-red-700 dark:text-red-400 mt-1">
                                    This action will remove the student from all Active Class Lists.
                                    Financial and Academic records will be retained for history.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Departure Form -->
                <div class="col-span-1 md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-300">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-2">Departure Details</h3>

                        <div class="space-y-6">
                            <!-- Reason & Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="reason" :value="__('Reason for Leaving')" />
                                    <select wire:model="reason" id="reason" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Select Reason</option>
                                        <option value="Financial">Financial Issues</option>
                                        <option value="Relocation">Relocation / Moving</option>
                                        <option value="Transfer">Transfer to another school</option>
                                        <option value="Health">Health Reasons</option>
                                        <option value="Expulsion">Expulsion / Disciplinary</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="effectivityDate" :value="__('Effectivity Date')" />
                                    <x-text-input wire:model="effectivityDate" id="effectivityDate" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" type="date" />
                                    <x-input-error :messages="$errors->get('effectivityDate')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Credentials Toggle -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-100 dark:border-gray-600">
                                <div>
                                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transfer Credentials Released?</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Has the SF10/Good Moral been given?</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="credentialsReleased" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <!-- Remarks -->
                            <div>
                                <x-input-label for="remarks" :value="__('Remarks / Notes')" />
                                <textarea wire:model="remarks" id="remarks" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Additional details..."></textarea>
                                <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                            </div>

                            <!-- Action Button -->
                            <div class="flex justify-end pt-4">
                                <button wire:click="processDeparture"
                                        wire:confirm="Are you sure you want to drop this student? This action cannot be undone."
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <i class='bx bx-user-minus mr-2 text-lg'></i>
                                    Process Departure
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
