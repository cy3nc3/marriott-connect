<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Card 1: My Schedule Today -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">My Schedule Today</h3>
            <ul class="divide-y divide-gray-200">
                @foreach($data['schedule'] as $class)
                    <li class="py-3 flex justify-between">
                        <span class="font-medium text-gray-800">{{ $class['time'] }}</span>
                        <span class="text-gray-600">{{ $class['subject'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Card 2: Action Required -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-yellow-500 p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-error text-2xl text-yellow-600'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-yellow-800">Action Required</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>You have <span class="font-bold">{{ $data['pending_grades'] }}</span> subjects pending Grade Submission.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
