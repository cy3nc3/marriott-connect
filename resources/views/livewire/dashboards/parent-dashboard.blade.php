<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Card 1: Student Status -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Student Status</h3>
            <p class="text-gray-700 text-lg">
                <span class="font-bold">{{ $data['child'] }}</span> is <span class="text-green-600 font-semibold">{{ $data['status'] }}</span>.
            </p>
        </div>

        <!-- Card 2: Billing Status -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Billing Status</h3>

            @if($data['billing_status'] === 'Action Needed')
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-orange-100 text-orange-800 mb-4">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Account Status: Action Required
                </div>
            @else
                <div class="text-green-600 font-bold mb-4">Account is Up to Date</div>
            @endif

            <div class="mt-2">
                <a href="#" class="text-indigo-600 hover:text-indigo-900 font-semibold underline">View Details</a>
            </div>
        </div>

    </div>
</div>
