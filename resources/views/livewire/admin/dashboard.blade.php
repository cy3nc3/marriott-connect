<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Card 1: Enrollment Forecast -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">Enrollment Forecast</h3>
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Current Enrollees</div>
                    <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $data['current_enrollees'] }}</div>
                </div>
                <div class="text-center">
                    <div class="text-green-600 dark:text-green-400 font-bold text-lg bg-green-50 dark:bg-green-900/30 px-3 py-1 rounded-full">+15% Growth</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Projected Next Year</div>
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $data['forecast_next_year'] }}</div>
                </div>
            </div>
        </div>

        <!-- Card 2: Collection Overview -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4">Collection Overview</h3>

            <div class="space-y-4">
                <!-- Collected Bar -->
                <div>
                    <div class="flex justify-between text-sm font-medium mb-1">
                        <span class="text-gray-700 dark:text-gray-300">Collected</span>
                        <span class="text-green-600 dark:text-green-400">₱ {{ number_format($data['collected']) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                        <div class="bg-green-500 dark:bg-green-500 h-4 rounded-full" style="width: 60%"></div> <!-- Mock 60% -->
                    </div>
                </div>

                <!-- Outstanding Receivables Bar -->
                <div>
                    <div class="flex justify-between text-sm font-medium mb-1">
                        <span class="text-gray-700 dark:text-gray-300">Outstanding Receivables</span>
                        <span class="text-orange-500 dark:text-orange-400">₱ {{ number_format($data['receivables']) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                        <div class="bg-orange-400 dark:bg-orange-400 h-4 rounded-full" style="width: 40%"></div> <!-- Mock 40% -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
