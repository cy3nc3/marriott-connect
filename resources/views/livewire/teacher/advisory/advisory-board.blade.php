<div class="" x-data="{ tab: 'grades' }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Control Bar -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Advisory Section: <span class="text-indigo-600">Grade 7 - Rizal</span></h2>
                <p class="text-sm text-gray-500">View consolidated grades and manage student conduct.</p>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label for="quarter" class="text-sm font-medium text-gray-700">Quarter:</label>
                    <select id="quarter" wire:model.live="selectedQuarter" class="block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="1st">1st</option>
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                    </select>
                </div>

                <button wire:click="releaseReportCards"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class='bx bx-printer mr-2'></i> Print Report Cards
                </button>
            </div>
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
                   Academic Summary
                </button>
                <button @click="tab = 'values'"
                   :class="{ 'border-indigo-500 text-indigo-600': tab === 'values', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'values' }"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                   Conduct / Values Grading
                </button>
            </nav>
        </div>

        <!-- Tab 1: Academic Summary -->
        <div x-show="tab === 'grades'" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 shadow-sm">Student Name</th>
                            @php
                                // Get subjects from the first student as headers
                                $subjects = !empty($students) ? array_keys($students[0]['grades']) : [];
                            @endphp
                            @foreach($subjects as $subject)
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $subject }}</th>
                            @endforeach
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">General Average</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($studentsWithAverages as $student)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 shadow-sm">{{ $student['name'] }}</td>
                                @foreach($student['grades'] as $grade)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center {{ $grade < 75 ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                        {{ $grade }}
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold {{ $student['average'] < 75 ? 'text-red-600' : 'text-gray-900' }}">
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
