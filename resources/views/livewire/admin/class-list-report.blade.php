<div class="py-12 bg-gray-100 min-h-screen">
    <style>
        @media print {
            /* Hide UI Elements */
            nav, .sidebar, header, .no-print, footer, aside {
                display: none !important;
            }

            /* Reset Layout */
            body, .min-h-screen, .py-12 {
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

        <!-- Controls (Screen Only) -->
        <div class="no-print w-full max-w-[210mm] mb-6 flex justify-between items-center bg-white p-4 rounded-lg shadow-sm">
            <div class="flex items-center space-x-4">
                <label for="section-select" class="font-bold text-gray-700">Select Class:</label>
                <select id="section-select" wire:model.live="selectedSection" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @foreach($sections as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class='bx bx-printer mr-2 text-lg'></i> Print Class List
            </button>
        </div>

        <!-- Paper View (A4 Simulation) -->
        <div class="print-container bg-white shadow-lg w-[210mm] min-h-[297mm] p-[20mm] text-gray-900 relative">

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
                    <span class="text-2xl font-bold">{{ $currentSectionName }}</span>
                </div>
                <div class="text-right">
                    <span class="block text-xs uppercase text-gray-500 font-bold">Class Adviser</span>
                    <span class="text-xl font-medium">{{ $currentClass['adviser'] }}</span>
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
                        @foreach($currentClass['boys'] as $boy)
                            <li class="pl-2 border-b border-dotted border-gray-200 py-1">{{ $boy }}</li>
                        @endforeach
                    </ol>
                    <div class="mt-4 text-xs font-bold text-gray-500 text-right">
                        Total: {{ count($currentClass['boys']) }}
                    </div>
                </div>

                <!-- GIRLS Column -->
                <div>
                    <div class="border-b border-gray-400 mb-4 pb-2">
                        <h3 class="font-bold text-lg text-center uppercase tracking-wider">Girls</h3>
                    </div>
                    <ol class="list-decimal list-inside space-y-2 text-sm">
                        @foreach($currentClass['girls'] as $girl)
                            <li class="pl-2 border-b border-dotted border-gray-200 py-1">{{ $girl }}</li>
                        @endforeach
                    </ol>
                    <div class="mt-4 text-xs font-bold text-gray-500 text-right">
                        Total: {{ count($currentClass['girls']) }}
                    </div>
                </div>

            </div>

            <!-- Summary / Footer -->
            <div class="mt-16 pt-8 border-t border-gray-300">
                <div class="flex justify-between text-sm text-gray-500">
                    <p>Total Students: <span class="font-bold text-gray-900">{{ count($currentClass['boys']) + count($currentClass['girls']) }}</span></p>
                    <p>Generated by MarriottConnect on {{ $dateGenerated }}</p>
                </div>
                <div class="mt-12 flex justify-end">
                    <div class="text-center w-64">
                        <div class="border-b border-black mb-2"></div>
                        <p class="text-xs uppercase font-bold">Registrar / School Administrator</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
