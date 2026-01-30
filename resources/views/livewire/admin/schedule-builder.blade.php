<div class="py-12" x-data="{ openModal: @entangle('openModal') }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header Controls (Control Panel) -->
        <div class="mb-6 bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Schedule Control Panel</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Filter 1: Target Section -->
                <div>
                    <label for="section-select" class="block font-medium text-gray-700 mb-2">Target Section</label>
                    <select id="section-select" wire:model.live="selectedSection" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach($sections as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter 2: Teacher (Overlay) -->
                <div>
                    <label for="teacher-select" class="block font-medium text-gray-700 mb-2">Teacher Overlay</label>
                    <select id="teacher-select" wire:model.live="selectedTeacher" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Select Teacher --</option>
                        @foreach($teachers as $teach)
                            <option value="{{ $teach }}">{{ $teach }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter 3: Subject (Highlighter) -->
                <div>
                    <label for="subject-select" class="block font-medium text-gray-700 mb-2">Subject Highlighter</label>
                    <select id="subject-select" wire:model.live="selectedSubject" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subj)
                            <option value="{{ $subj }}">{{ $subj }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Smart Matrix Grid -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 border border-gray-200">
                                Time
                            </th>
                            @foreach($daysOfWeek as $day)
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border border-gray-200 w-1/5">
                                    {{ $day }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($timeSlots as $time)
                            <tr>
                                <!-- Time Column -->
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-gray-900 bg-gray-50 border border-gray-200 text-center">
                                    {{ date('g:i A', strtotime($time)) }}
                                    <span class="block text-xs text-gray-400 font-normal">
                                        {{ date('g:i A', strtotime($time) + 3600) }}
                                    </span>
                                </td>

                                <!-- Day Columns -->
                                @foreach($daysOfWeek as $day)
                                    @php
                                        $slotData = $this->getSlotData($day, $time);
                                    @endphp

                                    <td class="p-1 border border-gray-200 h-24 align-top relative">
                                        <div
                                            @if($slotData['status'] === 'free')
                                                wire:click="openAddModal('{{ $day }}', '{{ $time }}')"
                                            @endif
                                            class="w-full h-full rounded flex flex-col items-center justify-center text-center p-2 transition duration-150 ease-in-out {{ $slotData['bg'] }} {{ $slotData['text_color'] }}"
                                        >
                                            @if($slotData['status'] === 'free')
                                                <span class="text-3xl font-light text-gray-300 hover:text-indigo-500">+</span>
                                            @else
                                                <span class="font-bold text-xs leading-tight block mb-1">
                                                    {{ $slotData['title'] }}
                                                </span>
                                                @if($slotData['subtitle'])
                                                    <span class="text-[10px] leading-tight opacity-90 block">
                                                        {{ $slotData['subtitle'] }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Schedule Modal -->
    <div x-show="openModal"
         style="display: none;"
         class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openModal = false" aria-hidden="true"></div>
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
                                @error('newSchedule.subject') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label :value="__('Teacher')" />
                                <select wire:model="newSchedule.teacher" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Teacher</option>
                                    @foreach($teachers as $teach)
                                        <option value="{{ $teach }}">{{ $teach }}</option>
                                    @endforeach
                                </select>
                                @error('newSchedule.teacher') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                            @error('newSchedule.days') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Time & Room -->
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label :value="__('Start Time')" />
                                <x-text-input wire:model="newSchedule.time_start" type="time" class="block mt-1 w-full" />
                                @error('newSchedule.time_start') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <x-input-label :value="__('End Time')" />
                                <x-text-input wire:model="newSchedule.time_end" type="time" class="block mt-1 w-full" />
                                @error('newSchedule.time_end') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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
                        Save Class
                    </button>
                    <button @click="openModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
