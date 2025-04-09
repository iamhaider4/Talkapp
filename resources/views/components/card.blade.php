@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow-sm sm:rounded-lg']) }}>
    <div class="p-6">
        @if($title)
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $title }}</h3>
        @endif
        {{ $slot }}
    </div>
</div>
