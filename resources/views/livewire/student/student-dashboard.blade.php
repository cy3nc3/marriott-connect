<div class="py-12" x-data="{ tab: 'schedule' }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <!-- Tabs Header -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                    <button
                        @click="tab = 'schedule'"
                        :class="tab === 'schedule' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">
                        Class Schedule
                    </button>
                    <button
                        @click="tab = 'grades'"
                        :class="tab === 'grades' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none">
                        Report Card
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="p-6">

                <!-- Schedule Tab -->
                <div x-show="tab === 'schedule'" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Daily Schedule</h3>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($schedule as $class)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $class['time'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $class['subject'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $class['teacher'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Grades Tab -->
                <div x-show="tab === 'grades'" style="display: none;" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                     <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Progress Report</h3>
                     <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Q1</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Q2</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Q3</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Q4</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Final</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($grades as $grade)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $grade['subject'] }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ $grade['q1'] ?? '-' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-700">{{ $grade['q2'] ?? '-' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $grade['q3'] ?? '-' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500">{{ $grade['q4'] ?? '-' }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-center font-bold text-indigo-600">{{ $grade['final'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
