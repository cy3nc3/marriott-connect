<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Step 1: Student Selector -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent p-6">
            <div class="flex items-end gap-4">
                <div class="flex-1">
                    <x-input-label for="studentQuery" :value="__('Find Student')" />
                    <div class="relative mt-1">
                        <x-text-input wire:model="studentQuery" id="studentQuery" class="block w-full" type="text" placeholder="Search by name or LRN..." />
                        <button wire:click="selectStudent" class="absolute right-2 top-1.5 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium text-sm">
                            Search
                        </button>
                    </div>
                </div>
            </div>

            @if($selectedStudent)
                <div class="mt-6 flex items-center justify-between p-4 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg border border-indigo-100 dark:border-indigo-800">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-indigo-200 dark:bg-indigo-700 flex items-center justify-center text-indigo-700 dark:text-indigo-200 font-bold text-xl">
                            {{ substr($selectedStudent['name'], 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $selectedStudent['name'] }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-300">{{ $selectedStudent['current_level'] }} • LRN: {{ $selectedStudent['lrn'] }}</p>
                        </div>
                    </div>
                    <div>
                        <button class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class='bx bx-printer mr-2 text-lg'></i> Print SF10
                        </button>
                    </div>
                </div>
            @endif
        </div>

        @if($selectedStudent)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Step 2: History Grid -->
                <div class="lg:col-span-2 space-y-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Academic History</h3>

                    @foreach($history as $record)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
                                <div>
                                    <h4 class="text-md font-bold text-gray-900 dark:text-gray-100">{{ $record['grade_level'] }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $record['school_year'] }} • {{ $record['school_name'] }}</p>
                                </div>
                                <i class='bx bx-check-circle text-green-500 text-2xl'></i>
                            </div>
                            <div class="p-6">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subject</th>
                                            <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Final Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($record['subjects'] as $subject)
                                            <tr>
                                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $subject['name'] }}</td>
                                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-right">{{ $subject['grade'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Step 3: Add History Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 sticky top-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Add Historical Record</h3>

                        @if (session()->has('message'))
                            <div class="bg-green-100 dark:bg-green-900/50 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4 text-xs">
                                <span class="font-bold block mb-1">Success!</span>
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="newSchoolName" :value="__('School Name')" />
                                <x-text-input wire:model.blur="newSchoolName" id="newSchoolName" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('newSchoolName')" class="mt-1" />
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <x-input-label for="newSchoolYear" :value="__('SY')" />
                                    <x-text-input wire:model.blur="newSchoolYear" id="newSchoolYear" class="block mt-1 w-full" type="text" placeholder="202X-202X" />
                                    <x-input-error :messages="$errors->get('newSchoolYear')" class="mt-1" />
                                </div>
                                <div>
                                    <x-input-label for="newGradeLevel" :value="__('Level')" />
                                    <select wire:model.blur="newGradeLevel" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option>Grade 7</option>
                                        <option>Grade 8</option>
                                        <option>Grade 9</option>
                                        <option>Grade 10</option>
                                    </select>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subjects & Grades</label>
                                @foreach($newSubjects as $index => $subject)
                                    <div class="flex gap-2 mb-2">
                                        <div class="w-2/3">
                                            <input type="text" wire:model.blur="newSubjects.{{ $index }}.name" placeholder="Subject" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm" />
                                            @error("newSubjects.{$index}.name") <span class="text-xs text-red-500">Required</span> @enderror
                                        </div>
                                        <div class="w-1/3">
                                            <input type="number" wire:model.blur="newSubjects.{{ $index }}.grade" placeholder="Grade" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm" />
                                            @error("newSubjects.{$index}.grade") <span class="text-xs text-red-500">Req</span> @enderror
                                        </div>
                                        @if($index > 0)
                                            <button wire:click="removeSubjectRow({{ $index }})" class="text-red-500 hover:text-red-700 dark:hover:text-red-400">
                                                <i class='bx bx-x text-xl'></i>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                                <button wire:click="addSubjectRow" class="text-indigo-600 dark:text-indigo-400 text-sm hover:underline mt-1 flex items-center">
                                    <i class='bx bx-plus mr-1'></i> Add Subject
                                </button>
                            </div>

                            <x-primary-button wire:click="saveRecord" class="w-full justify-center mt-4">
                                Save Record
                            </x-primary-button>
                        </div>
                    </div>
                </div>

            </div>
        @endif

    </div>
</div>
