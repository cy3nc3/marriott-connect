<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            DepEd Reports Dashboard
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card 1: SF1 -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col h-full border-t-4 border-indigo-500">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-500 mr-4">
                    <i class='bx bx-file text-2xl'></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">School Form 1 (SF1)</h3>
            </div>
            <p class="text-gray-600 mb-6 flex-grow">School Register - Master list of class enrollment for LIS BOSY.</p>

            <div class="space-y-4 mt-auto">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                    <select wire:model="sf1_grade" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach(range(7, 12) as $grade)
                            <option value="{{ $grade }}">Grade {{ $grade }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                    <select wire:model="sf1_section" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="A">Section A</option>
                        <option value="B">Section B</option>
                    </select>
                </div>
                <button wire:click="generateSf1" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out flex items-center justify-center">
                    <i class='bx bx-printer mr-2'></i> Generate SF1
                </button>
            </div>
        </div>

        <!-- Card 2: SF5 -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col h-full border-t-4 border-green-500">
             <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    <i class='bx bx-file text-2xl'></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">School Form 5 (SF5)</h3>
            </div>
            <p class="text-gray-600 mb-6 flex-grow">Report on Promotion - Summary of grades and promotion status for LIS EOSY.</p>

            <div class="space-y-4 mt-auto">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                    <select wire:model="sf5_grade" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        @foreach(range(7, 12) as $grade)
                            <option value="{{ $grade }}">Grade {{ $grade }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                    <select wire:model="sf5_section" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="A">Section A</option>
                        <option value="B">Section B</option>
                    </select>
                </div>
                <button wire:click="generateSf5" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out flex items-center justify-center">
                    <i class='bx bx-printer mr-2'></i> Generate SF5
                </button>
            </div>
        </div>

        <!-- Card 3: SF10 -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col h-full border-t-4 border-orange-500">
             <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-orange-100 text-orange-500 mr-4">
                    <i class='bx bx-file text-2xl'></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">School Form 10 (SF10)</h3>
            </div>
            <p class="text-gray-600 mb-6 flex-grow">Learner's Permanent Record - Individual academic history for transfers.</p>

            <div class="space-y-4 mt-auto">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search Student</label>
                    <div class="relative">
                        <input type="text" wire:model="sf10_student" placeholder="Enter student name..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-search text-gray-400'></i>
                        </div>
                    </div>
                </div>
                <button wire:click="generateSf10" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out flex items-center justify-center">
                    <i class='bx bx-printer mr-2'></i> Generate SF10
                </button>
            </div>
        </div>
    </div>
</div>
