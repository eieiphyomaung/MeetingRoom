<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MeetSpace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased">
    <div class="min-h-screen relative flex items-center justify-center md:justify-end px-4 md:pe-48 py-10 overflow-hidden">


        <!-- Background image -->
        <div class="absolute inset-0 bg-cover bg-center"
             style="background-image: url('{{ asset('images/meetspace-bg.png') }}');">
        </div>

        <!-- Soft overlay -->
        <div class="absolute inset-0 bg-white/10"></div>

        <!-- Centered content -->
        <div class="relative w-full max-w-md">
    {{ $slot }}
</div>

    </div>
</body>
</html>
