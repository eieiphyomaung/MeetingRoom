@extends('layouts.user')
@section('title', 'Profile')

@section('content')
<div class="flex items-start justify-between mb-8">
    <div>
        <p class="text-slate-400 mt-1">Update your name and password.</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 rounded-2xl border border-teal-400/20 bg-teal-400/10 px-4 py-3 text-teal-200">
        {{ session('success') }}
    </div>
@endif

<div class="max-w-xl mx-auto">
    <div class="rounded-3xl bg-white/5 border border-white/10 shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="px-8 py-7 bg-gradient-to-r from-sky-500/25 to-teal-400/20 border-b border-white/10">
            <div class="text-3xl font-bold text-slate-100">{{ auth()->user()->name }}</div>

            @php
                $deptName = optional(auth()->user()->department)->name ?? 'No Department';
            @endphp

            <div class="mt-2 inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-3 py-1 text-sm text-slate-200">
                <span class="h-2 w-2 rounded-full bg-teal-300"></span>
                <span>{{ $deptName }}</span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-8 space-y-6">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div>
                    <label class="text-slate-300 font-semibold">Full Name</label>
                    <input name="name" value="{{ old('name', auth()->user()->name) }}"
                           class="mt-2 w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 text-white
                                  focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                           required>
                    @error('name')
                        <div class="text-rose-300 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email (readonly) -->
                <div>
                    <label class="text-slate-300 font-semibold">Email</label>

                    <div class="mt-2 relative">
                        <input value="{{ auth()->user()->email }}" readonly
                               class="w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 pr-12 text-slate-300 cursor-not-allowed">
                        <!-- X circle icon -->
                        <div class="absolute inset-y-0 right-3 flex items-center">
                            <div class="h-9 w-9 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300"
                                 title="Email cannot be changed">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M15 9l-6 6M9 9l6 6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change password button -->
                <div class="pt-2">
                    <button type="button" onclick="togglePasswordBox()"
                        class="w-full rounded-2xl px-4 py-3 bg-white/5 border border-white/10 text-slate-200
                               hover:bg-white/10 transition flex items-center justify-between">
                        <span class="font-semibold">Change Password</span>
                        <span class="text-slate-400 text-sm">Click to open</span>
                    </button>
                </div>

                <!-- Password box (hidden by default) -->
                <div id="passwordBox" class="hidden space-y-5 pt-2">
                    <div>
                        <label class="text-slate-300 font-semibold">New Password</label>
                        <div class="mt-2 relative">
                            <input id="new_password" name="password" type="password"
                                   class="w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 pr-12 text-white
                                          focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                                   placeholder="Enter new password">
                            <button type="button" onclick="toggleEye('new_password', this)"
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
                            <input id="confirm_password" name="password_confirmation" type="password"
                                   class="w-full rounded-2xl bg-white/5 border border-white/10 px-4 py-3 pr-12 text-white
                                          focus:outline-none focus:ring-2 focus:ring-teal-300/40"
                                   placeholder="Confirm new password">
                            <button type="button" onclick="toggleEye('confirm_password', this)"
                                    class="absolute inset-y-0 right-3 flex items-center text-slate-300 hover:text-teal-200">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('dashboard') }}"
                       class="rounded-2xl px-6 py-3 bg-white/10 border border-white/10 text-slate-200 hover:bg-white/15">
                        Cancel
                    </a>

                    <button type="submit"
                            class="rounded-2xl px-6 py-3 bg-gradient-to-r from-sky-500 to-teal-400 text-slate-900 font-semibold
                                   hover:from-sky-400 hover:to-teal-300">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePasswordBox() {
    document.getElementById('passwordBox').classList.toggle('hidden');
}

function toggleEye(inputId, btn) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
@endsection
