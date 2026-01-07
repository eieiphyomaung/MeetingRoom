<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User') | MeetSpace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-b from-slate-950 via-slate-950 to-slate-900 text-slate-100">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
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
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl
               {{ request()->routeIs('user.dashboard') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
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
                🗓 <span class="font-medium">Calendar View</span>
            </a>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl
               {{ request()->routeIs('profile.*') ? 'bg-white/10 text-teal-300 border border-white/10' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                👤 <span class="font-medium">Profile</span>
            </a>
        </nav>
    </aside>

    {{-- Main --}}
    <main class="flex-1 flex flex-col">
        {{-- Top bar --}}
        <header class="flex items-center justify-between px-8 py-6">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">@yield('page_title', 'Dashboard')</h1>
                <p class="text-slate-400 mt-1">@yield('page_subtitle')</p>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">
                {{-- Notifications --}}
                <a href="{{ route('user.notifications') }}"
                   class="relative h-11 w-11 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition flex items-center justify-center">
                    {{-- bell icon --}}
                    <svg class="w-5 h-5 text-slate-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9"/>
                    </svg>

                    @php $unread = $unreadCount ?? 0; @endphp
                    @if($unread > 0)
                        <span class="absolute -top-1 -right-1 text-xs px-2 py-0.5 rounded-full bg-teal-400 text-slate-900 font-bold">
                            {{ $unread }}
                        </span>
                    @endif
                </a>

                {{-- User chip --}}
                <div class="flex items-center gap-3 rounded-2xl bg-white/5 border border-white/10 px-4 py-2">
                    <div class="h-9 w-9 rounded-full bg-teal-400/20 border border-teal-400/20 flex items-center justify-center font-bold text-teal-200">
                        {{ strtoupper(substr(auth()->user()->username ?? auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="leading-tight">
                        <div class="font-semibold">{{ auth()->user()->username ?? auth()->user()->name }}</div>
                        <div class="text-xs text-slate-400">User</div>
                    </div>

                    <div class="h-5 w-px bg-white/10 mx-2"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex items-center gap-2 text-slate-300 hover:text-rose-300 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <div class="px-8 pb-10 flex-1">
            @yield('content')
        </div>

        {{-- Footer --}}
        <footer class="py-6 text-center text-slate-400 text-sm border-t border-white/5">
            © {{ date('Y') }} MeetSpace Reservation System. All rights reserved.
        </footer>
    </main>
</div>
</body>
</html>
