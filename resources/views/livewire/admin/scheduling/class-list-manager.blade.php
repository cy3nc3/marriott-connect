<div class="min-h-screen">
    <style>
        @media print {
            /* Hide UI Elements */
            nav, .sidebar, header, .no-print, footer, aside, .screen-only {
                display: none !important;
            }

            /* Reset Layout */
            body, .min-h-screen {
                background-color: white !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: 100% !important;
                display: block !important;
            }

            /* Report Container */
            .print-container {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 20px !important;
                box-shadow: none !important;
                border: none !important;
                display: block !important;
            }

            /* Ensure Text Colors */
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: black !important;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col items-center">

        <!-- SCREEN VIEW: Filter Bar & Management Table -->
        <div class="screen-only w-full space-y-6">

            <!-- Filter Bar -->
            <div class="bg-white border border-gray-300/75 dark:bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                    <!-- Grade Level -->
                    <div class="w-full md:w-48">
                        <label for="grade-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Grade Level</label>
                        <select id="grade-select" wire:model.live="selectedGrade" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade }}">Grade {{ $grade }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="w-full md:w-48">
                        <label for="section-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Section</label>
                        <select id="section-select" wire:model.live="selectedSection" {{ empty($selectedGrade) ? 'disabled' : '' }} class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:bg-gray-100 disabled:text-gray-400 dark:disabled:bg-gray-700 dark:disabled:text-gray-500">
                            <option value="">Select Section</option>
                            @foreach($availableSections as $section)
                                <option value="{{ $section }}">{{ $section }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Print Action -->
                <button onclick="window.print()" {{ empty($selectedSection) ? 'disabled' : '' }} class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 disabled:cursor-not-allowed transition ease-in-out duration-150">
                    <i class='bx bx-printer mr-2 text-lg'></i> Print Class List
                </button>
            </div>

            <!-- Management Table -->
            @if($selectedGrade && $selectedSection)
                <div class="bg-white border border-gray-300/75 dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg dark:border-transparent">
                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                Student List: <span class="text-indigo-600 dark:text-indigo-400">Grade {{ $selectedGrade }} - {{ $selectedSection }}</span>
                            </h3>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Students: {{ count($filteredStudents) }}</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">LRN</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gender</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($filteredStudents as $student)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $student['lrn'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $student['name'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $student['gender'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $student['status'] === 'Enrolled' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                                    {{ $student['status'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">No students found in this class.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white border border-gray-300/75 dark:bg-gray-800 rounded-lg shadow-lg p-12 text-center">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class='bx bx-search-alt text-5xl'></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No Class Selected</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select a Grade Level and Section to view the class list.</p>
                </div>
            @endif

        </div>

        <!-- PRINT VIEW (Hidden on Screen, Visible on Print) -->
        <div class="hidden print-container bg-white shadow-lg w-[210mm] min-h-[297mm] p-[20mm] text-gray-900 relative">
             @if($selectedGrade && $selectedSection)
                <!-- Header -->
                <div class="flex items-center justify-center border-b-2 border-gray-800 pb-6 mb-6">
                    <div class="mr-4">
                        <x-application-logo class="block h-20 w-auto fill-current text-gray-800" />
                    </div>
                    <div class="text-center">
                        <h1 class="text-3xl font-bold uppercase tracking-wide">Official Class List</h1>
                        <p class="text-lg font-semibold mt-1">Marriott Connect School System</p>
                        <p class="text-sm mt-1">School Year 2025 - 2026</p>
                    </div>
                </div>

                <!-- Subheader -->
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <span class="block text-xs uppercase text-gray-500 font-bold">Grade & Section</span>
                        <span class="text-2xl font-bold">Grade {{ $selectedGrade }} - {{ $selectedSection }}</span>
                    </div>
                    <div class="text-right">
                        <span class="block text-xs uppercase text-gray-500 font-bold">Class Adviser</span>
                        <span class="text-xl font-medium">{{ $printData['adviser'] }}</span>
                    </div>
                </div>

                <!-- Columns Layout -->
                <div class="grid grid-cols-2 gap-12">

                    <!-- BOYS Column -->
                    <div>
                        <div class="border-b border-gray-400 mb-4 pb-2">
                            <h3 class="font-bold text-lg text-center uppercase tracking-wider">Boys</h3>
                        </div>
                        <ol class="list-decimal list-inside space-y-2 text-sm">
                            @foreach($printData['boys'] as $boy)
                                <li class="pl-2 border-b border-dotted border-gray-200 py-1">{{ $boy['name'] }}</li>
                            @endforeach
                        </ol>
                        <div class="mt-4 text-xs font-bold text-gray-500 text-right">
                            Total: {{ count($printData['boys']) }}
                        </div>
                    </div>

                    <!-- GIRLS Column -->
                    <div>
                        <div class="border-b border-gray-400 mb-4 pb-2">
                            <h3 class="font-bold text-lg text-center uppercase tracking-wider">Girls</h3>
                        </div>
                        <ol class="list-decimal list-inside space-y-2 text-sm">
                            @foreach($printData['girls'] as $girl)
                                <li class="pl-2 border-b border-dotted border-gray-200 py-1">{{ $girl['name'] }}</li>
                            @endforeach
                        </ol>
                        <div class="mt-4 text-xs font-bold text-gray-500 text-right">
                            Total: {{ count($printData['girls']) }}
                        </div>
                    </div>

                </div>

                <!-- Summary / Footer -->
                <div class="mt-16 pt-8 border-t border-gray-300">
                    <div class="flex justify-between text-sm text-gray-500">
                        <p>Total Students: <span class="font-bold text-gray-900">{{ count($filteredStudents) }}</span></p>
                        <p>Generated by MarriottConnect on {{ $dateGenerated }}</p>
                    </div>
                    <div class="mt-12 flex justify-end">
                        <div class="text-center w-64">
                            <div class="border-b border-black mb-2"></div>
                            <p class="text-xs uppercase font-bold">Registrar / School Administrator</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
