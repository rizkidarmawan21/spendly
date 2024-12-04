@props([
    'id' => 'tooltip-' . uniqid(),
    'position' => 'top',
    'title' => '',
    'content' => '',
])

<div class="relative">
    <button type="button"
        class="peer cursor-pointer"
        aria-describedby="{{ $id }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22" />
        </svg>
    </button>
    <div id="{{ $id }}"
        class="pointer-events-none absolute {{ getTooltipPosition($position) }} z-10 flex w-64 flex-col gap-1 rounded bg-neutral-950 p-2.5 text-xs text-neutral-300 opacity-0 transition-all ease-out peer-hover:opacity-100 peer-focus:opacity-100 dark:bg-white dark:text-neutral-600"
        role="tooltip">
        <span class="text-sm font-medium text-white dark:text-neutral-900">{{ $title }}</span>
        <p class="text-balance">{{ $content }}</p>
    </div>
</div>

@php
    function getTooltipPosition($position)
    {
        return match ($position) {
            'top' => 'bottom-full mb-2 left-1/2 -translate-x-1/2',
            'bottom' => 'top-full mt-2 left-1/2 -translate-x-1/2',
            'left' => 'top-1/2 right-full -translate-y-1/2 mr-2',
            'right' => 'top-1/2 left-full -translate-y-1/2 ml-2',
            default => 'bottom-full mb-2 left-1/2 -translate-x-1/2',
        };
    }
@endphp
