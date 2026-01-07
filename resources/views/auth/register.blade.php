<x-guest-layout>

    <!-- Glass Card (wider) -->
    <div class="w-full max-w-lg rounded-3xl border border-white/40 bg-white/30 backdrop-blur-xl
                shadow-2xl shadow-slate-900/10 p-8">

        <!-- Logo / Title only (NO Register title) -->
        <div class="flex items-center justify-center mb-6">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/meetspace-pin.png') }}" alt="MeetSpace" class="h-14 w-10" />
                <span class="text-2xl font-bold text-slate-800">
                    Meet<span class="text-teal-600">Space</span>
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Department -->
<div>
    <x-input-label for="depart_id" :value="__('Department')" class="!text-slate-600 !text-sm !font-medium" />

    <select id="depart_id" name="depart_id" required
        class="mt-1 block w-full rounded-2xl
               !bg-white/45 backdrop-blur-xl
               !text-slate-800
               !border-white/40 border
               focus:!border-sky-500 focus:!ring-sky-400/50 focus:ring-2
               [&>option]:bg-slate-900 [&>option]:text-slate-100">
        <option value="" disabled {{ old('depart_id') ? '' : 'selected' }}>
            Select Department
        </option>

        @foreach($departments as $dept)
            <option value="{{ $dept->depart_id }}" {{ old('depart_id') == $dept->depart_id ? 'selected' : '' }}>
                {{ $dept->depart_name }}
            </option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get('depart_id')" class="mt-2" />
</div>


            <!-- Username -->
            <div class="mt-4">
                <x-input-label for="username" :value="__('Username')"
                              class="!text-slate-700 !text-sm !font-semibold" />

                <x-text-input id="username" type="text" name="username" :value="old('username')" required autofocus
                              autocomplete="username"
                              class="mt-2 block w-full rounded-2xl
                                     !bg-white/45 backdrop-blur-xl
                                     !text-slate-800
                                     !border-white/40 border
                                     placeholder:!text-slate-500
                                     focus:!border-sky-500 focus:!ring-sky-400/50 focus:ring-2" />

                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')"
                              class="!text-slate-700 !text-sm !font-semibold" />

                <x-text-input id="email" type="email" name="email" :value="old('email')" required
                              autocomplete="email"
                              class="mt-2 block w-full rounded-2xl
                                     !bg-white/45 backdrop-blur-xl
                                     !text-slate-800
                                     !border-white/40 border
                                     placeholder:!text-slate-500
                                     focus:!border-sky-500 focus:!ring-sky-400/50 focus:ring-2" />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')"
                              class="!text-slate-700 !text-sm !font-semibold" />

                <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                              class="mt-2 block w-full rounded-2xl
                                     !bg-white/45 backdrop-blur-xl
                                     !text-slate-800
                                     !border-white/40 border
                                     placeholder:!text-slate-500
                                     focus:!border-sky-500 focus:!ring-sky-400/50 focus:ring-2" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                              class="!text-slate-700 !text-sm !font-semibold" />

                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                              autocomplete="new-password"
                              class="mt-2 block w-full rounded-2xl
                                     !bg-white/45 backdrop-blur-xl
                                     !text-slate-800
                                     !border-white/40 border
                                     placeholder:!text-slate-500
                                     focus:!border-sky-500 focus:!ring-sky-400/50 focus:ring-2" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div> --}}

            <!-- Button -->
            <div class="mt-6">
                <x-primary-button
                    class="w-full justify-center rounded-2xl py-3 text-base font-semibold
                           bg-gradient-to-r from-sky-500 to-teal-400
                           hover:from-sky-600 hover:to-teal-500
                           !text-white/80
                           focus:ring-2 focus:ring-sky-300/60">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <!-- Login link -->
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    {{ __('Already registered?') }}
                </a>
            </div>

        </form>
    </div>

</x-guest-layout>
