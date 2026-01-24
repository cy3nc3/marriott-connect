<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Card 1: Enrollment Forecast -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">Enrollment Forecast</h3>
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500">Current Enrollees</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $data['current_enrollees'] }}</div>
                </div>
                <div class="text-center">
                    <div class="text-green-600 font-bold text-lg bg-green-50 px-3 py-1 rounded-full">+15% Growth</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Projected Next Year</div>
                    <div class="text-2xl font-bold text-indigo-600">{{ $data['forecast_next_year'] }}</div>
                </div>
            </div>
        </div>

        <!-- Card 2: Financial Health Overview -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2 mb-4">Financial Health Overview</h3>

            <div class="space-y-4">
                <!-- Revenue Bar -->
                <div>
                    <div class="flex justify-between text-sm font-medium mb-1">
                        <span class="text-gray-700">Revenue</span>
                        <span class="text-green-600">₱ {{ number_format($data['revenue']) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-green-500 h-4 rounded-full" style="width: 80%"></div> <!-- Mock 80% -->
                    </div>
                </div>

                <!-- Expenses Bar -->
                <div>
                    <div class="flex justify-between text-sm font-medium mb-1">
                        <span class="text-gray-700">Expenses</span>
                        <span class="text-red-600">₱ {{ number_format($data['expenses']) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-red-500 h-4 rounded-full" style="width: 60%"></div> <!-- Mock 60% relative to revenue scale -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
