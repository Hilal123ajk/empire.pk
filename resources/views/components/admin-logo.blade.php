@props(['size' => 'md'])

@php
    $sizeClasses = match ($size) {
        'sm' => 'text-xl sm:text-2xl tracking-[-0.05em]',
        'lg' => 'text-[2rem] sm:text-[2.35rem] tracking-[-0.07em]',
        default => 'text-[1.65rem] sm:text-[1.85rem] md:text-[2rem] tracking-[-0.06em] sm:tracking-[-0.07em]',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-logo font-medium leading-none select-none {$sizeClasses}"]) }}>
    <span class="text-brand-navy">empire</span>
    <span class="text-brand-gold text-[1em] leading-none mx-0.5 mt-4">•</span>
    <span class="text-brand-gold">pk</span>
</span>
