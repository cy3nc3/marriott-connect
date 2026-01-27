<div class="h-full flex flex-col p-4">
    <div class="flex items-center justify-center mb-8 mt-2">
        <x-application-logo class="block h-10 w-auto fill-current text-indigo-600" />
        <span class="ml-3 text-xl font-bold text-gray-800 tracking-tight">Marriott<span class="text-indigo-600">Connect</span></span>
    </div>

    <nav class="flex-1 space-y-1">
        @php
            $links = [];

            // Define links based on role
            switch ($role) {
                case 'super_admin':
                    $links = [
                        ['label' => 'Dashboard', 'route' => 'dashboards.super-admin', 'icon' => 'bx-grid-alt'],
                        ['label' => 'School Year', 'route' => 'admin.school-year', 'icon' => 'bx-calendar'],
                        ['label' => 'User Management', 'route' => 'users', 'icon' => 'bx-user'],
                        ['label' => 'Settings', 'route' => 'admin.settings', 'icon' => 'bx-cog'],
                    ];
                    break;
                case 'admin':
                    $links = [
                        ['label' => 'Dashboard', 'route' => 'dashboards.admin', 'icon' => 'bx-grid-alt'],
                        ['label' => 'Curriculum', 'route' => 'admin.curriculum', 'icon' => 'bx-book-content'],
                        ['label' => 'Sections', 'route' => 'admin.sections', 'icon' => 'bx-group'],
                        ['label' => 'Schedule Matrix', 'route' => 'admin.schedule', 'icon' => 'bx-calendar-event'],
                        ['label' => 'Class Lists', 'route' => 'admin.reports.classlist', 'icon' => 'bx-list-ol'],
                        ['label' => 'DepEd Reports', 'route' => 'admin.reports.deped', 'icon' => 'bx-folder'],
                    ];
                    break;
                case 'registrar':
                    $links = [
                        ['label' => 'Dashboard', 'route' => 'dashboards.registrar', 'icon' => 'bx-grid-alt'],
                        ['label' => 'Student Directory', 'route' => 'registrar.students', 'icon' => 'bx-user-pin'],
                        ['label' => 'Enrollment', 'route' => 'registrar.enrollment', 'icon' => 'bx-id-card'],
                        ['label' => 'Permanent Records', 'route' => 'registrar.permanent-record', 'icon' => 'bx-folder-open'],
                        ['label' => 'Promotion', 'route' => 'registrar.promotion', 'icon' => 'bx-up-arrow-circle'],
                        ['label' => 'Remedial/Summer', 'route' => 'registrar.remedial', 'icon' => 'bx-first-aid'],
                        ['label' => 'Dropping/Transfer', 'route' => 'registrar.dropping', 'icon' => 'bx-user-minus'],
                    ];
                    break;
                case 'finance':
                    $links = [
                        ['label' => 'Dashboard', 'route' => 'dashboards.finance', 'icon' => 'bx-grid-alt'],
                        ['label' => 'POS', 'route' => 'finance.pos', 'icon' => 'bx-cart'],
                        ['label' => 'Inventory', 'route' => 'finance.inventory', 'icon' => 'bx-box'],
                        ['label' => 'Expenses', 'route' => 'finance.expenses', 'icon' => 'bx-wallet'],
                        ['label' => 'History', 'route' => 'finance.history', 'icon' => 'bx-history'],
                        ['label' => 'Discounts', 'route' => 'finance.discounts', 'icon' => 'bx-gift'],
                        ['label' => 'Fee Setup', 'route' => 'finance.fees', 'icon' => 'bx-money'],
                        ['label' => 'Daily Report', 'route' => 'finance.remittance', 'icon' => 'bx-printer'],
                    ];
                    break;
                case 'teacher':
                    $links = [
                        ['label' => 'Dashboard', 'route' => 'dashboards.teacher', 'icon' => 'bx-grid-alt'],
                        ['label' => 'Grading Sheet', 'route' => 'teacher.grading', 'icon' => 'bx-edit'],
                        ['label' => 'Advisory Board', 'route' => 'teacher.advisory', 'icon' => 'bx-chalkboard'],
                    ];
                    break;
                case 'student':
                    $links = [
                        ['label' => 'My Dashboard', 'route' => 'dashboards.student', 'icon' => 'bx-grid-alt'],
                        ['label' => 'My Schedule', 'route' => 'student.schedule', 'icon' => 'bx-time'],
                        ['label' => 'Report Card', 'route' => 'student.grades', 'icon' => 'bx-report'],
                    ];
                    break;
                case 'parent':
                    $links = [
                        ['label' => 'Parent Portal', 'route' => 'dashboards.parent', 'icon' => 'bx-home'],
                    ];
                    break;
            }
        @endphp

        @foreach($links as $link)
            @php
                $isActive = $link['route'] !== '#' && request()->routeIs($link['route']);
            @endphp
            <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}"
               class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-all duration-200
               {{ $isActive
                  ? 'bg-indigo-50 text-indigo-700'
                  : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <i class="bx {{ $link['icon'] }} mr-3 text-xl flex-shrink-0 transition-colors duration-200 {{ $isActive ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="border-t border-gray-200 pt-4 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="group flex items-center px-3 py-2.5 text-sm font-medium text-gray-600 rounded-md hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
                <i class='bx bx-log-out mr-3 text-xl flex-shrink-0 text-gray-400 group-hover:text-red-500 transition-colors duration-200'></i>
                Log Out
            </a>
        </form>
    </div>
</div>
