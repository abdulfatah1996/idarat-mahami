<!-- Top Bar Start -->
<div class="topbar">
    <!-- Navbar -->
    <nav class="navbar-custom" id="navbar-custom">
        <ul class="list-unstyled topbar-nav float-end mb-0">

            <!-- اللغة -->
            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-icon" data-bs-toggle="dropdown" href="#">
                    <img src="{{ asset('assets/images/flags/PA_flag.jpg') }}" alt=""
                        class="thumb-xxs rounded-circle">
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#"><img src="{{ asset('assets/images/flags/us_flag.jpg') }}"
                            height="15" class="me-2">English</a>
                    <a class="dropdown-item" href="#"><img src="{{ asset('assets/images/flags/PA_flag.jpg') }}"
                            height="15" class="me-2">العربية</a>
                </div>
            </li>

            <!-- الإشعارات -->
            @livewire('ui.notifications')


            <!-- المستخدم -->
            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#">
                    <div class="d-flex align-items-center">
                        <img src="{{ $user->avatar_url ?? asset('assets/images/users/default.jpg') }}"
                            alt="profile-user" class="rounded-circle me-2 thumb-sm" />
                        <div>
                            <small class="d-none d-md-block font-11">
                                {{ $user->role_label ?? 'مستخدم' }}
                            </small>
                            <span class="d-none d-md-block fw-semibold font-12">
                                {{ $user->name ?? 'مستخدم غير معروف' }}
                                <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- ملف شخصي -->
                    <a class="dropdown-item d-flex align-items-center py-1 px-2" style="min-width: 160px;"
                        href="{{ route('profile') }}">
                        <i class="ti ti-user me-2 text-primary fs-5"></i>
                        <span class="fw-semibold">الملف الشخصي</span>
                    </a>

                    <!-- فاصل -->
                    <div class="dropdown-divider my-1"></div>

                    <!-- تسجيل الخروج -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="dropdown-item d-flex align-items-center py-1 px-2 text-danger w-100"
                            style="min-width: 160px;">
                            <i class="ti ti-logout me-2 fs-5"></i>
                            <span class="fw-semibold">تسجيل الخروج</span>
                        </button>
                    </form>

                </div>
            </li>
        </ul>

        <!-- القائمة اليمنى -->
        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <button class="nav-link button-menu-mobile nav-icon" id="togglemenu">
                    <i class="ti ti-menu-2"></i>
                </button>
            </li>
            <li class="hide-phone app-search">
                <form role="search" action="#" method="get">
                    <input type="search" name="search" class="form-control top-search mb-0"
                        placeholder="بحث عن مهمة...">
                    <button type="submit"><i class="ti ti-search"></i></button>
                </form>
            </li>
        </ul>
    </nav>
</div>
<!-- Top Bar End -->
