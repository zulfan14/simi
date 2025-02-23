@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-lg text-red-500 text-left']) }}>
    {{ $value ?? $slot }}
</label>
