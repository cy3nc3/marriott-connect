<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- School Identity Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">School Identity</h3>

                <div class="space-y-4">
                    <!-- School Name -->
                    <div>
                        <x-input-label for="school_name" :value="__('School Name')" />
                        <x-text-input wire:model="data.school_name" id="school_name" class="block mt-1 w-full" type="text" />
                    </div>

                    <!-- School ID -->
                    <div>
                        <x-input-label for="school_id" :value="__('School ID Number (DepEd ID)')" />
                        <x-text-input wire:model="data.school_id" id="school_id" class="block mt-1 w-full" type="text" />
                    </div>

                    <!-- Address -->
                    <div>
                        <x-input-label for="address" :value="__('Address')" />
                        <textarea wire:model="data.address" id="address" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Switches Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">System Switches</h3>

                <div class="space-y-6">
                    <!-- Maintenance Mode -->
                    <div class="flex items-center justify-between">
                        <span class="flex-grow flex flex-col">
                            <span class="text-sm font-medium text-gray-900">Maintenance Mode</span>
                            <span class="text-sm text-gray-500">Take the system down for repairs.</span>
                        </span>
                        <button type="button"
                                wire:click="$toggle('data.maintenance_mode')"
                                class="{{ $data['maintenance_mode'] ? 'bg-indigo-600' : 'bg-gray-200' }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                                role="switch"
                                aria-checked="{{ $data['maintenance_mode'] ? 'true' : 'false' }}">
                            <span aria-hidden="true"
                                  class="{{ $data['maintenance_mode'] ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                            </span>
                        </button>
                    </div>

                    <!-- Allow Parent Portal Access -->
                    <div class="flex items-center justify-between">
                        <span class="flex-grow flex flex-col">
                            <span class="text-sm font-medium text-gray-900">Allow Parent Portal Access</span>
                            <span class="text-sm text-gray-500">Enable access for parents.</span>
                        </span>
                        <button type="button"
                                wire:click="$toggle('data.allow_parent_portal')"
                                class="{{ $data['allow_parent_portal'] ? 'bg-indigo-600' : 'bg-gray-200' }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2"
                                role="switch"
                                aria-checked="{{ $data['allow_parent_portal'] ? 'true' : 'false' }}">
                            <span aria-hidden="true"
                                  class="{{ $data['allow_parent_portal'] ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branding Card (Spans full width on mobile, maybe? Or keep in grid. Let's make it span 2 columns if on md) -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Branding</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Upload Logo -->
                    <div>
                        <x-input-label for="logo" :value="__('Upload Logo')" />
                        <input type="file" wire:model="logo" id="logo" class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                        "/>
                        <div class="mt-2">
                            @if ($logo)
                                <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="h-20 w-auto object-contain border rounded p-1">
                            @else
                                <img src="https://placehold.co/100" alt="Current Logo" class="h-20 w-auto object-contain border rounded p-1">
                            @endif
                        </div>
                    </div>

                    <!-- Upload Letterhead -->
                    <div>
                        <x-input-label for="letterhead" :value="__('Upload Letterhead Header')" />
                        <input type="file" wire:model="letterhead" id="letterhead" class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                        "/>
                        <div class="mt-2">
                            @if ($letterhead)
                                <img src="{{ $letterhead->temporaryUrl() }}" alt="Letterhead Preview" class="h-20 w-auto object-contain border rounded p-1">
                            @else
                                <div class="h-20 w-full border border-dashed border-gray-300 rounded flex items-center justify-center text-gray-400 text-sm">
                                    No custom letterhead uploaded
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <x-primary-button wire:click="saveSettings">
            {{ __('Save Configuration') }}
        </x-primary-button>
    </div>
</div>
