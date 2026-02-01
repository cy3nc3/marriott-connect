<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Focus Card: Happening Now -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 text-center max-w-2xl mx-auto transition-colors duration-300">
            <h3 class="text-xl font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Happening Now</h3>
            <div class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ $data['current_subject'] }}
            </div>
            <div class="text-lg text-gray-600 dark:text-gray-300">
                with <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $data['teacher'] }}</span>
            </div>
        </div>

    </div>
</div>
