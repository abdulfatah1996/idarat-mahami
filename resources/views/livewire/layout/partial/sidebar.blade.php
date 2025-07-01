{{-- resources/views/components/layouts/sidebar.blade.php --}}

<div class="leftbar-tab-menu">
    <div class="main-icon-menu">
        <a href="{{ route('dashboard') }}" class="logo logo-metrica d-block text-center">
            <span>
                <img src="{{ asset('favicon.png') }}" alt="logo-small" class="logo-sm">
            </span>
        </a>
        <div class="main-icon-menu-body">
            <div class="position-relative h-100" data-simplebar style="overflow-x: hidden;">
                <ul class="nav nav-tabs" role="tablist" id="tab-menu">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="الرئيسية">
                        <a href="#SidebarDashboard" id="dashboard-tab" class="nav-link">
                            <i class="ti ti-smart-home menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="المهام">
                        <a href="#SidebarTasks" id="tasks-tab" class="nav-link">
                            <i class="ti ti-list-check menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="المشاريع">
                        <a href="#SidebarProjects" id="projects-tab" class="nav-link">
                            <i class="ti ti-folder menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="الإعدادات">
                        <a href="#SidebarSettings" id="settings-tab" class="nav-link">
                            <i class="ti ti-settings menu-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="pro-metrica-end">
            <a href="{{ route('profile') }}" class="profile">
                <img src="{{ $user?->avatar_url ?? asset('assets/images/default-avatar.png') }}" alt="profile-user"
                    class="rounded-circle thumb-sm">
            </a>
        </div>
    </div>

    <div class="main-menu-inner">
        <div class="topbar-left">
            <a href="{{ route('dashboard') }}" class="logo">
                <h3 class="logo-lg logo-dark">{{ config('app.name') }}</h3>
                <h3 class="logo-lg logo-light">{{ config('app.name') }}</h3>
            </a>
        </div>

        <div class="menu-body navbar-vertical tab-content" data-simplebar>
            <div id="SidebarDashboard" class="main-icon-menu-pane tab-pane" role="tabpanel">
                <div class="title-box">
                    <h6 class="menu-title">الرئيسية</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        @if (Route::has('dashboard'))
                            <a class="nav-link" href="{{ route('dashboard') }}">لوحة التحكم</a>
                        @else
                            <span class="nav-link text-muted text-decoration-line-through">لوحة التحكم</span>
                        @endif
                    </li>
                </ul>
            </div>

            <div id="SidebarTasks" class="main-icon-menu-pane tab-pane" role="tabpanel">
                <div class="title-box">
                    <h6 class="menu-title">المهام</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        @if (Route::has('tasks.index'))
                            <a class="nav-link" href="{{ route('tasks.index') }}">كل المهام</a>
                        @else
                            <span class="nav-link text-muted text-decoration-line-through">كل المهام</span>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (Route::has('tasks.create'))
                            <a class="nav-link" href="{{ route('tasks.create') }}">إضافة مهمة</a>
                        @else
                            <span class="nav-link text-muted text-decoration-line-through">إضافة مهمة</span>
                        @endif
                    </li>
                </ul>
            </div>

            <div id="SidebarProjects" class="main-icon-menu-pane tab-pane" role="tabpanel">
                <div class="title-box">
                    <h6 class="menu-title">المشاريع</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        @if (Route::has('projects.index'))
                            <a class="nav-link" href="{{ route('projects.index') }}">قائمة المشاريع</a>
                        @else
                            <span class="nav-link text-muted text-decoration-line-through">قائمة المشاريع</span>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (Route::has('projects.create'))
                            <a class="nav-link" href="{{ route('projects.create') }}">مشروع جديد</a>
                        @else
                            <span class="nav-link text-muted text-decoration-line-through">مشروع جديد</span>
                        @endif
                    </li>
                </ul>
            </div>

            <div id="SidebarSettings" class="main-icon-menu-pane tab-pane" role="tabpanel">
                <div class="title-box">
                    <h6 class="menu-title">الإعدادات</h6>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        @if (Route::has('settings.general'))
                            <a class="nav-link" href="{{ route('settings.general') }}">إعدادات عامة</a>
                        @else
                            <span class="nav-link text-muted text-decoration-line-through">إعدادات عامة</span>
                        @endif
                    </li>
                    <li class="nav-item">
                        @if (Route::has('profile'))
                            <a class="nav-link" href="{{ route('profile') }}">الملف الشخصي</a>
                        @else
                            <span class="nav-link text-muted text-decoration-line-through">الملف الشخصي</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
