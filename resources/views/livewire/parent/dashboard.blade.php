<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Card 1: Student Status -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent p-6 transition-colors duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Student Status</h3>
            <p class="text-gray-700 dark:text-gray-300 text-lg">
                <span class="font-bold">{{ $data['child'] }}</span> is <span class="text-green-600 dark:text-green-400 font-semibold">{{ $data['status'] }}</span>.
            </p>
        </div>

        <!-- Card 2: Billing Status -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent p-6 transition-colors duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Billing Status</h3>

            @if($data['billing_status'] === 'Action Needed')
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 mb-4">
                    <i class='bx bx-error-circle mr-2 text-lg'></i>
                    Account Status: Action Required
                </div>
            @else
                <div class="text-green-600 dark:text-green-400 font-bold mb-4">Account is Up to Date</div>
            @endif

            <div class="mt-2">
                <a href="{{ route('parent.billing') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold underline">View Details</a>
            </div>
        </div>

    </div>
</div>
