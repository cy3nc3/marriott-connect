<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certificate of Registration - {{ $data['studentName'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .print-container { box-shadow: none; border: none; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-3xl mx-auto my-8 bg-white p-12 shadow-lg border border-gray-200 print-container">

        <!-- Header -->
        <div class="text-center border-b-2 border-gray-800 pb-6 mb-8">
            <h1 class="text-2xl font-bold uppercase tracking-wide">Marriott School</h1>
            <p class="text-gray-600">123 Education Avenue, Metro Manila</p>
            <p class="text-gray-600">Tel: (02) 8123-4567 | Email: registrar@marriottschool.edu</p>
            <h2 class="text-xl font-bold mt-4 uppercase">Certificate of Registration</h2>
            <p class="text-sm text-gray-500">School Year 2024-2025</p>
        </div>

        <!-- Student Information -->
        <div class="mb-8">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="block text-xs text-gray-500 uppercase">Student Name</span>
                    <span class="block text-lg font-bold text-gray-900">{{ $data['studentName'] }}</span>
                </div>
                <div class="text-right">
                    <span class="block text-xs text-gray-500 uppercase">LRN</span>
                    <span class="block text-lg font-bold text-gray-900">{{ $data['lrn'] }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 uppercase">Grade & Section</span>
                    <span class="block text-lg font-bold text-gray-900">Grade {{ $data['gradeLevel'] }} - {{ $data['section'] }}</span>
                </div>
                <div class="text-right">
                    <span class="block text-xs text-gray-500 uppercase">Date Enrolled</span>
                    <span class="block text-lg font-bold text-gray-900">{{ $data['date'] }}</span>
                </div>
            </div>
        </div>

        <!-- Assessment of Fees -->
        <div class="mb-8">
            <h3 class="font-bold text-gray-800 border-b border-gray-300 pb-2 mb-4">Assessment of Fees</h3>
            <table class="w-full text-left border-collapse">
                <tbody>
                    <tr>
                        <td class="py-2 text-gray-700">Tuition Fee</td>
                        <td class="py-2 text-right text-gray-900 font-medium">{{ number_format($data['tuitionFee'], 2) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-gray-700">Miscellaneous Fee</td>
                        <td class="py-2 text-right text-gray-900 font-medium">{{ number_format($data['miscFee'], 2) }}</td>
                    </tr>
                    @if($data['discountAmount'] > 0)
                    <tr>
                        <td class="py-2 text-red-600 font-medium">
                            Less: Discount ({{ $data['discountType'] }})
                        </td>
                        <td class="py-2 text-right text-red-600 font-bold">
                            -{{ number_format($data['discountAmount'], 2) }}
                        </td>
                    </tr>
                    @endif
                    <tr class="border-t-2 border-gray-800">
                        <td class="py-3 text-lg font-bold text-gray-900">TOTAL ASSESSMENT</td>
                        <td class="py-3 text-right text-lg font-bold text-gray-900">{{ number_format($data['totalAssessment'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Plan -->
         <div class="mb-12">
            <span class="block text-xs text-gray-500 uppercase">Selected Payment Plan</span>
            <span class="block text-lg font-bold text-gray-900">{{ $data['paymentPlan'] }}</span>
        </div>


        <!-- Footer / Signatures -->
        <div class="flex justify-between mt-16">
            <div class="text-center">
                <div class="w-48 border-t border-gray-800 pt-2">
                    <p class="text-sm font-bold text-gray-900">Registrar's Office</p>
                    <p class="text-xs text-gray-500">Processed By</p>
                </div>
            </div>
            <div class="text-center">
                <div class="w-48 border-t border-gray-800 pt-2">
                    <p class="text-sm font-bold text-gray-900">Accounting Office</p>
                    <p class="text-xs text-gray-500">Verified By</p>
                </div>
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="mt-12 text-center">
             <p class="text-xs text-gray-400 italic">This document is computer generated and serves as an official proof of enrollment.</p>
        </div>

        <!-- Print Actions -->
        <div class="no-print mt-8 flex justify-center gap-4">
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow">
                Print / Save PDF
            </button>
            <button onclick="window.close()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded shadow">
                Close
            </button>
        </div>

    </div>
</body>
</html>
