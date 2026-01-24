<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Card 1: Collection Efficiency -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Collection Efficiency</h3>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-semibold text-gray-700">{{ $data['collection_efficiency'] }}% Collected</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-indigo-600 h-4 rounded-full" style="width: {{ $data['collection_efficiency'] }}%"></div>
            </div>
            <p class="mt-4 text-sm text-gray-500 text-center">
                {{ $data['collection_efficiency'] }}% Paid / {{ 100 - $data['collection_efficiency'] }}% Outstanding
            </p>
        </div>

        <!-- Card 2: Cash in Drawer -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
            <div class="text-gray-500 text-sm uppercase tracking-wide font-semibold">Cash in Drawer (Today)</div>
            <div class="mt-4 text-4xl font-extrabold text-green-600">
                ₱ {{ number_format($data['cash_today'], 2) }}
            </div>
        </div>

        <!-- Card 3: Revenue Forecast -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
            <div class="text-gray-500 text-sm uppercase tracking-wide font-semibold">Revenue Forecast (Next Month)</div>
            <div class="mt-4 text-3xl font-bold text-gray-800">
                ₱ {{ number_format($data['monthly_forecast']) }}
            </div>
            <p class="mt-2 text-xs text-gray-400">Based on upcoming due dates</p>
        </div>

    </div>
</div>
