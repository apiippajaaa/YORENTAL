<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tiny Slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/tiny-slider-init.js'])

    <script src="https://kit.fontawesome.com/97363d67ed.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body class="font-sans text-gray-900 antialiased">
    @include('layouts.frontend.navbar')
    <section>
        @yield('banner')
    </section>
    <main class="px-4 md:px-12 flex flex-col gap-4">
        {{ $slot }}
    </main>

    @include('layouts.frontend.footer')
    @include('layouts.frontend.script')
    @stack('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>

    {{-- TOAST NOTIFICATIONS --}}
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
        class="fixed top-5 right-5 z-50 space-y-2">
        @if (session('success'))
            <div class="bg-green-500 text-white px-4 py-3 rounded shadow-lg">
                <strong class="font-bold">Sukses!</strong>
                <span class="block">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white px-4 py-3 rounded shadow-lg">
                <strong class="font-bold">Ups!</strong>
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>

</html>
