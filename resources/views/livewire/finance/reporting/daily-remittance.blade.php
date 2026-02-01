<div class="">
    <style>
        @media print {
            /* Hide non-printable elements */
            nav, .sidebar, header, footer, .no-print {
                display: none !important;
            }

            /* Hide the navigation links in the main layout if they aren't wrapped in <nav> */
            aside { display: none !important; }

            /* Reset Layout for Print */
            body, .min-h-screen {
                background-color: white !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .max-w-7xl {
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .shadow-sm, .shadow {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            /* Ensure text is black */
            * {
                color: black !important;
            }

            /* Ensure big green text prints clearly (sometimes colors are stripped) */
            .print-color-green {
                color: #047857 !important; /* text-green-700 */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header & Action -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">{{ $date }}</p>
            </div>
            <button onclick="window.print()" class="no-print inline-flex items-center px-5 py-3 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                <i class='bx bx-printer mr-2 text-lg'></i> Print Z-Reading
            </button>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Collected -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500 transition-colors duration-300">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Total Collected</div>
                <div class="text-3xl font-extrabold text-green-600 dark:text-green-400 print-color-green">
                    ₱{{ number_format($totalCollected, 2) }}
                </div>
            </div>

            <!-- Cash on Hand -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 transition-colors duration-300">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Cash on Hand</div>
                <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    ₱{{ number_format($cashOnHand, 2) }}
                </div>
            </div>

            <!-- Digital/Bank -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500 transition-colors duration-300">
                <div class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Digital / Bank</div>
                <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    ₱{{ number_format($digitalTotal, 2) }}
                </div>
            </div>
        </div>

        <!-- Breakdown Table -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Collection Breakdown</h3>
            </div>
            <div class="p-6">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Transaction Count</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($breakdown as $category => $data)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-400">{{ $data['count'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-800 dark:text-gray-100">
                                    ₱{{ number_format($data['amount'], 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-gray-100">TOTAL</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-gray-900 dark:text-gray-100">
                                {{ array_sum(array_column($breakdown, 'count')) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-green-600 dark:text-green-400 print-color-green">
                                ₱{{ number_format($totalCollected, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Print Footer Signature Area (Only Visible on Print) -->
        <div class="hidden print:block mt-16 grid grid-cols-2 gap-8">
            <div class="text-center">
                <div class="border-b border-black mb-2 w-3/4 mx-auto"></div>
                <p class="text-sm">Prepared by: <strong>Finance Officer</strong></p>
            </div>
            <div class="text-center">
                <div class="border-b border-black mb-2 w-3/4 mx-auto"></div>
                <p class="text-sm">Verified by: <strong>School Treasurer</strong></p>
            </div>
        </div>

    </div>
</div>
