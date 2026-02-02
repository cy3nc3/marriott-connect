<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Card 1: Population Density -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent p-6 transition-colors duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Population Density</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Grade 7</span>
                    <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $data['grade_7'] }} Students</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Grade 8</span>
                    <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $data['grade_8'] }} Students</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Capacity Alerts -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500 dark:border-red-600 p-6 transition-colors duration-300">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-error text-2xl text-red-600 dark:text-red-400'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-red-800 dark:text-red-200">Capacity Alert</h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p class="font-bold">{{ $data['capacity_alert'] }}</p>
                        <p class="mt-1">Action Required: Section is near capacity.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
