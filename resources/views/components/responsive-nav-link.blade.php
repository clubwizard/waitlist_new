@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-tableready-yellow text-start text-base font-medium text-white bg-green-700 focus:outline-none focus:text-white focus:bg-green-600 focus:border-tableready-orange transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-white hover:bg-green-700 hover:border-tableready-yellow focus:outline-none focus:text-white focus:bg-green-700 focus:border-tableready-yellow transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
