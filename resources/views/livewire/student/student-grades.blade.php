<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
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
