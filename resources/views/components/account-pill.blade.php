@props([
  'label' => 'User',
  'dot' => 'bg-teal-400',
  'logoutRoute' => 'logout',
])

<header class="px-8 pt-6 pb-4">
  <div class="flex items-center justify-end">
    <div class="flex items-center rounded-2xl bg-white/5 border border-white/10 overflow-hidden">
      {{-- User --}}
      <div class="inline-flex items-center gap-2 px-4 py-3">
        <span class="h-2.5 w-2.5 rounded-full {{ $dot }}"></span>
        <span class="text-slate-100 font-semibold">{{ $label }}</span>
      </div>

      {{-- divider --}}
      <div class="h-7 w-px bg-white/10"></div>

      {{-- Logout (no border, red) --}}
      <form method="POST" action="{{ route($logoutRoute) }}">
        @csrf
        <button type="submit"
          class="inline-flex items-center gap-2 px-4 py-3 text-red-400 hover:text-red-300 hover:bg-white/5 transition">
          {{-- arrow-right-on-rectangle style --}}
          <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 4v16"/>
          </svg>
          <span class="font-semibold">Logout</span>
        </button>
      </form>
    </div>
  </div>
</header>
