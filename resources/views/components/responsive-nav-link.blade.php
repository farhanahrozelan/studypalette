@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-customColor-primary-400 text-start text-base font-medium text-customColor-primary-700 bg-customColor-primary-50 focus:outline-none focus:text-customColor-primary-800 focus:bg-indigo-100 focus:border-customColor-primary-700 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-customColor-primary-600 hover:text-customColor-primary-800 hover:bg-customColor-primary-50 hover:border-customColor-primary-300 focus:outline-none focus:text-customColor-primary-800 focus:bg-customColor-primary-50 focus:border-customColor-primary-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
