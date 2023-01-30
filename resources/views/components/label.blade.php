@props(['value'])

<label {{ $attributes->merge(['class' => 'text-center block font-medium text-md text-gray-700 mb-3']) }}>
    {{ $value ?? $slot }}
</label>
