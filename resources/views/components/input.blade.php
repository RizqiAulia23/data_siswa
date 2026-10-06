@props([
    'name',
    'id' => null,
    'label' => null,
    'type' => 'text',
    'value' => null,
    'required' => false,
])

@php
    $inputId = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<div>
    @if ($label)
        <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="{{ $inputId }}">
            {{ $label }}{{ $required ? ' *' : '' }}
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ $value }}"
        {{ $required ? 'required' : '' }}
        @if ($hasError)
            aria-invalid="true"
            aria-describedby="{{ $inputId }}-error"
        @endif
        {{ $attributes->merge([
            'class' => 'w-full text-sm bg-white border rounded-lg px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 disabled:bg-slate-50 disabled:text-slate-400 disabled:cursor-not-allowed transition-[border-color,box-shadow] duration-150 ' .
                ($hasError ? 'border-rose-400 focus:border-rose-500 focus:ring-rose-500/20' : 'border-slate-300 hover:border-slate-400 focus:border-blue-600 focus:ring-blue-500/20')
        ]) }}
    >

    @if ($hasError)
        <p id="{{ $inputId }}-error" class="mt-1.5 text-xs text-rose-600 flex items-center space-x-1" role="alert">
            <span>{{ $errors->first($name) }}</span>
        </p>
    @endif
</div>
