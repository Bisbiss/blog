@props(['title', 'align' => 'center'])

<div {{ $attributes->class(['text-center' => $align === 'center']) }}>
    <h2 class="text-3xl font-bold tracking-tight md:text-4xl">{{ $title }}</h2>
    <span @class(['block w-16 h-1 mt-3 rounded-full bg-amber-500', 'mx-auto' => $align === 'center']) aria-hidden="true"></span>
</div>
