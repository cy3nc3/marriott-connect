<div class="p-6">
    {{-- Print Header --}}
    <div class="hidden print:block text-center mb-8">
        <div class="flex items-center justify-center mb-4">
            <x-application-logo class="h-16 w-auto fill-current text-indigo-600" />
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Marriott Connect School</h1>
        <p class="text-sm text-gray-600">123 Education St, City, Country</p>
        <p class="text-sm text-gray-600">Tel: (02) 123-4567 | Email: finance@marriott.edu</p>
        <h2 class="text-xl font-bold mt-6 uppercase border-b-2 border-gray-900 inline-block pb-1">Statement of Account</h2>
    </div>

    {{-- Search Section (Hidden on Print) --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-500/10 dark:border-transparent mb-6 print:hidden transition-colors duration-300">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Search Student</h2>
        <div class="flex gap-4">
            <input type="text"
                   wire:model="search"
                   wire:keydown.enter="searchStudent"
                   placeholder="Enter Student Name or LRN..."
                   class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <button wire:click="searchStudent"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors flex items-center">
                <i class='bx bx-search mr-2'></i> Search
            </button>
        </div>
        @if (session()->has('error'))
            <div class="mt-4 text-red-600 text-sm flex items-center">
                <i class='bx bx-error-circle mr-2'></i> {{ session('error') }}
            </div>
        @endif
    </div>

    @if($selectedStudent)
        {{-- Student Profile --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-500/10 dark:border-transparent mb-6 transition-colors duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $selectedStudent['name'] }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 mt-4 text-sm">
                        <p><span class="text-gray-500 dark:text-gray-400 font-medium">LRN:</span> <span class="dark:text-gray-300">{{ $selectedStudent['lrn'] }}</span></p>
                        <p><span class="text-gray-500 dark:text-gray-400 font-medium">Grade & Section:</span> <span class="dark:text-gray-300">{{ $selectedStudent['grade_section'] }}</span></p>
                        <p><span class="text-gray-500 dark:text-gray-400 font-medium">Guardian:</span> <span class="dark:text-gray-300">{{ $selectedStudent['guardian'] }}</span></p>
                        <p><span class="text-gray-500 dark:text-gray-400 font-medium">Contact No:</span> <span class="dark:text-gray-300">{{ $selectedStudent['contact'] }}</span></p>
                    </div>
                </div>
                <div class="text-right print:hidden">
                    <button onclick="window.print()" class="bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 px-4 py-2 rounded-md hover:bg-gray-700 dark:hover:bg-white transition-colors flex items-center ml-auto">
                        <i class='bx bx-printer mr-2'></i> Print SOA
                    </button>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Date Printed: {{ now()->format('M d, Y') }}</p>
                </div>
                <div class="hidden print:block text-right">
                     <p class="text-sm text-gray-500">Date Printed: {{ now()->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Financial Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            {{-- Total Fees --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-500/10 dark:border-transparent border-l-4 border-l-blue-500 transition-colors duration-300">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Fees Assessed</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">₱{{ number_format($selectedStudent['total_fees'], 2) }}</p>
            </div>

            {{-- Total Payments --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-500/10 dark:border-transparent border-l-4 border-l-green-500 transition-colors duration-300">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Total Payments Made</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">₱{{ number_format($selectedStudent['total_payments'], 2) }}</p>
            </div>

            {{-- Current Balance --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg border border-gray-500/10 dark:border-transparent border-l-4 {{ $selectedStudent['current_balance'] > 0 ? 'border-l-red-500' : 'border-l-green-500' }} transition-colors duration-300">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Current Balance</p>
                <p class="text-2xl font-bold mt-2 {{ $selectedStudent['current_balance'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                    ₱{{ number_format($selectedStudent['current_balance'], 2) }}
                </p>
            </div>
        </div>

        {{-- Ledger Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-500/10 dark:border-transparent overflow-hidden transition-colors duration-300">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800 dark:text-gray-100">Transaction History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Debit (+)</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Credit (-)</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Running Balance</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($selectedStudent['ledger'] as $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($row['date'])->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 font-medium">
                                    {{ $row['description'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right dark:text-gray-300">
                                    @if($row['type'] === 'Debit')
                                        {{ number_format($row['amount'], 2) }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600 dark:text-green-400 font-medium">
                                    @if($row['type'] === 'Credit')
                                        {{ number_format($row['amount'], 2) }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold {{ $row['running_balance'] > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                    {{ number_format($row['running_balance'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Print Footer --}}
        <div class="hidden print:block mt-12 text-center text-sm text-gray-500">
            <p>This is a system generated report. No signature required.</p>
        </div>
    @elseif(!empty($search) && !session('error'))
        {{-- Empty State or Initial Load instructions could go here, but focusing on simple flow --}}
    @endif

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .p-6, .p-6 * {
                visibility: visible;
            }
            .p-6 {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 2rem !important;
                background: white;
            }
            /* Explicitly hide non-printable elements again to be safe */
            .print\:hidden {
                display: none !important;
            }
            .print\:block {
                display: block !important;
            }
            /* Hide sidebar and header specifically if they are outside the p-6 container */
            aside, header, nav {
                display: none !important;
            }
        }
    </style>
</div>
