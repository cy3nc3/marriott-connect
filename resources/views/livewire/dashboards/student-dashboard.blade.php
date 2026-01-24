<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Focus Card: Happening Now -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center max-w-2xl mx-auto">
            <h3 class="text-xl font-medium text-gray-500 uppercase tracking-wide mb-2">Happening Now</h3>
            <div class="text-3xl font-bold text-gray-900 mb-2">
                {{ $data['current_subject'] }}
            </div>
            <div class="text-lg text-gray-600">
                with <span class="font-semibold text-indigo-600">{{ $data['teacher'] }}</span>
            </div>
        </div>

    </div>
</div>
