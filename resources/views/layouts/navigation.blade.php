<div class="h-full flex flex-col p-4">
    <div class="flex items-center justify-center mb-8 mt-2">
        <x-application-logo class="block h-10 w-auto fill-current text-indigo-600" />
        <span class="ml-3 text-xl font-bold text-gray-800 tracking-tight">Marriott<span class="text-indigo-600">Connect</span></span>
    </div>

    <nav class="flex-1 space-y-1">
        @php
            $links = [];

            // Define links based on role with headers
            switch ($role) {
                case 'super_admin':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.super-admin', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'SYSTEM MANAGEMENT'],
                        ['type' => 'link', 'label' => 'School Year', 'route' => 'admin.school-year', 'icon' => 'bx-calendar'],
                        ['type' => 'link', 'label' => 'User Management', 'route' => 'users', 'icon' => 'bx-user'],
                        ['type' => 'link', 'label' => 'Settings', 'route' => 'admin.settings', 'icon' => 'bx-cog'],
                    ];
                    break;
                case 'admin':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.admin', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'ACADEMIC MANAGEMENT'],
                        ['type' => 'link', 'label' => 'Curriculum', 'route' => 'admin.curriculum', 'icon' => 'bx-book-content'],
                        ['type' => 'link', 'label' => 'Sections', 'route' => 'admin.sections', 'icon' => 'bx-group'],
                        ['type' => 'link', 'label' => 'Schedule Matrix', 'route' => 'admin.schedule', 'icon' => 'bx-calendar-event'],
                        ['type' => 'link', 'label' => 'Class Lists', 'route' => 'admin.reports.classlist', 'icon' => 'bx-list-ol'],
                        ['type' => 'header', 'label' => 'REPORTS'],
                        ['type' => 'link', 'label' => 'DepEd Reports', 'route' => 'admin.reports.deped', 'icon' => 'bx-folder'],
                        ['type' => 'link', 'label' => 'SF9 Generator', 'route' => 'admin.reports.sf9', 'icon' => 'bx-printer'],
                    ];
                    break;
                case 'registrar':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.registrar', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'RECORDS & ENROLLMENT'],
                        ['type' => 'link', 'label' => 'Student Directory', 'route' => 'registrar.students', 'icon' => 'bx-user-pin'],
                        ['type' => 'link', 'label' => 'Enrollment', 'route' => 'registrar.enrollment', 'icon' => 'bx-id-card'],
                        ['type' => 'link', 'label' => 'Permanent Records', 'route' => 'registrar.permanent-record', 'icon' => 'bx-folder-open'],
                        ['type' => 'header', 'label' => 'PROCESSING'],
                        ['type' => 'link', 'label' => 'Promotion', 'route' => 'registrar.promotion', 'icon' => 'bx-up-arrow-circle'],
                        ['type' => 'link', 'label' => 'Remedial/Summer', 'route' => 'registrar.remedial', 'icon' => 'bx-first-aid'],
                        ['type' => 'link', 'label' => 'Dropping/Transfer', 'route' => 'registrar.dropping', 'icon' => 'bx-user-minus'],
                    ];
                    break;
                case 'finance':
                    $links = [
                        ['type' => 'link', 'label' => 'Dashboard', 'route' => 'dashboards.finance', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'CASHIERING'],
                        ['type' => 'link', 'label' => 'Student Accounts', 'route' => 'finance.ledger', 'icon' => 'bx-wallet'],
                        ['type' => 'link', 'label' => 'Cashier Panel', 'route' => 'finance.pos', 'icon' => 'bx-cart'],
                        ['type' => 'header', 'label' => 'CONFIGURATION'],
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
                        ['type' => 'header', 'label' => 'ACADEMIC TASKS'],
                        ['type' => 'link', 'label' => 'Grading Sheet', 'route' => 'teacher.grading', 'icon' => 'bx-edit'],
                        ['type' => 'link', 'label' => 'Advisory Board', 'route' => 'teacher.advisory', 'icon' => 'bx-chalkboard'],
                    ];
                    break;
                case 'student':
                    $links = [
                        ['type' => 'link', 'label' => 'My Dashboard', 'route' => 'dashboards.student', 'icon' => 'bx-grid-alt'],
                        ['type' => 'header', 'label' => 'ACADEMICS'],
                        ['type' => 'link', 'label' => 'My Schedule', 'route' => 'student.schedule', 'icon' => 'bx-time'],
                        ['type' => 'link', 'label' => 'Report Card', 'route' => 'student.grades', 'icon' => 'bx-file'],
                    ];
                    break;
                case 'parent':
                    $links = [
                        ['type' => 'link', 'label' => 'Parent Portal', 'route' => 'dashboards.parent', 'icon' => 'bx-home'],
                        ['type' => 'header', 'label' => 'STUDENT INFO'],
                        ['type' => 'link', 'label' => 'Schedule', 'route' => 'parent.schedule', 'icon' => 'bx-calendar'],
                        ['type' => 'link', 'label' => 'Report Card', 'route' => 'parent.grades', 'icon' => 'bx-file'],
                        ['type' => 'link', 'label' => 'Statement of Account', 'route' => 'parent.billing', 'icon' => 'bx-money'],
                    ];
                    break;
            }
        @endphp

        @foreach($links as $link)
            @if($link['type'] === 'header')
                <span class="text-xs font-semibold text-gray-400 uppercase mt-4 mb-2 block px-4">{{ $link['label'] }}</span>
            @else
                @php
                    $isActive = $link['route'] !== '#' && request()->routeIs($link['route']);
                    $iconColor = $isActive ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500';
                @endphp
                <a href="{{ $link['route'] === '#' ? '#' : route($link['route']) }}"
                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-all duration-200
                   {{ $isActive
                      ? 'bg-indigo-50 text-indigo-700'
                      : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    @if(Str::startsWith($link['icon'], 'bx-'))
                        <i class="bx {{ $link['icon'] }} mr-3 text-xl flex-shrink-0 transition-colors duration-200 {{ $iconColor }}"></i>
                    @else
                        <x-dynamic-component :component="$link['icon']" class="w-5 h-5 mr-3 flex-shrink-0 transition-colors duration-200 {{ $iconColor }}" />
                    @endif
                    {{ $link['label'] }}
                </a>
            @endif
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
