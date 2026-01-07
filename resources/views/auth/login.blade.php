<x-guest-layout>

    <!-- Glass Card -->
    <div
        class="rounded-3xl border border-white/40 bg-white/30 backdrop-blur-xl
                shadow-2xl shadow-slate-900/10 p-8">

        <!-- Logo / Title -->
        <div class="flex items-center justify-center mb-6">
            <div class="flex items-center gap-2">
                <img
    src="{{ asset('images/meetspace-pin.png') }}"
    alt="MeetSpace"
    class="h-14 w-10"
/>
                <span class="text-2xl font-bold text-slate-800">
                    Meet<span class="text-teal-600">Space</span>
                </span>
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-slate-700" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

           <!-- Username -->
<div>
    <x-input-label for="username" :value="__('Username')" class="!text-slate-600 !text-sm !font-medium" />

    <x-text-input id="username" type="text" name="username" :value="old('username')" required autofocus
        autocomplete="username"
        class="mt-1 block w-full rounded-2xl
               !bg-white/45 backdrop-blur-xl
               !text-slate-800
               !border-white/40 border
               placeholder:!text-slate-500
               focus:!border-sky-500 focus:!ring-sky-400/50 focus:ring-2" />

    <x-input-error :messages="$errors->get('username')" class="mt-2" />
</div>

            <!-- Password -->
            <div class="mt-4">
              <x-input-label for="password" :value="__('Password')" class="!text-slate-600 !text-sm !font-medium" />

                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full rounded-2xl
       !bg-white/45 backdrop-blur-xl
       !text-slate-800
       !border-white/40 border
       placeholder:!text-slate-500
       focus:!border-sky-500 focus:!ring-sky-400/50 focus:ring-2" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between mt-4 text-sm">
                <label for="remember_me" class="inline-flex items-center text-slate-700">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-white/40 bg-white/30 text-blue-600
                               focus:ring-blue-500">
                   <span class="ms-2 text-sm !text-slate-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Button -->
            <div class="mt-6">
               <x-primary-button
    class="w-full justify-center rounded-2xl py-3 text-base font-semibold
           bg-gradient-to-r from-sky-500 to-teal-400
           hover:from-sky-600 hover:to-teal-500
           !text-white/80
           focus:ring-2 focus:ring-sky-300/60"
>
    {{ __('Sign In') }}
</x-primary-button>
            </div>

        </form>
    </div>

</x-guest-layout>
