<div class="py-12" x-data="{ openModal: false }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header Controls -->
        <div class="mb-6 flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
            <div class="flex items-center space-x-4">
                <label for="section-select" class="font-bold text-gray-700">Select Section:</label>
                <select id="section-select" wire:model.live="selectedSection" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @foreach($sections as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <button @click="openModal = true" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class='bx bx-plus mr-2'></i> Add Class
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Kanban Grid -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach($daysOfWeek as $day)
                <div class="bg-white rounded-lg shadow h-full flex flex-col">
                    <!-- Column Header -->
                    <div class="bg-gray-100 px-4 py-3 rounded-t-lg border-b border-gray-200">
                        <h3 class="font-bold text-gray-700 text-center">{{ $day }}</h3>
                    </div>

                    <!-- Column Content (Cards) -->
                    <div class="p-2 space-y-2 flex-1 min-h-[400px] bg-gray-50 rounded-b-lg">
                        @if(isset($currentSchedule[$day]))
                            @foreach($currentSchedule[$day] as $class)
                                <div class="bg-white p-3 rounded border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-indigo-600 text-sm">{{ $class['subject'] }}</span>
                                        <span class="text-xs font-mono bg-gray-100 px-1 rounded">{{ $class['room'] }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $class['time_start'] }} - {{ $class['time_end'] }}
                                    </div>
                                    <div class="text-xs text-gray-600 font-medium mt-1">
                                        {{ $class['teacher'] }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-gray-400 text-xs py-4">
                                No classes
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Add Schedule Modal -->
    <div x-show="openModal"
         @schedule-added.window="openModal = false"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Add Schedule</h3>
                    <div class="mt-4 space-y-4">

                        <!-- Subject & Teacher -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label :value="__('Subject')" />
                                <select wire:model="newSchedule.subject" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subj)
                                        <option value="{{ $subj }}">{{ $subj }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label :value="__('Teacher')" />
                                <select wire:model="newSchedule.teacher" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Teacher</option>
                                    @foreach($teachers as $teach)
                                        <option value="{{ $teach }}">{{ $teach }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Days Checkboxes -->
                        <div>
                            <x-input-label :value="__('Days')" class="mb-2" />
                            <div class="flex flex-wrap gap-4">
                                @foreach($daysOfWeek as $day)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" wire:model="newSchedule.days" value="{{ $day }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">{{ substr($day, 0, 3) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Time & Room -->
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label :value="__('Start Time')" />
                                <x-text-input wire:model="newSchedule.time_start" type="time" class="block mt-1 w-full" />
                            </div>
                            <div>
                                <x-input-label :value="__('End Time')" />
                                <x-text-input wire:model="newSchedule.time_end" type="time" class="block mt-1 w-full" />
                            </div>
                            <div>
                                <x-input-label :value="__('Room')" />
                                <x-text-input wire:model="newSchedule.room" type="text" class="block mt-1 w-full" placeholder="e.g. 101" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="addSchedule" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Add to Schedule
                    </button>
                    <button @click="openModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
