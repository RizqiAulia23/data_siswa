@props([
    'name',
    'id' => null,
    'required' => false,
    'disabled' => false,
    'placeholder' => null,
])

@php
    $inputId = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<select
    name="{{ $name }}"
    id="{{ $inputId }}"
    {{ $required ? 'required' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    @if ($hasError)
        aria-invalid="true"
        aria-describedby="{{ $inputId }}-error"
    @endif
    {{ $attributes->merge([
        'class' => 'w-full text-sm bg-white border rounded-lg px-3.5 py-2.5 text-slate-900 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-[border-color,box-shadow] duration-150 min-h-[40px] ' .
            ($hasError ? 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-300 hover:border-slate-400')
    ]) }}
>
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    {{ $slot }}
</select>
