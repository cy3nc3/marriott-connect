<x-app-layout>
    <x-slot name="header">
        @php
            $role = $role ?? 'super_admin';
            $headers = [
                'super_admin' => 'System Monitor',
                'admin' => 'DSS & Analytics',
                'registrar' => 'Population Analytics',
                'finance' => 'Revenue Analytics',
                'teacher' => 'Academic Overview',
                'student' => 'My Dashboard',
                'parent' => 'Parent Portal',
            ];
            $currentHeader = $headers[$role] ?? 'Dashboard';
        @endphp
        {{ $currentHeader }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- We assume $role is passed from the Layout or View Composer --}}
            {{-- Fallback for testing/simulation --}}
            @php
                // Default to super_admin if not set, matching the Layout simulation default
                $role = $role ?? 'super_admin';
            @endphp

            @if($role === 'super_admin')      <livewire:super-admin.dashboard />
            @elseif($role === 'admin')        <livewire:admin.dashboard />
            @elseif($role === 'registrar')    <livewire:registrar.dashboard />
            @elseif($role === 'finance')      <livewire:finance.dashboard />
            @elseif($role === 'teacher')      <livewire:teacher.dashboard />
            @elseif($role === 'student')      <livewire:student.dashboard />
            @elseif($role === 'parent')       <livewire:parent.dashboard />
            @endif
        </div>
    </div>
</x-app-layout>
