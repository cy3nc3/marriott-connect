<div class="h-full flex flex-col px-4 py-6">
    <!-- Logo -->
    <div class="flex items-center mb-10 transition-all duration-300">
        <div class="w-12 flex-shrink-0 flex items-center justify-center">
            <div class="p-2 bg-indigo-600 rounded-lg">
                <x-application-logo class="block h-6 w-auto fill-current text-white" />
            </div>
        </div>
        <div x-show="isExpanded" x-transition.opacity.duration.300ms class="flex items-center ml-3 overflow-hidden whitespace-nowrap">
            <span class="text-xl font-bold text-gray-800 dark:text-white tracking-tight">Marriott<span class="text-indigo-600 dark:text-indigo-400">Connect</span></span>
            <button @click="toggleSidebar" class="ml-2 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none transition-colors" title="Toggle Sidebar">
                <i class='bx text-xl' :class="!autoCollapse ? 'bx-chevron-left' : 'bx-pin'"></i>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 min-h-0 space-y-2 overflow-y-auto custom-scrollbar overflow-x-hidden"
         :class="{'hide-scrollbar': !isExpanded}"
         x-data="{ currentPath: window.location.pathname }"
         x-on:livewire:navigated.window="currentPath = window.location.pathname">
        @php
            $links = [];

            // Define links based on role with headers
            switch ($role) {
                case 'super_admin':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.super-admin', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'System Management'],
                        ['type' => 'link', 'label' => 'School Year', 'route' => 'admin.school-year', 'icon' => 'bx-calendar'],
                        ['type' => 'link', 'label' => 'User Management', 'route' => 'users', 'icon' => 'bx-user'],
                        ['type' => 'link', 'label' => 'Settings', 'route' => 'admin.settings', 'icon' => 'bx-cog'],
                    ];
                    break;
                case 'admin':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.admin', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'Academic Management'],
                        ['type' => 'link', 'label' => 'Curriculum', 'route' => 'admin.curriculum', 'icon' => 'bx-book-content'],
                        ['type' => 'link', 'label' => 'Sections', 'route' => 'admin.sections', 'icon' => 'bx-group'],
                        ['type' => 'link', 'label' => 'Schedule Matrix', 'route' => 'admin.schedule', 'icon' => 'bx-calendar-event'],
                        ['type' => 'link', 'label' => 'Class Lists', 'route' => 'admin.reports.classlist', 'icon' => 'bx-list-ol'],
                        ['type' => 'header', 'label' => 'Reports'],
                        ['type' => 'link', 'label' => 'DepEd Reports', 'route' => 'admin.reports.deped', 'icon' => 'bx-folder'],
                        ['type' => 'link', 'label' => 'SF9 Generator', 'route' => 'admin.reports.sf9', 'icon' => 'bx-printer'],
                    ];
                    break;
                case 'registrar':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.registrar', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'Records & Enrollment'],
                        ['type' => 'link', 'label' => 'Student Directory', 'route' => 'registrar.students', 'icon' => 'bx-user-pin'],
                        ['type' => 'link', 'label' => 'Enrollment', 'route' => 'registrar.enrollment', 'icon' => 'bx-id-card'],
                        ['type' => 'link', 'label' => 'Permanent Records', 'route' => 'registrar.permanent-record', 'icon' => 'bx-folder-open'],
                        ['type' => 'header', 'label' => 'Processing'],
                        ['type' => 'link', 'label' => 'Promotion', 'route' => 'registrar.promotion', 'icon' => 'bx-up-arrow-circle'],
                        ['type' => 'link', 'label' => 'Remedial/Summer', 'route' => 'registrar.remedial', 'icon' => 'bx-first-aid'],
                        ['type' => 'link', 'label' => 'Dropping/Transfer', 'route' => 'registrar.dropping', 'icon' => 'bx-user-minus'],
                    ];
                    break;
                case 'finance':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.finance', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'Cashiering'],
                        ['type' => 'link', 'label' => 'Student Accounts', 'route' => 'finance.ledger', 'icon' => 'bx-wallet'],
                        ['type' => 'link', 'label' => 'Cashier Panel', 'route' => 'finance.pos', 'icon' => 'bx-cart'],
                        ['type' => 'header', 'label' => 'Configuration'],
                        ['type' => 'link', 'label' => 'Inventory', 'route' => 'finance.inventory', 'icon' => 'bx-box'],
                        ['type' => 'link', 'label' => 'History', 'route' => 'finance.history', 'icon' => 'bx-history'],
                        ['type' => 'link', 'label' => 'Discounts', 'route' => 'finance.discounts', 'icon' => 'bx-gift'],
                        ['type' => 'link', 'label' => 'Fee Setup', 'route' => 'finance.fees', 'icon' => 'bx-money'],
                        ['type' => 'link', 'label' => 'Daily Report', 'route' => 'finance.remittance', 'icon' => 'bx-printer'],
                    ];
                    break;
                case 'teacher':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.teacher', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'Academic Tasks'],
                        ['type' => 'link', 'label' => 'Grading Sheet', 'route' => 'teacher.grading', 'icon' => 'bx-edit'],
                        ['type' => 'link', 'label' => 'Advisory Board', 'route' => 'teacher.advisory', 'icon' => 'bx-chalkboard'],
                    ];
                    break;
                case 'student':
                    $links = [
                        ['type' => 'link', 'label' => 'My Dashboard', 'route' => 'dashboards.student', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'Academics'],
                        ['type' => 'link', 'label' => 'My Schedule', 'route' => 'student.schedule', 'icon' => 'bx-time'],
                        ['type' => 'link', 'label' => 'Report Card', 'route' => 'student.grades', 'icon' => 'bx-file'],
                    ];
                    break;
                case 'parent':
                    $links = [
                        ['type' => 'link', 'label' => 'Parent Portal', 'route' => 'dashboards.parent', 'icon' => 'bx-home'],
                        ['type' => 'header', 'label' => 'Student Info'],
                        ['type' => 'link', 'label' => 'Schedule', 'route' => 'parent.schedule', 'icon' => 'bx-calendar'],
                        ['type' => 'link', 'label' => 'Report Card', 'route' => 'parent.grades', 'icon' => 'bx-file'],
                        ['type' => 'link', 'label' => 'Statement of Account', 'route' => 'parent.billing', 'icon' => 'bx-money'],
                    ];
                    break;
            }
        @endphp

        @foreach($links as $link)
            @if($link['type'] === 'header')
                <div class="relative h-10 flex items-center mt-4 mb-2">
                    <div class="absolute inset-0 flex items-center justify-center w-12 transition-opacity duration-300"
                         :class="isExpanded ? 'opacity-0' : 'opacity-100'">
                        <div class="w-6 border-t border-gray-300 dark:border-gray-600"></div>
                    </div>
                    <span class="absolute left-12 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider whitespace-nowrap transition-opacity duration-300"
                          :class="isExpanded ? 'opacity-100' : 'opacity-0'">{{ $link['label'] }}</span>
                </div>
            @else
                @php
                    $linkRoute = $link['route'] === '#' ? '#' : route($link['route']);
                    $linkPath = $link['route'] === '#' ? '#' : parse_url($linkRoute, PHP_URL_PATH);

                    $activeClasses = 'bg-indigo-50 text-indigo-700 dark:bg-indigo-600 dark:text-white font-semibold shadow-sm';
                    $inactiveClasses = 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200';
                @endphp
                <a href="{{ $linkRoute }}"
                   {{ $link['route'] !== '#' ? 'wire:navigate' : '' }}
                   class="group flex items-center py-3 text-sm rounded-xl transition-all duration-200"
                   :class="currentPath === '{{ $linkPath }}' ? '{{ $activeClasses }}' : '{{ $inactiveClasses }}'"
                   title="{{ $link['label'] }}">
                    <div class="w-12 flex-shrink-0 flex items-center justify-center">
                        @if(Str::startsWith($link['icon'], 'bx-'))
                            <i class="bx {{ $link['icon'] }} text-xl transition-colors duration-200"
                               :class="currentPath === '{{ $linkPath }}' ? 'text-indigo-700 dark:text-white' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300'"></i>
                        @else
                            <x-dynamic-component :component="$link['icon']"
                                                 class="w-5 h-5 transition-colors duration-200"
                                                 :class="currentPath === '{{ $linkPath }}' ? 'text-indigo-700 dark:text-white' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300'" />
                        @endif
                    </div>
                    <span x-show="isExpanded" x-transition.opacity.duration.300ms class="whitespace-nowrap">{{ $link['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

</div>
