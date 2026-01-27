<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Remedial / Summer Class Entry</h2>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Search & Selection -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Find Retained Student</h3>

                    <div class="relative">
                        <x-input-label :value="__('Search Name')" class="sr-only" />
                        <div class="flex">
                            <input
                                wire:model.live="searchQuery"
                                type="text"
                                placeholder="Search Retained Student..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >
                        </div>

                        <!-- Dropdown Results -->
                        @if(!empty($searchQuery))
                            <div class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto sm:text-sm">
                                @if(count($this->filteredStudents) > 0)
                                    @foreach($this->filteredStudents as $s)
                                        <button
                                            wire:click="selectStudent({{ $s['id'] }})"
                                            class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white w-full text-left"
                                        >
                                            <div class="flex items-center">
                                                <span class="font-normal truncate block">
                                                    {{ $s['name'] }}
                                                </span>
                                                <span class="ml-2 text-gray-500 hover:text-gray-200 text-xs truncate">
                                                    ({{ $s['subject'] }}: {{ $s['final_grade'] }})
                                                </span>
                                            </div>
                                        </button>
                                    @endforeach
                                @else
                                    <div class="cursor-default select-none relative py-2 pl-3 pr-9 text-gray-700">
                                        No matches found.
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        Only students marked as "Retained" will appear here.
                    </p>
                </div>
            </div>

            <!-- Right Column: Adjustment Card -->
            <div class="lg:col-span-2">
                @if($this->selectedStudent)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex justify-between items-start border-b border-gray-200 pb-4 mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $this->selectedStudent['name'] }}</h3>
                                <p class="text-sm text-gray-500">Student ID: {{ $this->selectedStudent['id'] }}</p>
                            </div>
                            <button wire:click="clearSelection" class="text-sm text-gray-400 hover:text-gray-600">
                                Close
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Current Status -->
                            <div class="bg-red-50 p-4 rounded-md border border-red-200">
                                <h4 class="text-sm font-bold text-red-800 uppercase mb-2">Failed Subject</h4>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-gray-700">Subject:</span>
                                    <span class="font-medium text-gray-900">{{ $this->selectedStudent['subject'] }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Old Final Grade:</span>
                                    <span class="font-bold text-red-600 text-lg">{{ $this->selectedStudent['final_grade'] }}</span>
                                </div>
                            </div>

                            <!-- Remedial Entry -->
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 uppercase mb-4">Remedial / Summer</h4>

                                <div class="mb-4">
                                    <x-input-label :value="__('Remedial Grade')" />
                                    <x-text-input
                                        wire:model.live="remedialGrade"
                                        type="number"
                                        min="0" max="100"
                                        class="block mt-1 w-full font-bold text-lg"
                                        placeholder="e.g. 80"
                                    />
                                </div>

                                @if(is_numeric($remedialGrade))
                                    <div class="bg-gray-50 p-4 rounded-md border border-gray-200 mt-4">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-500">New Final Grade:</span>
                                            <span class="text-xl font-bold {{ $this->recomputedFinalGrade >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($this->recomputedFinalGrade, 2) }}
                                            </span>
                                        </div>
                                        <div class="text-right mt-1">
                                            @if($this->recomputedFinalGrade >= 75)
                                                <span class="text-xs font-bold text-green-600 uppercase tracking-wide">Result: Passed</span>
                                            @else
                                                <span class="text-xs font-bold text-red-600 uppercase tracking-wide">Result: Failed</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                            <button
                                wire:click="updateStatus"
                                @if(!$remedialGrade || $this->recomputedFinalGrade < 75) disabled @endif
                                class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150"
                            >
                                Update Status to Promoted
                            </button>
                        </div>

                    </div>
                @else
                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg h-64 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <i class='bx bx-search text-4xl mb-2'></i>
                            <p>Select a student to begin entry.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
