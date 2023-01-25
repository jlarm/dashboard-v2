@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500 rounded-md shadow-sm']) !!}>
