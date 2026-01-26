<div class="py-12" x-data="{ tab: 'grades' }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Advisory Board</h2>
                <p class="text-gray-600">Advisory Class: <span class="font-semibold text-indigo-600">Grade 10 - Rizal</span></p>
            </div>
            <button wire:click="releaseReportCards"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class='bx bx-send mr-2'></i> Release Report Cards
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Tabs Navigation -->
        <div class="mb-4 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="tab = 'grades'"
                   :class="{ 'border-indigo-500 text-indigo-600': tab === 'grades', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'grades' }"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                   Consolidated Grades
                </button>
                <button @click="tab = 'values'"
                   :class="{ 'border-indigo-500 text-indigo-600': tab === 'values', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'values' }"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                   Conduct / Values Grading
                </button>
            </nav>
        </div>

        <!-- Tab 1: Consolidated Grades -->
        <div x-show="tab === 'grades'" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">Student Name</th>
                            @php
                                // Get subjects from the first student as headers
                                $subjects = array_keys($students[0]['grades']);
                            @endphp
                            @foreach($subjects as $subject)
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $subject }}</th>
                            @endforeach
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Average</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($studentsWithAverages as $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10">{{ $student['name'] }}</td>
                                @foreach($student['grades'] as $grade)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center {{ $grade < 75 ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                        {{ $grade }}
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold {{ $student['average'] < 75 ? 'text-red-600' : 'text-indigo-600' }}">
                                    {{ number_format($student['average'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 2: Conduct/Values Grading -->
        <div x-show="tab === 'values'" style="display: none;" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Student Name</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Maka-Diyos</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Makatao</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Makakalikasan</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Makabansa</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $index => $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student['name'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:model="students.{{ $index }}.behavior.Maka-Diyos" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center">
                                        <option value="AO">AO</option>
                                        <option value="SO">SO</option>
                                        <option value="RO">RO</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:model="students.{{ $index }}.behavior.Makatao" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center">
                                        <option value="AO">AO</option>
                                        <option value="SO">SO</option>
                                        <option value="RO">RO</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:model="students.{{ $index }}.behavior.Makakalikasan" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center">
                                        <option value="AO">AO</option>
                                        <option value="SO">SO</option>
                                        <option value="RO">RO</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:model="students.{{ $index }}.behavior.Makabansa" class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center">
                                        <option value="AO">AO</option>
                                        <option value="SO">SO</option>
                                        <option value="RO">RO</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-gray-50 border-t border-gray-200 text-sm text-gray-500 flex justify-between items-center">
                <span>Legend: <strong>AO</strong> (Always Observed), <strong>SO</strong> (Sometimes Observed), <strong>RO</strong> (Rarely Observed), <strong>NO</strong> (Not Observed)</span>
                <span class="text-xs italic text-gray-400">Changes are saved automatically to local state.</span>
            </div>
        </div>
    </div>
</div>
