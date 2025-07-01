<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Task Manager' }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
    <!-- tailwindcss -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    @livewireStyles
</head>

<body>
    {{ $slot }}
    @livewireScripts
</body>


</html>
