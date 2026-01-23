<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        @php
            // RBAC Simulation
            $role = 'super_admin';
        @endphp

        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
                @include('layouts.navigation', ['role' => $role])
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm z-10">
                    <div class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $header ?? 'Dashboard' }}
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Simple User Menu Simulation -->
                        <span class="text-gray-600 text-sm">
                            {{ Auth::user()->name ?? 'User' }}
                            <span class="ml-1 px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full uppercase tracking-wide">{{ $role }}</span>
                        </span>
                    </div>
                </header>

                <!-- Scrollable Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
