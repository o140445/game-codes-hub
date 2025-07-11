@props(['game', 'size' => 'default'])

@php
    $sizeClasses = [
        'small' => 'p-2',
        'default' => 'p-3',
        'large' => 'p-4'
    ];

    $imageClasses = [
        'small' => 'w-20 h-14 sm:w-24 sm:h-16',
        'default' => 'w-full h-40',
        'large' => 'w-full h-48'
    ];

    $titleClasses = [
        'small' => 'text-xs sm:text-sm',
        'default' => 'text-sm',
        'large' => 'text-base'
    ];

    $contentClasses = [
        'small' => 'text-xs',
        'default' => 'text-xs',
        'large' => 'text-sm'
    ];

    // Handle different data structures
    $gameName = $game['name'] ?? $game->name ?? 'Unknown Game';
    $gameSlug = $game['slug'] ?? $game->slug ?? '';
    $gameImage = $game['image'] ?? $game->image ?? '/images/default-game.jpg';
    $gameContent = $game['summary'] ?? $game->summary ?? '';
    $gameAuthor = $game['author'] ?? $game->author ?? 'Admin';
    $gameDate = $game['update_date'] ?? $game->updated_at ?? $game->created_at ?? now();
    $gameViews = $game['views'] ?? $game->views ?? 0;
@endphp

<a href="{{ route('games.show', $gameSlug) }}"
   class="bg-gray-900 rounded-lg shadow-lg {{ $sizeClasses[$size] }} flex {{ $size === 'small' ? 'gap-2 sm:gap-3' : 'flex-col' }} transition-all duration-200 hover:scale-105 hover:shadow-xl group cursor-pointer border border-gray-700">

    @if($size === 'small')
        <!-- Small card layout: horizontal arrangement -->
        <img src="{{ asset($gameImage) }}"
             class="rounded {{ $imageClasses[$size] }} object-cover"
             alt="{{ $gameSlug }}">
        <div class="flex-1 flex flex-col justify-between pb-2">
            <h4 class="font-semibold {{ $titleClasses[$size] }} mb-1 transition-colors duration-200 group-hover:text-yellow-400 text-gray-200">
                {{ $gameName }}
            </h4>
            <div class="text-xs text-gray-500 flex items-center gap-1 sm:gap-2">
                <span>By {{ $gameAuthor }}</span>
                <span>{{ is_string($gameDate) ? $gameDate : $gameDate->format('M d, Y') }}</span>
                <span class="flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                    {{ $gameViews }}
                </span>
            </div>
        </div>
    @else
        <!-- Default/large card layout: vertical arrangement -->
        <img src="{{ asset($gameImage) }}"
             class="rounded mb-2 object-cover {{ $imageClasses[$size] }} transition-all duration-200 group-hover:brightness-110"
             alt="{{ $gameSlug }}">
        <h4 class="font-semibold mb-1 transition-colors duration-200 group-hover:text-yellow-400 text-gray-200 {{ $titleClasses[$size] }} line-clamp-1">
            {{ $gameName }}
        </h4>
        <p class="{{ $contentClasses[$size] }} text-gray-400 mb-2 line-clamp-3">{{ $gameContent }}</p>
        <div class="flex items-center text-xs text-gray-500 gap-2 mt-auto">
            <span>By {{ $gameAuthor }}</span>
            <span>{{ is_string($gameDate) ? $gameDate : $gameDate->format('M d, Y') }}</span>
        </div>
    @endif
</a>
