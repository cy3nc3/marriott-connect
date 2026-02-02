<div class="">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Card 1: My Schedule Today -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent p-6 transition-colors duration-300">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">My Schedule Today</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($data['schedule'] as $class)
                    <li class="py-3 flex justify-between">
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $class['time'] }}</span>
                        <span class="text-gray-600 dark:text-gray-400">{{ $class['subject'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Card 2: Action Required -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent border-l-4 border-yellow-500 dark:border-yellow-600 p-6 transition-colors duration-300">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-error text-2xl text-yellow-600 dark:text-yellow-400'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">Action Required</h3>
                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                        <p>You have <span class="font-bold">{{ $data['pending_grades'] }}</span> subjects pending Grade Submission.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
