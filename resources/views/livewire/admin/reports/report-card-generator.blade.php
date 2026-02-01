<div class="min-h-screen bg-gray-100 p-6">
    {{-- Screen Only: Interface --}}
    <div class="no-print max-w-7xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">SF9 Report Card Generator</h1>
                <p class="text-sm text-gray-500">Bulk print official report cards for Card Distribution Day.</p>
            </div>
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow flex items-center gap-2 transition">
                <i class='bx bx-printer text-xl'></i> Generate PDF (Bulk Print)
            </button>
        </div>

        {{-- Filters --}}
        <div class="bg-white p-6 rounded-lg shadow grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">School Year</label>
                <select wire:model.live="schoolYear" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option>2025-2026</option>
                    <option>2024-2025</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level & Section</label>
                <select wire:model.live="gradeSection" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option>Grade 7 - Rizal</option>
                    <option>Grade 8 - Bonifacio</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quarter</label>
                <select wire:model.live="quarter" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option>1st Quarter</option>
                    <option>2nd Quarter</option>
                    <option>3rd Quarter</option>
                    <option>4th Quarter</option>
                    <option>Final</option>
                </select>
            </div>
        </div>

        {{-- Preview List --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-700">Student Preview List</h3>
                <span class="text-sm text-gray-500">{{ count($selectedStudents) }} Selected</span>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">LRN</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($students as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" wire:model.live="selectedStudents" value="{{ $student['lrn'] }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student['name'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student['lrn'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student['sex'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student['status'] === 'Complete')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Complete
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Incomplete Grades
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Print Only: Report Cards --}}
    <div class="hidden print:block font-serif text-black">
        @foreach($students as $student)
            @if(in_array($student['lrn'], $selectedStudents))

                {{-- FRONT PAGE --}}
                <div class="print-page w-full h-screen p-12 relative page-break-after flex flex-col">
                    {{-- Header --}}
                    <div class="text-center mb-8">
                        <div class="flex justify-center mb-2">
                             <x-application-logo class="block h-16 w-auto fill-current text-black" />
                        </div>
                        <h2 class="text-xl font-bold uppercase">Department of Education</h2>
                        <h3 class="text-lg">National Capital Region</h3>
                        <h3 class="text-lg font-bold">MARRIOTT SCHOOL</h3>
                        <p class="text-sm">123 Education St., Learning City</p>
                    </div>

                    <div class="text-center mb-8 border-b-2 border-black pb-4">
                        <h1 class="text-3xl font-bold uppercase tracking-wide">Learner's Progress Report Card (SF9)</h1>
                        <p class="font-bold text-lg mt-2">School Year: {{ $student['school_year'] }}</p>
                    </div>

                    {{-- Student Info --}}
                    <div class="grid grid-cols-2 gap-x-8 gap-y-4 text-sm mb-8">
                        <div><span class="font-bold">Name:</span> {{ $student['name'] }}</div>
                        <div><span class="font-bold">Learner Reference Number (LRN):</span> {{ $student['lrn'] }}</div>
                        <div><span class="font-bold">Age:</span> {{ $student['age'] }}</div>
                        <div><span class="font-bold">Sex:</span> {{ $student['sex'] }}</div>
                        <div><span class="font-bold">Grade:</span> {{ $student['grade_section'] }}</div>
                        <div><span class="font-bold">Section:</span> {{ explode(' - ', $student['grade_section'])[1] ?? '' }}</div>
                    </div>

                    {{-- Attendance Record --}}
                    <div class="mb-8">
                        <h3 class="font-bold text-center uppercase mb-2">Report on Attendance</h3>
                        <table class="w-full border-collapse border border-black text-xs text-center">
                            <thead>
                                <tr>
                                    <th class="border border-black p-1">Month</th>
                                    @foreach(array_keys($student['attendance']) as $month)
                                        <th class="border border-black p-1">{{ $month }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-black p-1 font-bold text-left pl-2">Days of School</td>
                                    @foreach($student['attendance'] as $data)
                                        <td class="border border-black p-1">{{ $data['days'] }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="border border-black p-1 font-bold text-left pl-2">Days Present</td>
                                    @foreach($student['attendance'] as $data)
                                        <td class="border border-black p-1">{{ $data['present'] }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="border border-black p-1 font-bold text-left pl-2">Days Absent</td>
                                    @foreach($student['attendance'] as $data)
                                        <td class="border border-black p-1">{{ $data['days'] - $data['present'] }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Parent Signature Mock --}}
                    <div class="mt-auto">
                        <h3 class="font-bold uppercase text-sm mb-4">Parent/Guardian's Signature</h3>
                        <div class="grid grid-cols-4 gap-4 text-xs">
                            <div>
                                <div class="border-b border-black h-8"></div>
                                <div class="text-center mt-1">1st Quarter</div>
                            </div>
                            <div>
                                <div class="border-b border-black h-8"></div>
                                <div class="text-center mt-1">2nd Quarter</div>
                            </div>
                            <div>
                                <div class="border-b border-black h-8"></div>
                                <div class="text-center mt-1">3rd Quarter</div>
                            </div>
                            <div>
                                <div class="border-b border-black h-8"></div>
                                <div class="text-center mt-1">4th Quarter</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BACK PAGE --}}
                <div class="print-page w-full h-screen p-12 relative page-break-after flex flex-col">

                    {{-- Grades --}}
                    <div class="mb-8">
                        <h3 class="font-bold text-center uppercase mb-2">Report on Learning Progress</h3>
                        <table class="w-full border-collapse border border-black text-xs">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-black p-2 text-left w-1/3">Learning Areas</th>
                                    <th class="border border-black p-2 w-12">Q1</th>
                                    <th class="border border-black p-2 w-12">Q2</th>
                                    <th class="border border-black p-2 w-12">Q3</th>
                                    <th class="border border-black p-2 w-12">Q4</th>
                                    <th class="border border-black p-2 w-16">Final</th>
                                    <th class="border border-black p-2">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student['grades'] as $subject => $grades)
                                    <tr>
                                        <td class="border border-black p-1 pl-2">{{ $subject }}</td>
                                        <td class="border border-black p-1 text-center">{{ $grades['Q1'] }}</td>
                                        <td class="border border-black p-1 text-center">{{ $grades['Q2'] }}</td>
                                        <td class="border border-black p-1 text-center">{{ $grades['Q3'] }}</td>
                                        <td class="border border-black p-1 text-center">{{ $grades['Q4'] }}</td>
                                        <td class="border border-black p-1 text-center font-bold">{{ $grades['Final'] }}</td>
                                        <td class="border border-black p-1 text-center text-[10px]">
                                            @if(is_numeric($grades['Final']))
                                                {{ $grades['Final'] >= 75 ? 'Passed' : 'Failed' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- General Average --}}
                                @php
                                    $finalGrades = array_column($student['grades'], 'Final');
                                    $numericGrades = array_filter($finalGrades, 'is_numeric');
                                    $average = count($numericGrades) > 0 ? round(array_sum($numericGrades) / count($numericGrades)) : '';
                                @endphp
                                <tr class="font-bold bg-gray-50">
                                    <td class="border border-black p-2 text-right">General Average</td>
                                    <td class="border border-black p-2" colspan="4"></td>
                                    <td class="border border-black p-2 text-center">{{ $average }}</td>
                                    <td class="border border-black p-2 text-center text-[10px]">
                                        {{ $average >= 75 ? 'Promoted' : ($average !== '' ? 'Retained' : '') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Values --}}
                    <div class="mb-8">
                        <h3 class="font-bold text-center uppercase mb-2">Report on Learner's Observed Values</h3>
                        <table class="w-full border-collapse border border-black text-[10px]">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-black p-1 w-20">Core Values</th>
                                    <th class="border border-black p-1 text-left">Behavior Statements</th>
                                    <th class="border border-black p-1 w-8">Q1</th>
                                    <th class="border border-black p-1 w-8">Q2</th>
                                    <th class="border border-black p-1 w-8">Q3</th>
                                    <th class="border border-black p-1 w-8">Q4</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student['values'] as $coreValue => $behaviors)
                                    @foreach($behaviors as $index => $behavior)
                                        <tr>
                                            @if($index === 0)
                                                <td class="border border-black p-1 font-bold align-middle text-center uppercase" rowspan="{{ count($behaviors) }}">
                                                    {{ $coreValue }}
                                                </td>
                                            @endif
                                            <td class="border border-black p-1">{{ $behavior['statement'] }}</td>
                                            <td class="border border-black p-1 text-center">{{ $behavior['Q1'] }}</td>
                                            <td class="border border-black p-1 text-center">{{ $behavior['Q2'] }}</td>
                                            <td class="border border-black p-1 text-center">{{ $behavior['Q3'] }}</td>
                                            <td class="border border-black p-1 text-center">{{ $behavior['Q4'] }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Signatures --}}
                    <div class="mt-auto flex justify-between items-end px-12">
                         <div class="text-center">
                            <div class="border-b border-black w-48 mb-2"></div>
                            <p class="text-xs font-bold uppercase">Class Adviser</p>
                        </div>
                        <div class="text-center">
                            <div class="border-b border-black w-48 mb-2"></div>
                            <p class="text-xs font-bold uppercase">School Principal</p>
                        </div>
                    </div>

                </div>

            @endif
        @endforeach
    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            @page { margin: 0; size: auto; }
            body { background: white; -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
            .print-page {
                display: flex !important;
                height: 100vh !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 40px !important;
            }
            .page-break-after { break-after: page; page-break-after: always; }
        }
    </style>
</div>
