<div class="py-12" x-data="{ confirmSubmit: false }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <!-- Controls & Status Bar -->
            <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <div class="flex gap-4 items-center">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Section</label>
                        <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" disabled>
                            <option>{{ $section }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subject</label>
                        <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" disabled>
                            <option>{{ $subject }}</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Status Badge -->
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $isSubmitted ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        <span class="w-2 h-2 mr-2 rounded-full {{ $isSubmitted ? 'bg-green-600' : 'bg-yellow-600' }}"></span>
                        Status: {{ $isSubmitted ? 'SUBMITTED' : 'DRAFT' }}
                    </span>

                    <!-- Submit Button -->
                    @if(!$isSubmitted)
                        <button @click="confirmSubmit = true" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Submit Grades
                        </button>
                    @else
                         <button disabled class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed">
                            Locked
                        </button>
                    @endif
                </div>
            </div>

            <!-- Grading Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                Student Name
                            </th>
                            @foreach($columns as $col)
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex flex-col">
                                        <span>{{ $col['name'] }}</span>
                                        <span class="text-[10px] text-gray-400">({{ $col['max'] }})</span>
                                        <span class="text-[10px] uppercase font-bold text-gray-300">{{ $col['type'] }}</span>
                                    </div>
                                </th>
                            @endforeach
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-indigo-700 uppercase tracking-wider bg-indigo-50">
                                Grade
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $index => $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-100">
                                    {{ $student['name'] }}
                                </td>
                                @foreach($columns as $col)
                                    <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <input
                                            type="number"
                                            wire:model.blur="students.{{ $index }}.scores.{{ $col['id'] }}"
                                            min="0"
                                            max="{{ $col['max'] }}"
                                            class="w-20 text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:text-gray-400"
                                            @disabled($isSubmitted)
                                        >
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold {{ $student['grade'] < 75 ? 'text-red-600' : 'text-green-600' }} bg-indigo-50">
                                    {{ number_format($student['grade'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-200 text-xs text-gray-500 text-right">
                Weights: WW (40%) | PT (40%) | QA (20%)
            </div>

        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="confirmSubmit" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="confirmSubmit" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="confirmSubmit" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class='bx bx-error text-yellow-600 text-2xl'></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Submit Grades?</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to submit? Grades will be locked and cannot be edited afterwards.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="submitGrades" @click="confirmSubmit = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Yes, Submit
                    </button>
                    <button @click="confirmSubmit = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
