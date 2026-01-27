<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Batch Promotion / Retention</h2>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Filters & Table -->
            <div class="lg:col-span-2 flex flex-col space-y-6">

                <!-- Filter Section -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Select Class</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label :value="__('Current Grade Level')" />
                            <select wire:model.live="selectedGrade" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach($gradeLevels as $gl)
                                    <option value="{{ $gl }}">Grade {{ $gl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label :value="__('Section')" />
                            <select wire:model.live="selectedSection" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach($sections as $sec)
                                    <option value="{{ $sec }}">{{ $sec }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Student Table -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Student List</h3>
                        <p class="text-sm text-gray-500 mt-1">Select students to promote to the next level.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                        <!-- Select All Logic could go here -->
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Final Average</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($students as $student)
                                    @php
                                        $isRetained = $student['average'] < 75;
                                    @endphp
                                    <tr class="{{ $isRetained ? 'bg-red-50' : 'hover:bg-gray-50' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox"
                                                   value="{{ $student['id'] }}"
                                                   wire:model.live="selectedStudents"
                                                   @if($isRetained) disabled @endif
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-50 disabled:bg-gray-100">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $student['name'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-gray-700">
                                            {{ $student['average'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($isRetained)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Retained
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Promoted
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Column: Action Card -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Promotion Actions</h3>

                    <div class="space-y-4">
                        <div>
                            <x-input-label :value="__('Target Grade Level')" />
                            <select wire:model="targetGrade" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50">
                                @foreach($gradeLevels as $gl)
                                    <option value="{{ $gl }}">Grade {{ $gl }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class='bx bx-info-circle text-indigo-500'></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-indigo-700">
                                        Selected students will be tagged as <strong>'Returning'</strong> and eligible for enrollment in the selected target grade for the next School Year.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">Selected Count:</span>
                                <span class="text-lg font-bold text-gray-900">{{ count($selectedStudents) }}</span>
                            </div>
                            <button wire:click="promoteStudents"
                                    @if(count($selectedStudents) === 0) disabled @endif
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-50 transition ease-in-out duration-150">
                                Mark as Eligible
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
