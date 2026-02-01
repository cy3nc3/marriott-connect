<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MarriottConnect</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Boxicons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // Dark Mode Initialization
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300"
          x-data="{
              autoCollapse: localStorage.getItem('sidebarAutoCollapse') === 'true',
              darkMode: document.documentElement.classList.contains('dark'),
              hover: false,
              forceCollapsed: false,
              get isExpanded() {
                  return !this.autoCollapse || (this.hover && !this.forceCollapsed);
              },
              toggleSidebar() {
                  this.autoCollapse = !this.autoCollapse;
                  localStorage.setItem('sidebarAutoCollapse', this.autoCollapse);
                  if (this.autoCollapse) {
                      this.forceCollapsed = true;
                  }
              },
              toggleTheme() {
                  this.darkMode = !this.darkMode;
                  if (this.darkMode) {
                      document.documentElement.classList.add('dark');
                      localStorage.theme = 'dark';
                  } else {
                      document.documentElement.classList.remove('dark');
                      localStorage.theme = 'light';
                  }
              }
          }">
        @php
            // RBAC Simulation: Use passed role or default, fallback to session, then 'student'
            $role = $role ?? session('role', 'student');
        @endphp

        <div class="flex h-screen overflow-hidden print:block print:overflow-visible print:h-auto">
            <!-- Sidebar -->
            <aside class="bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 hidden md:flex flex-col print:hidden transition-all duration-300 ease-in-out"
                   :class="isExpanded ? 'w-72' : 'w-20 hide-scrollbar'"
                   @mouseenter="hover = true"
                   @mouseleave="hover = false; forceCollapsed = false;">
                @include('layouts.navigation', ['role' => $role])
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden bg-gray-100 dark:bg-gray-900 transition-colors duration-300 print:block print:overflow-visible print:h-auto">
                <!-- Top Header -->
                <header class="bg-transparent h-20 flex items-center justify-between px-8 z-10 print:hidden transition-colors duration-300">
                    <div class="flex items-center">
                         <!-- Mobile Menu Trigger (Optional, kept simpler for now) -->
                        <h2 class="font-bold text-lg text-gray-800 dark:text-white leading-tight">
                            {{ $header ?? 'Dashboard' }}
                        </h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Search (Icon Only) -->
                        <button class="p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <i class='bx bx-search text-2xl'></i>
                        </button>

                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <i class='bx bx-bell text-2xl'></i>
                            <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-red-500 border border-white dark:border-gray-800"></span>
                        </button>

                        <!-- Theme Toggle -->
                        <button @click="toggleTheme()" class="p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors" title="Toggle Theme">
                            <i class='bx text-2xl' :class="darkMode ? 'bx-sun' : 'bx-moon'"></i>
                        </button>

                        <!-- User Profile -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-3 pl-4 focus:outline-none transition ease-in-out duration-150 group">
                                     <div class="flex flex-col text-right hidden sm:flex">
                                        <span class="text-sm font-semibold text-gray-800 dark:text-white group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors">{{ Auth::user()->name ?? 'User' }}</span>
                                        <span class="text-xs text-indigo-500 dark:text-indigo-400 uppercase tracking-wide font-bold">{{ $role }}</span>
                                     </div>
                                     <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 font-bold text-lg group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800 transition-colors">
                                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                     </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Log Out -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Scrollable Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto px-8 py-4 print:block print:overflow-visible print:p-0 print:bg-white print:h-auto transition-colors duration-300">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
