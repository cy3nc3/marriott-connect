<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent">
            <div class="p-6">
                 <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">Progress Report</h3>
                 <div class="overflow-x-auto border dark:border-gray-700 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subject</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Q1</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Q2</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Q3</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Q4</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Final</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($grades as $grade)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $grade['subject'] }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-700 dark:text-gray-300">{{ $grade['q1'] ?? '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-700 dark:text-gray-300">{{ $grade['q2'] ?? '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">{{ $grade['q3'] ?? '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">{{ $grade['q4'] ?? '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-center font-bold text-indigo-600 dark:text-indigo-400">{{ $grade['final'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
