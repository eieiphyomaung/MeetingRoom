@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' =>
            'border-white/50 bg-white/55 text-slate-900 placeholder:text-slate-500
             focus:border-sky-400 focus:ring-sky-400/30 rounded-xl shadow-sm'
    ]) !!} >
