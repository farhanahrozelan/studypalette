@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-white-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-sm shadow-sm']) !!}>
