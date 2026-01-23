<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

    <!-- Success Message Simulation -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $step >= 1 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 bg-gray-200' }}">
                Step 1: Identity
            </span>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $step >= 2 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 bg-gray-200' }}">
                Step 2: Academic
            </span>
            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full {{ $step >= 3 ? 'text-indigo-600 bg-indigo-200' : 'text-gray-600 bg-gray-200' }}">
                Step 3: Billing
            </span>
        </div>
        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
            <div style="width: {{ ($step / 3) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 transition-all duration-500"></div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

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
                <h3 class="text-lg font-medium text-gray-900">Academic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="gradeLevel" :value="__('Grade Level')" />
                        <select wire:model="gradeLevel" id="gradeLevel" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
                        <select wire:model="section" id="section" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
                <h3 class="text-lg font-medium text-gray-900">Billing Information</h3>

                <div class="bg-indigo-50 p-4 rounded-md mb-6">
                    <p class="text-lg font-bold text-indigo-900">Total Tuition: 25,000</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="downpayment" :value="__('Downpayment Amount')" />
                        <x-text-input wire:model="downpayment" id="downpayment" class="block mt-1 w-full" type="number" placeholder="e.g. 5000" />
                        <x-input-error :messages="$errors->get('downpayment')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="paymentPlan" :value="__('Payment Plan')" />
                        <select wire:model="paymentPlan" id="paymentPlan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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

    </div>
</div>
