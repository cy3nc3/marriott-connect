<div class="max-w-4xl mx-auto py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Official Report Preview:
                @if($type === 'SF1') School Form 1 (School Register)
                @elseif($type === 'SF5') School Form 5 (Report on Promotion)
                @elseif($type === 'SF10') School Form 10 (Learner's Permanent Record)
                @else {{ $type }}
                @endif
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                @if($type === 'SF1' || $type === 'SF5')
                    Grade {{ $grade }} - Section {{ $section }}
                @elseif($type === 'SF10')
                    Student: {{ $student ?: 'N/A' }}
                @endif
            </p>
        </div>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex items-center print:hidden">
            <i class='bx bx-printer mr-2'></i> Print to PDF
        </button>
    </div>

    <!-- Report Container (Paper View) -->
    <div class="bg-white shadow-lg p-12 min-h-[800px] border border-gray-200">
        <!-- Letterhead Placeholder -->
        <div class="text-center mb-10 border-b-2 border-gray-800 pb-4">
            <h2 class="text-xl font-bold uppercase">Department of Education</h2>
            <h3 class="text-lg">National Capital Region</h3>
            <h3 class="text-lg">Division</h3>
            <h2 class="text-2xl font-bold mt-2">MARRIOTT SCHOOL</h2>
        </div>

        <!-- Dynamic Content Placeholder -->
        <div class="flex flex-col items-center justify-center h-96 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
            <i class='bx bx-file-blank text-6xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg font-medium text-center">
                Generated content for
                <span class="font-bold text-gray-700">
                     @if($type === 'SF1') School Form 1 (SF1)
                    @elseif($type === 'SF5') School Form 5 (SF5)
                    @elseif($type === 'SF10') School Form 10 (SF10)
                    @else {{ $type }}
                    @endif
                </span>
                will appear here.
            </p>
            <p class="text-gray-400 text-sm mt-2">
                @if($type === 'SF1' || $type === 'SF5')
                    Dataset: Grade {{ $grade }} - Section {{ $section }}
                @elseif($type === 'SF10')
                    Target Student: {{ $student ?: 'All Records' }}
                @endif
            </p>
        </div>

        <!-- Footer Placeholder -->
        <div class="mt-20 flex justify-between">
            <div class="text-center">
                <div class="w-48 border-t border-gray-800 mt-8 pt-2">Prepared by:</div>
            </div>
             <div class="text-center">
                <div class="w-48 border-t border-gray-800 mt-8 pt-2">Certified Correct:</div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .max-w-4xl, .max-w-4xl * {
                visibility: visible;
            }
            .max-w-4xl {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }
            button {
                display: none !important;
            }
        }
    </style>
</div>
