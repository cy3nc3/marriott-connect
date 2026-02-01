<div class="h-full flex flex-col px-4 py-6">
    <!-- Logo -->
    <div class="flex items-center px-2 mb-10 transition-all duration-300" :class="isExpanded ? '' : 'justify-center'">
        <div class="p-2 bg-indigo-600 rounded-lg flex-shrink-0">
            <x-application-logo class="block h-6 w-auto fill-current text-white" />
        </div>
        <span x-show="isExpanded" x-transition.opacity.duration.300ms class="ml-3 text-xl font-bold text-gray-800 dark:text-white tracking-tight whitespace-nowrap">Marriott<span class="text-indigo-600 dark:text-indigo-400">Connect</span></span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-2 overflow-y-auto custom-scrollbar overflow-x-hidden">
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
                <div x-show="!isExpanded" class="mx-auto w-8 border-t border-gray-300 dark:border-gray-600 my-4 transition-all duration-300"></div>
                <span x-show="isExpanded" x-transition.opacity.duration.300ms class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mt-6 mb-2 block px-2 tracking-wider whitespace-nowrap">{{ $link['label'] }}</span>
            @else
                @php
                    $isActive = $link['route'] !== '#' && request()->routeIs($link['route']);
                    // Active: Light (Indigo Text, Indigo BG), Dark (White Text, Indigo BG/Opacity)
                    // Inactive: Gray Text, Hover Gray BG
                    $activeClasses = 'bg-indigo-50 text-indigo-700 dark:bg-indigo-600 dark:text-white font-semibold shadow-sm';
                    $inactiveClasses = 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200';
                @endphp
                <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}"
                   class="group flex items-center py-3 text-sm rounded-xl transition-all duration-200 {{ $isActive ? $activeClasses : $inactiveClasses }}"
                   :class="isExpanded ? 'px-4' : 'px-0 justify-center'"
                   title="{{ $link['label'] }}">
                    @if(Str::startsWith($link['icon'], 'bx-'))
                        <i class="bx {{ $link['icon'] }} text-xl flex-shrink-0 transition-all duration-200 {{ $isActive ? 'text-indigo-700 dark:text-white' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}"
                           :class="isExpanded ? 'mr-3' : 'mr-0'"></i>
                    @else
                        <x-dynamic-component :component="$link['icon']"
                                             class="w-5 h-5 flex-shrink-0 transition-all duration-200 {{ $isActive ? 'text-indigo-700 dark:text-white' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-600 dark:group-hover:text-gray-300' }}"
                                             :class="isExpanded ? 'mr-3' : 'mr-0'" />
                    @endif
                    <span x-show="isExpanded" x-transition.opacity.duration.300ms class="whitespace-nowrap">{{ $link['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    <!-- Bottom Actions -->
    <div class="mt-auto pt-4 space-y-3">
        <!-- Theme Toggle Segmented Control -->
        <div x-show="isExpanded" x-transition.opacity.duration.300ms class="bg-gray-100 dark:bg-gray-700 p-1 rounded-xl flex items-center">
            <button onclick="setTheme('light')" id="btn-light" class="flex-1 flex items-center justify-center py-2 rounded-lg text-sm font-medium transition-all duration-200">
                <i class='bx bx-sun text-lg mr-2'></i> Light
            </button>
            <button onclick="setTheme('dark')" id="btn-dark" class="flex-1 flex items-center justify-center py-2 rounded-lg text-sm font-medium transition-all duration-200">
                <i class='bx bx-moon text-lg mr-2'></i> Dark
            </button>
        </div>

        <button @click="toggleSidebar" class="flex items-center justify-center w-full py-3 rounded-xl text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none">
             <i class='bx text-2xl' :class="autoCollapse ? 'bx-chevron-right' : 'bx-chevron-left'"></i>
        </button>
    </div>
</div>

<script>
    function updateThemeUI() {
        const isDark = document.documentElement.classList.contains('dark');
        const btnLight = document.getElementById('btn-light');
        const btnDark = document.getElementById('btn-dark');

        if (isDark) {
            // Dark Mode Active
            btnLight.classList.remove('bg-white', 'shadow-sm', 'text-gray-800');
            btnLight.classList.add('text-gray-500', 'hover:text-gray-700');

            btnDark.classList.add('bg-gray-600', 'text-white', 'shadow-sm');
            btnDark.classList.remove('text-gray-500', 'hover:text-gray-700');
        } else {
            // Light Mode Active
            btnLight.classList.add('bg-white', 'shadow-sm', 'text-gray-800');
            btnLight.classList.remove('text-gray-500', 'hover:text-gray-700');

            btnDark.classList.remove('bg-gray-600', 'text-white', 'shadow-sm');
            btnDark.classList.add('text-gray-500', 'hover:text-gray-700');
        }
    }

    function setTheme(mode) {
        if (mode === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        }
        updateThemeUI();
    }

    // Initialize UI on load
    document.addEventListener('DOMContentLoaded', updateThemeUI);
    // Also run immediately in case DOMContentLoaded already fired (rare here but good practice)
    updateThemeUI();
</script>
