<x-guest-layout>

    {{-- Small glass frame --}}
    <div class="w-full max-w-xl rounded-3xl bg-white/40 backdrop-blur-xl border border-white/35 shadow-2xl p-8">

        {{-- Short description --}}
        <div class="mb-5 text-sm text-slate-700">
            {{ __('Forgot your password? Enter your email and we’ll send you a password reset link.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                {{-- Email title with color --}}
                <label for="email" class="block text-sm font-semibold text-slate-600 mb-2">
                    Email
                </label>

                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    placeholder="example@email.com"
                    class="block w-full rounded-xl bg-white/55 border border-white/50
                           text-slate-900 placeholder:text-slate-500
                           focus:outline-none focus:ring-2 focus:ring-sky-400/30"
                />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end pt-2">
                {{-- Cool tone button --}}
                <button type="submit"
                        class="rounded-xl px-6 py-3 font-semibold text-white
                               bg-gradient-to-r from-sky-500 to-teal-400
                               hover:from-sky-400 hover:to-teal-300 transition">
                    {{ __('Send Reset Link') }}
                </button>
            </div>
        </form>

    </div>
</x-guest-layout>
