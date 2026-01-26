<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Card 1: Active School Year -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <div class="text-gray-500 text-sm uppercase tracking-wide font-semibold">Active School Year</div>
                <div class="mt-2 text-3xl font-bold text-gray-900">{{ $data['active_year'] }}</div>
            </div>

            <!-- Card 2: Total Users -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <div class="text-gray-500 text-sm uppercase tracking-wide font-semibold">Total Users</div>
                <div class="mt-2 text-3xl font-bold text-indigo-600">{{ $data['total_users'] }}</div>
            </div>

            <!-- Card 3: System Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <div class="text-gray-500 text-sm uppercase tracking-wide font-semibold">System Status</div>
                <div class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                    <span class="w-2 h-2 mr-2 bg-green-600 rounded-full"></span>
                    {{ $data['system_status'] }}
                </div>
            </div>

        </div>
    </div>
</div>
