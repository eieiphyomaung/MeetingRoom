<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | MeetSpace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen overflow-x-hidden bg-gradient-to-b from-slate-950 via-slate-950 to-slate-900 text-slate-100">

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 p-6 border-r border-white/5">
        <div class="flex items-center gap-3 mb-10">
    <div class="h-12 w-12 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center">
        <img src="{{ asset('images/meetspace-pin.png') }}" alt="MeetSpace" class="h-9 w-7">
    </div>
    <div class="text-xl font-bold">
        Meet<span class="text-teal-400">Space</span>
    </div>
</div>

        <!-- Equal spacing links -->
        <nav class="flex flex-col gap-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl
                      {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-teal-300' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                ▦ <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.rooms.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
          {{ request()->routeIs('admin.rooms.*') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
    🏢 <span class="font-medium">Rooms</span>
</a>

            <a href="{{ route('admin.departments.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
          {{ request()->routeIs('admin.departments.*') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
    🗂 <span class="font-medium">Department</span>
</a>

            <a href="{{ route('admin.reservations.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
          {{ request()->routeIs('admin.reservations.*') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
    📝 <span class="font-medium">Bookings</span>
</a>

            <a href="{{ route('admin.calendar.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white">
                🗓 <span class="font-medium">Calendar View</span>
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <main class="flex-1 flex flex-col">
        <!-- Top bar -->
       <header class="px-8 pt-6 pb-4">
    <div class="flex items-center justify-between gap-6">
        <h1 class="text-3xl font-bold tracking-tight">
            @yield('title', 'Dashboard')
        </h1>

        <x-account-pill label="Admin" dot="bg-teal-400" logoutRoute="logout" />


    </div>
</header>


        <!-- Content -->
        <div class="px-8 pb-10 flex-1">
    <div class="pt-2">
        @yield('content')
    </div>
</div>

        <!-- Footer -->
        <footer class="py-6 text-center text-slate-400 text-sm">
    © {{ date('Y') }} MeetSpace Reservation System. All rights reserved.
</footer>
    </main>

</div>
</body>
</html>
