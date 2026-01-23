<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Success Message Simulation -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card 1: Active Operations -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Active Operations</h3>

                <div class="space-y-4">
                    <!-- School Year Dropdown -->
                    <div>
                        <x-input-label for="school_year" :value="__('School Year')" />
                        <select wire:model="data.school_year" id="school_year" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="2024-2025">2024-2025</option>
                            <option value="2025-2026">2025-2026</option>
                        </select>
                    </div>

                    <!-- Quarter Dropdown -->
                    <div>
                        <x-input-label for="quarter" :value="__('Quarter')" />
                        <select wire:model="data.quarter" id="quarter" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="1">1st Quarter</option>
                            <option value="2">2nd Quarter</option>
                            <option value="3">3rd Quarter</option>
                            <option value="4">4th Quarter</option>
                        </select>
                    </div>

                    <!-- Update Status Button -->
                    <div class="pt-2">
                        <x-primary-button wire:click="updateStatus">
                            {{ __('Update Status') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Enrollment -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Enrollment Settings</h3>

                <div class="space-y-6">
                    <!-- Toggle Switch -->
                    <div class="flex items-center justify-between">
                        <span class="flex-grow flex flex-col">
                            <span class="text-sm font-medium text-gray-900">Enrollment Open</span>
                            <span class="text-sm text-gray-500">Allow new students to enroll.</span>
                        </span>

                        <!-- Toggle Button UI -->
                        <button type="button"
                                wire:click="$toggle('data.enrollment_open')"
                                class="{{ $data['enrollment_open'] ? 'bg-indigo-600' : 'bg-gray-200' }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                                role="switch"
                                aria-checked="{{ $data['enrollment_open'] ? 'true' : 'false' }}">
                            <span aria-hidden="true"
                                  class="{{ $data['enrollment_open'] ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                            </span>
                        </button>
                    </div>

                    <!-- Save Settings Button -->
                    <div class="pt-2">
                        <x-primary-button wire:click="saveSettings">
                            {{ __('Save Settings') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
