<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

    <!-- Success Message (Visible in Step 4) -->
    @if ($step === 4 && session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $step >= 1 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 dark:text-gray-400 bg-gray-200 dark:bg-gray-700' }}">
                Step 1: Identity
            </span>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $step >= 2 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 dark:text-gray-400 bg-gray-200 dark:bg-gray-700' }}">
                Step 2: Academic
            </span>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $step >= 3 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 dark:text-gray-400 bg-gray-200 dark:bg-gray-700' }}">
                Step 3: Billing
            </span>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $step >= 4 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 dark:text-gray-400 bg-gray-200 dark:bg-gray-700' }}">
                Step 4: Complete
            </span>
        </div>
        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200 dark:bg-gray-700">
            <div style="width: {{ ($step / 4) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-500"></div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

        <!-- Step 1: Identity -->
        @if($step === 1)
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900">Student & Parent Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="studentName" :value="__('Student Name')" />
                        <x-text-input wire:model="studentName" id="studentName" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('studentName')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="lrn" :value="__('LRN')" />
                        <x-text-input wire:model="lrn" id="lrn" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('lrn')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="parentName" :value="__('Parent Name')" />
                        <x-text-input wire:model="parentName" id="parentName" class="block mt-1 w-full" type="text" />
                        <x-input-error :messages="$errors->get('parentName')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="parentEmail" :value="__('Parent Email')" />
                        <x-text-input wire:model="parentEmail" id="parentEmail" class="block mt-1 w-full" type="email" />
                        <x-input-error :messages="$errors->get('parentEmail')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <x-primary-button wire:click="nextStep">
                        {{ __('Next') }}
                    </x-primary-button>
                </div>
            </div>
        @endif

        <!-- Step 2: Academic -->
        @if($step === 2)
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Academic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="gradeLevel" :value="__('Grade Level')" />
                        <select wire:model="gradeLevel" id="gradeLevel" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Grade</option>
                            <option value="7">Grade 7</option>
                            <option value="8">Grade 8</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                        </select>
                        <x-input-error :messages="$errors->get('gradeLevel')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="section" :value="__('Section')" />
                        <select wire:model="section" id="section" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Section</option>
                            <option value="A">Section A</option>
                            <option value="B">Section B</option>
                            <option value="C">Section C</option>
                        </select>
                        <x-input-error :messages="$errors->get('section')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-between pt-4">
                    <x-secondary-button wire:click="previousStep">
                        {{ __('Back') }}
                    </x-secondary-button>
                    <x-primary-button wire:click="nextStep">
                        {{ __('Next') }}
                    </x-primary-button>
                </div>
            </div>
        @endif

        <!-- Step 3: Billing -->
        @if($step === 3)
            <div class="space-y-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Billing Information</h3>

                <!-- Assessment Summary Box -->
                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 p-4 rounded-md mb-6">
                    <h4 class="font-bold text-gray-700 dark:text-gray-300 mb-2 border-b dark:border-gray-600 pb-2">Assessment Summary</h4>
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                        <span>Tuition Fee</span>
                        <span>{{ number_format($tuitionFee, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                        <span>Miscellaneous Fee</span>
                        <span>{{ number_format($miscFee, 2) }}</span>
                    </div>

                    @if($discountAmount > 0)
                        <div class="flex justify-between text-sm text-red-600 font-medium mb-1">
                            <span>Less: Discount ({{ $discountType }})</span>
                            <span>-{{ number_format($discountAmount, 2) }}</span>
                        </div>
                    @endif

                    <div class="border-t border-gray-300 dark:border-gray-600 mt-2 pt-2 flex justify-between text-lg font-bold text-indigo-900 dark:text-indigo-300">
                        <span>Total Assessment</span>
                        <span>{{ number_format($totalAssessment, 2) }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Discount Field -->
                    <div>
                         <x-input-label for="discountType" :value="__('Apply Discount')" />
                        <select wire:model.live="discountType" id="discountType" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="None">None (Default)</option>
                            <option value="Sibling Discount">Sibling Discount (10% off Tuition)</option>
                            <option value="Academic Scholar">Academic Scholar (100% off Tuition)</option>
                            <option value="Employee Dependent">Employee Dependent (50% off Tuition)</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="downpayment" :value="__('Downpayment Amount')" />
                        <x-text-input wire:model="downpayment" id="downpayment" class="block mt-1 w-full" type="number" placeholder="e.g. 5000" />
                        <x-input-error :messages="$errors->get('downpayment')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="paymentPlan" :value="__('Payment Plan')" />
                        <select wire:model="paymentPlan" id="paymentPlan" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Select Plan</option>
                            <option value="Cash">Cash</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                        </select>
                        <x-input-error :messages="$errors->get('paymentPlan')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-between pt-4">
                    <x-secondary-button wire:click="previousStep">
                        {{ __('Back') }}
                    </x-secondary-button>
                    <x-primary-button wire:click="confirmEnrollment">
                        {{ __('Confirm Enrollment') }}
                    </x-primary-button>
                </div>
            </div>
        @endif

        <!-- Step 4: Success & Print -->
        @if($step === 4)
            <div class="text-center py-10 space-y-6">
                <div class="flex justify-center">
                    <div class="rounded-full bg-green-100 dark:bg-green-900 p-3">
                        <i class='bx bx-check text-4xl text-green-600 dark:text-green-300'></i>
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Enrollment Complete!</h2>
                <p class="text-gray-600 dark:text-gray-400">The student has been successfully enrolled in the system.</p>

                <div class="flex justify-center gap-4 pt-4">
                    <a href="/registrar/print-cor" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class='bx bx-printer mr-2'></i> Print COR
                    </a>

                    <x-secondary-button wire:click="enrollNext">
                        {{ __('Enroll Next Student') }}
                    </x-secondary-button>
                </div>
            </div>
        @endif

    </div>
</div>
