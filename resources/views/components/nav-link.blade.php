@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-customColor-primary-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-customColor-primary-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-customColor-primary-500 hover:text-customColor-primary-700 hover:border-customColor-primary-300 focus:outline-none focus:text-customColor-primary-700 focus:border-customColor-primary-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
