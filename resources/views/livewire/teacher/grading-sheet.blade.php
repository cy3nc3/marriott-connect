<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <!-- Controls -->
            <div class="p-6 border-b border-gray-200 bg-gray-50 flex gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Section</label>
                    <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option>{{ $section }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                    <select class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option>{{ $subject }}</option>
                    </select>
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
                                            class="w-20 text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
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
</div>
