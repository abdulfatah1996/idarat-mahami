<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <!-- SEO Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description"
        content="نظام احترافي لإدارة وتنظيم المهام اليومية والفرق بكفاءة عالية باستخدام Laravel وLivewire.">
    <meta name="author" content="TaskManager Team">
    <meta name="keywords" content="إدارة مهام, لوحة تحكم, Laravel, Livewire, إنتاجية, فريق, مشاريع">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>{{ $title ?? 'لوحة التحكم' }}</title>

    <!-- App CSS -->
    @stack('styles')

    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app-rtl.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Livewire Styles -->
    @livewireStyles
    <!-- Alpine.js -->
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <!-- livewire styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @livewireStyles


</head>

<body id="body" class="bg-light">
    <!-- leftbar-tab-menu -->
    <livewire:layout.partial.sidebar />
    <!-- end leftbar-tab-menu-->

    <!-- Top Bar Start -->
    <livewire:layout.partial.header />
    <!-- Top Bar End -->
    <!-- page-wrapper -->
    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content-tab">
            {{ $slot }}

            <livewire:layout.partial.footer />
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->
    <!-- Vendor JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- App JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Livewire Scripts -->
    @livewireScripts
    <script>
        window.addEventListener('close-delete-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')

</body>

</html>
