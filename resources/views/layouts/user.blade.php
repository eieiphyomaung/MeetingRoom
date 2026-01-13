<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'MeetSpace')</title>
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

    <nav class="flex flex-col gap-3">
      <a href="{{ route('dashboard') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-2xl
         {{ request()->routeIs('dashboard') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        ▦ <span class="font-medium">Home</span>
      </a>

      <a href="{{ route('rooms.index') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-2xl
         {{ request()->routeIs('rooms.*') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        🏢 <span class="font-medium">Rooms</span>
      </a>

      <a href="{{ route('calendar.index') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-2xl
         {{ request()->routeIs('calendar.*') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        🗓 <span class="font-medium">Calendar</span>
      </a>

      <a href="{{ route('profile.edit') }}"
         class="flex items-center gap-3 px-4 py-3 rounded-2xl
         {{ request()->routeIs('profile.*') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
        👤 <span class="font-medium">Profile</span>
      </a>
    </nav>
  </aside>

  <!-- Main -->
  <main class="flex-1 flex flex-col">

    {{-- TOP ROW: page title (left) + pill (right) --}}
    <div class="px-8 pt-6 pb-2 flex items-center justify-between gap-6">
      <h1 class="text-3xl font-bold tracking-tight">
        @yield('page_title', '')
      </h1>

      <x-account-pill
        :label="auth()->user()->username ?? auth()->user()->name"
        dot="bg-teal-400"
        logoutRoute="logout"
      />
    </div>

    <!-- Content -->
    <div class="px-8 pb-10 flex-1">
      @yield('content')
    </div>

    <!-- Footer -->
    <footer class="py-6 text-center text-slate-400 text-sm border-t border-white/5">
      © {{ date('Y') }} MeetSpace Reservation System. All rights reserved.
    </footer>
  </main>
</div>

</body>
</html>
