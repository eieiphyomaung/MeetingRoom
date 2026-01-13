@extends('layouts.user')
@section('page_title', 'Profile')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- Header row (aligns with top right username/logout) --}}
    <div class="mb-6">
        <p class="text-slate-400 mt-2">Update your name and password.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-teal-400/20 bg-teal-400/10 px-4 py-3 text-teal-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Profile summary (smaller) --}}
        <div class="rounded-3xl bg-white/5 border border-white/10 overflow-hidden">
            <div class="p-6 border-b border-white/10 bg-gradient-to-r from-sky-500/15 to-teal-400/10">
                <div class="text-2xl font-bold text-slate-100 truncate">
                    {{ auth()->user()->username ?? auth()->user()->name }}
                </div>

                <div class="mt-3 inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-3 py-1 text-sm text-slate-200">
                    <span class="h-2 w-2 rounded-full bg-teal-300"></span>
                    <span>{{ auth()->user()->department?->depart_name ?? 'No Department' }}</span>

                </div>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <div class="text-slate-400 text-sm">Email</div>
                    <div class="text-slate-200 mt-1 break-all">{{ auth()->user()->email }}</div>
                </div>

                <div class="text-slate-500 text-sm">
                    Email cannot be changed.
                </div>
            </div>
        </div>

        {{-- RIGHT: Forms (normal width, not huge) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Update name --}}
            <div class="rounded-3xl bg-white/5 border border-white/10 shadow-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-white/10">
                    <div class="text-xl font-bold text-slate-100">Account Info</div>
                    <div class="text-slate-400 text-sm mt-1">Change your display name.</div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="text-slate-300 font-semibold">Full Name</label>
                        <input name="name"
                              value="{{ old('name', auth()->user()->username) }}"
                               class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                                      focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                               required>
                        @error('name')
                            <div class="text-rose-300 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pt-2 flex justify-end gap-3">
                        <a href="{{ route('dashboard') }}"
                           class="rounded-2xl px-6 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
                            Cancel
                        </a>

                        <button type="submit"
                                class="rounded-2xl px-6 py-3 bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
                                       hover:from-sky-400 hover:to-teal-300">
                            Update Name
                        </button>
                    </div>
                </form>
            </div>

            {{-- Update password (NO nested form) --}}
            <div class="rounded-3xl bg-white/5 border border-white/10 overflow-hidden">
                <div class="px-6 py-5 border-b border-white/10 flex items-center justify-between">
                    <div>
                        <div class="text-xl font-bold text-slate-100">Security</div>
                        <div class="text-slate-400 text-sm mt-1">Change your password.</div>
                    </div>

                    <button type="button" onclick="togglePasswordBox()"
  class="h-10 w-10 rounded-2xl bg-white/5 border border-white/10
         hover:bg-white/10 transition flex items-center justify-center text-teal-200"
  title="Change password">
  <svg class="w-6 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 17a2 2 0 0 0 2-2v-2a2 2 0 1 0-4 0v2a2 2 0 0 0 2 2z"/>
    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8V7a5 5 0 0 0-10 0v1"/>
    <rect x="5" y="8" width="14" height="14" rx="2"/>
  </svg>
</button>

                </div>

                <div id="passwordBox" class="hidden p-6">
                    <form method="POST" action="{{ route('profile.password') }}" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="text-slate-300 font-semibold">New Password</label>
                            <div class="mt-2 relative">
                                <input id="new_password" name="password" type="password" required
                                       class="w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 pr-12 text-white
                                              focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                                       placeholder="Enter new password">
                                <button type="button" onclick="toggleEye('new_password')"
                                        class="absolute inset-y-0 right-3 flex items-center text-slate-300 hover:text-teal-200">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-rose-300 text-sm mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="text-slate-300 font-semibold">Confirm New Password</label>
                            <div class="mt-2 relative">
                                <input id="confirm_password" name="password_confirmation" type="password" required
                                       class="w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 pr-12 text-white
                                              focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                                       placeholder="Confirm new password">
                                <button type="button" onclick="toggleEye('confirm_password')"
                                        class="absolute inset-y-0 right-3 flex items-center text-slate-300 hover:text-teal-200">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button class="rounded-2xl px-6 py-3 bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
                                           hover:from-sky-400 hover:to-teal-300">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function togglePasswordBox() {
    document.getElementById('passwordBox').classList.toggle('hidden');
}
function toggleEye(inputId) {
    const input = document.getElementById(inputId);
    input.type = (input.type === 'password') ? 'text' : 'password';
}
</script>
@endsection
