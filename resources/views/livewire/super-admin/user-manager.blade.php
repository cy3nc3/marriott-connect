<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <!-- Success Message Simulation -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif



    <!-- User Table -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-500/10 dark:border-transparent transition-colors duration-300">
        <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Placeholder</h3>
                    <x-primary-button wire:click="openCreateModal">
                        <i class='bx bx-plus mr-2'></i> {{ __('Create User') }}
                    </x-primary-button>
                </div>
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Permissions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($users as $loop_index => $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $user['name'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $user['email'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                    {{ $user['role'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(!empty($user['grant_enrollment_access']))
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Enrollment Agent
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="editUser({{ $loop_index }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                <button wire:click="openResetModal({{ $loop_index }})" class="text-orange-500 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300">
                                    <i class='bx bx-key text-xl'></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reset Password Modal -->
    @if($showResetModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4" id="modal-title">
                        Reset Password for {{ $resetUserName }}
                    </h3>
                    <div>
                        <x-input-label for="resetPassword" :value="__('New Password')" />
                        <x-text-input wire:model="resetPassword" id="resetPassword" class="block mt-1 w-full" type="text" />
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <x-primary-button wire:click="savePassword" class="ml-3">
                        Save New Password
                    </x-primary-button>
                    <x-secondary-button wire:click="closeResetModal">
                        Cancel
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Create/Edit User Modal -->
    @if($showUserModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
             <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                <div class="bg-white dark:bg-gray-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4" id="modal-title">
                        {{ $editingIndex !== null ? 'Edit User' : 'Create New User' }}
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        @if($editingIndex === null)
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        @endif

                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <select wire:model="role" id="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="registrar">Registrar</option>
                                <option value="finance">Finance</option>
                                <option value="teacher">Teacher</option>
                                <option value="parent">Parent</option>
                                <option value="student">Student</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Grant Enrollment Access Toggle -->
                        <div class="mt-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="grantEnrollmentAccess" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Grant Enrollment Access</span>
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-1">Allow this user to process enrollments during peak season.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <x-primary-button wire:click="saveUser" class="ml-3">
                        Save
                    </x-primary-button>
                    <x-secondary-button wire:click="closeUserModal">
                        Cancel
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
