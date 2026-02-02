@php
    $wwCols = collect($columns)->where('type', 'ww');
    $ptCols = collect($columns)->where('type', 'pt');
    $qaCols = collect($columns)->where('type', 'qa');
@endphp

<div class="">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

            <!-- Control Bar -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex flex-wrap gap-4 items-center w-full md:w-auto">
                    <!-- Quarter -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Quarter</label>
                        <select wire:model.live="quarter" class="mt-1 block w-32 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 sm:text-sm">
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                        </select>
                    </div>

                    <!-- Grade -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Grade</label>
                        <select wire:model.live="grade" class="mt-1 block w-32 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 sm:text-sm">
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                        </select>
                    </div>

                    <!-- Section -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Section</label>
                        <select wire:model.live="section" class="mt-1 block w-40 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 sm:text-sm">
                            <option value="Rizal">Rizal</option>
                            <option value="Bonifacio">Bonifacio</option>
                            <option value="Newton">Newton</option>
                            <option value="Einstein">Einstein</option>
                            <option value="Dalton">Dalton</option>
                            <option value="Tesla">Tesla</option>
                        </select>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-300 uppercase">Subject</label>
                        <select wire:model.live="subject" class="mt-1 block w-40 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 sm:text-sm">
                            <option value="Math">Math</option>
                            <option value="Science">Science</option>
                            <option value="English">English</option>
                            <option value="Filipino">Filipino</option>
                        </select>
                    </div>
                </div>

                <!-- Add Entry Button -->
                <div>
                     <button
                        wire:click="openAddModal"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150"
                        @if(!$showData) disabled @endif
                     >
                        <i class='bx bx-plus mr-2'></i> Add Entry
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="overflow-x-auto relative min-h-[400px]">
                @if($showData)
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <!-- Header Row 1 -->
                            <tr>
                                <th rowspan="2" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider sticky left-0 bg-gray-50 dark:bg-gray-700 z-20 border-r border-gray-200 dark:border-gray-600">
                                    Student Name
                                </th>

                                <!-- Written Works Header -->
                                @if($wwCols->count() > 0)
                                    <th colspan="{{ $wwCols->count() }}" class="px-3 py-2 text-center text-xs font-bold text-white uppercase tracking-wider bg-blue-500 dark:bg-blue-600 border-l border-white dark:border-gray-600">
                                        Written Works (40%)
                                    </th>
                                @endif

                                <!-- Performance Tasks Header -->
                                @if($ptCols->count() > 0)
                                    <th colspan="{{ $ptCols->count() }}" class="px-3 py-2 text-center text-xs font-bold text-white uppercase tracking-wider bg-green-500 dark:bg-green-600 border-l border-white dark:border-gray-600">
                                        Performance Tasks (40%)
                                    </th>
                                @endif

                                <!-- QA Header -->
                                @if($qaCols->count() > 0)
                                    <th colspan="{{ $qaCols->count() }}" class="px-3 py-2 text-center text-xs font-bold text-white uppercase tracking-wider bg-purple-500 dark:bg-purple-600 border-l border-white dark:border-gray-600">
                                        Quarterly Assessment (20%)
                                    </th>
                                @endif

                                <th rowspan="2" class="px-6 py-3 text-center text-xs font-bold text-indigo-700 dark:text-indigo-300 uppercase tracking-wider bg-indigo-50 dark:bg-indigo-900 sticky right-0 z-20 border-l border-gray-200 dark:border-gray-600">
                                    Initial Grade
                                </th>
                            </tr>

                            <!-- Header Row 2 -->
                            <tr>
                                <!-- WW Columns -->
                                @foreach($wwCols as $col)
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-600 dark:text-gray-300 bg-blue-50 dark:bg-blue-900/50 border-r border-white dark:border-gray-600 min-w-[100px]">
                                        <div class="flex flex-col">
                                            <span class="font-bold truncate max-w-[120px]" title="{{ $col['name'] }}">{{ $col['name'] }}</span>
                                            <span class="text-[10px] text-gray-400">/ {{ $col['max'] }} pts</span>
                                        </div>
                                    </th>
                                @endforeach

                                <!-- PT Columns -->
                                @foreach($ptCols as $col)
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-600 dark:text-gray-300 bg-green-50 dark:bg-green-900/50 border-r border-white dark:border-gray-600 min-w-[100px]">
                                        <div class="flex flex-col">
                                            <span class="font-bold truncate max-w-[120px]" title="{{ $col['name'] }}">{{ $col['name'] }}</span>
                                            <span class="text-[10px] text-gray-400">/ {{ $col['max'] }} pts</span>
                                        </div>
                                    </th>
                                @endforeach

                                <!-- QA Columns -->
                                @foreach($qaCols as $col)
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-600 dark:text-gray-300 bg-purple-50 dark:bg-purple-900/50 border-r border-white dark:border-gray-600 min-w-[100px]">
                                        <div class="flex flex-col">
                                            <span class="font-bold truncate max-w-[120px]" title="{{ $col['name'] }}">{{ $col['name'] }}</span>
                                            <span class="text-[10px] text-gray-400">/ {{ $col['max'] }} pts</span>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($students as $index => $student)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 sticky left-0 bg-white dark:bg-gray-800 z-10 border-r border-gray-100 dark:border-gray-700">
                                        {{ $student['name'] }}
                                    </td>

                                    <!-- WW Scores -->
                                    @foreach($wwCols as $col)
                                        <td class="px-2 py-2 whitespace-nowrap text-center">
                                            <input type="number"
                                                   wire:model.blur="students.{{ $index }}.scores.{{ $col['id'] }}"
                                                   class="w-20 text-center text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                                   min="0" max="{{ $col['max'] }}">
                                        </td>
                                    @endforeach

                                    <!-- PT Scores -->
                                    @foreach($ptCols as $col)
                                        <td class="px-2 py-2 whitespace-nowrap text-center">
                                            <input type="number"
                                                   wire:model.blur="students.{{ $index }}.scores.{{ $col['id'] }}"
                                                   class="w-20 text-center text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 rounded-md focus:ring-green-500 focus:border-green-500"
                                                   min="0" max="{{ $col['max'] }}">
                                        </td>
                                    @endforeach

                                    <!-- QA Scores -->
                                    @foreach($qaCols as $col)
                                        <td class="px-2 py-2 whitespace-nowrap text-center">
                                            <input type="number"
                                                   wire:model.blur="students.{{ $index }}.scores.{{ $col['id'] }}"
                                                   class="w-20 text-center text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 rounded-md focus:ring-purple-500 focus:border-purple-500"
                                                   min="0" max="{{ $col['max'] }}">
                                        </td>
                                    @endforeach

                                    <!-- Initial Grade -->
                                    <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-bold {{ $student['grade'] < 75 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }} bg-indigo-50 dark:bg-indigo-900 sticky right-0 z-10 border-l border-gray-200 dark:border-gray-600">
                                        {{ number_format($student['grade'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="flex items-center justify-center w-20 h-20 bg-indigo-100 rounded-full mb-6">
                            <i class='bx bx-spreadsheet text-indigo-500 text-4xl'></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">Select a Class to Start Grading</h3>
                        <p class="text-gray-500 max-w-sm mb-6">
                            Please select <b>Grade 7</b>, <b>Rizal</b>, and <b>Math</b> to view the grading sheet.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Add Entry Modal -->
    <div x-data="{ show: @entangle('showAddModal') }" x-show="show" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Add New Activity
                    </h3>
                    <div class="mt-4 space-y-4">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Activity Title</label>
                            <input type="text" wire:model="newActivityTitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., Quiz 3">
                            @error('newActivityTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type</label>
                            <select wire:model="newActivityType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="ww">Written Work (WW)</option>
                                <option value="pt">Performance Task (PT)</option>
                                <option value="qa">Quarterly Assessment (QA)</option>
                            </select>
                        </div>

                        <!-- Max Points -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Max Points</label>
                            <input type="number" wire:model="newActivityMax" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="1">
                            @error('newActivityMax') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="saveEntry" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save Activity
                    </button>
                    <button wire:click="$set('showAddModal', false)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
