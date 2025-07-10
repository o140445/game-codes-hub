@extends('layouts.app')

@section('seo_title', 'All Games - GameCodesHub')
@section('seo_description', 'Browse all games and find the latest game codes, rewards, and gaming content.')
@section('seo_keywords', 'games, game codes, gaming, rewards')
@section('seo_canonical', url('/games'))

@section('structured_data')
    @php
        $items = $games->map(function($game, $index) {
            return [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'item' => [
                    '@type' => 'Game',
                    'name' => $game['name'],
                    'description' => $game['description'],
                    'url' => url('/' . $game['slug']),
                    'image' => asset($game['image']),
                ]
            ];
        });
    @endphp

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => 'All Games',
            'description' => 'Browse all games and find the latest game codes, rewards, and gaming content.',
            'url' => url('/games'),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'GameCodesHub',
                'url' => 'https://gamecodeshub.com/',
            ],
            'numberOfItems' => $games->total(),
            'itemListElement' => $items,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('content')
    <div class="max-w-6xl w-full mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-200 mb-4">All Games</h1>
            <p class="text-gray-400">Discover the latest games and exclusive codes</p>
        </div>

        <!-- Search and Filters -->
        <div class="bg-gray-900 rounded-2xl shadow-lg p-6 mb-8 border border-gray-700">
            <form method="GET" action="{{ route('games.index') }}" class="space-y-6">
                <!-- Search Bar -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search games..."
                               class="w-full px-4 py-3 rounded-lg border border-gray-700 bg-gray-800 text-gray-200 placeholder-gray-400 focus:border-yellow-400 focus:bg-gray-900 focus:outline-none transition">
                    </div>
                    <button type="submit"
                            class="px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-lg hover:bg-yellow-300 transition-colors">
                        Search
                    </button>
                </div>

                <!-- Filters -->
                <!-- <div class="grid grid-cols-1 md:grid-cols-4 gap-4"> -->
                <!-- Category Filter -->
                <!-- <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Category</label>
                    <select name="category"
                            class="w-full px-3 py-2 rounded-lg border border-gray-700 bg-gray-800 text-gray-200 focus:border-yellow-400 focus:outline-none">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ $category }}
                    </option>
@endforeach
                </select>
            </div> -->

                <!-- Platform Filter -->
                <!-- <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Platform</label>
                    <select name="platform"
                            class="w-full px-3 py-2 rounded-lg border border-gray-700 bg-gray-800 text-gray-200 focus:border-yellow-400 focus:outline-none">
                        <option value="">All Platforms</option>
                        @foreach($platforms ?? [] as $platform)
                    <option value="{{ $platform }}" {{ request('platform') == $platform ? 'selected' : '' }}>
                                {{ $platform }}
                    </option>
@endforeach
                </select>
            </div> -->

                <!-- Sort By -->
                <!-- <div>
                    <label class="block text-gray-300 text-sm font-medium mb-2">Sort By</label>
                    <select name="sort"
                            class="w-full px-3 py-2 rounded-lg border border-gray-700 bg-gray-800 text-gray-200 focus:border-yellow-400 focus:outline-none">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Most Views</option>
                    </select>
                </div> -->

                <!-- Clear Filters -->
                <!-- <div class="flex items-end">
                    <a href="{{ route('games.index') }}"
                       class="w-full px-4 py-2 bg-gray-700 text-gray-200 font-medium rounded-lg hover:bg-gray-600 transition-colors text-center">
                        Clear Filters
                    </a>
                </div> -->
                <!-- </div> -->
            </form>
        </div>

        <!-- Results Info -->
        <div class="flex justify-between items-center mb-6">
            <p class="text-gray-400">
                Showing {{ $games->firstItem() ?? 0 }} - {{ $games->lastItem() ?? 0 }} of {{ $games->total() }} games
            </p>
            <!-- <div class="flex items-center gap-2 text-gray-400">
            <span>View:</span>
            <button class="px-3 py-1 rounded {{ request('view') != 'grid' ? 'bg-yellow-400 text-gray-900' : 'bg-gray-700 text-gray-200' }} transition-colors">
                List
            </button>
            <button class="px-3 py-1 rounded {{ request('view') == 'grid' ? 'bg-yellow-400 text-gray-900' : 'bg-gray-700 text-gray-200' }} transition-colors">
                Grid
            </button>
        </div> -->
        </div>

        <!-- Games Grid -->
        @if($games->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($games as $game)
                    <x-game-card :game="$game" size="default" />
                @endforeach
            </div>

            <!-- Pagination -->
            @if($games->hasPages())
                <div class="mt-8 flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <!-- Previous Page -->
                        @if($games->onFirstPage())
                            <span class="px-4 py-2 text-gray-500 bg-gray-800 border border-gray-700 rounded-lg cursor-not-allowed">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        @else
                            <a href="{{ $games->previousPageUrl() }}" class="px-4 py-2 text-gray-200 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700 hover:border-yellow-400 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        @endif

                        <!-- Page Numbers -->
                        @php
                            $currentPage = $games->currentPage();
                            $lastPage = $games->lastPage();
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $games->url(1) }}" class="px-4 py-2 text-gray-200 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700 hover:border-yellow-400 transition-colors">
                                1
                            </a>
                            @if($start > 2)
                                <span class="px-4 py-2 text-gray-500">...</span>
                            @endif
                        @endif

                        @for($page = $start; $page <= $end; $page++)
                            @if($page == $currentPage)
                                <span class="px-4 py-2 text-gray-900 bg-yellow-400 border border-yellow-400 rounded-lg font-semibold">
                                {{ $page }}
                            </span>
                            @else
                                <a href="{{ $games->url($page) }}" class="px-4 py-2 text-gray-200 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700 hover:border-yellow-400 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor

                        @if($end < $lastPage)
                            @if($end < $lastPage - 1)
                                <span class="px-4 py-2 text-gray-500">...</span>
                            @endif
                            <a href="{{ $games->url($lastPage) }}" class="px-4 py-2 text-gray-200 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700 hover:border-yellow-400 transition-colors">
                                {{ $lastPage }}
                            </a>
                        @endif

                        <!-- Next Page -->
                        @if($games->hasMorePages())
                            <a href="{{ $games->nextPageUrl() }}" class="px-4 py-2 text-gray-200 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700 hover:border-yellow-400 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        @else
                            <span class="px-4 py-2 text-gray-500 bg-gray-800 border border-gray-700 rounded-lg cursor-not-allowed">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        @endif
                    </nav>
                </div>
            @endif
        @else
            <!-- No Results -->
            <div class="bg-gray-900 rounded-2xl shadow-lg p-12 text-center border border-gray-700">
                <div class="text-6xl mb-4">🎮</div>
                <h3 class="text-xl font-semibold text-gray-200 mb-2">No games found</h3>
                <p class="text-gray-400 mb-6">Try adjusting your search criteria or browse all games</p>
                <a href="{{ route('games.index') }}"
                   class="px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-lg hover:bg-yellow-300 transition-colors">
                    Browse All Games
                </a>
            </div>
        @endif

        <!-- Popular Categories -->
        @if(isset($popularCategories) && $popularCategories->count() > 0)
            <div class="mt-12 bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-700">
                <h2 class="text-xl font-bold text-gray-200 mb-4">Popular Categories</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($popularCategories as $category)
                        <a href="{{ route('games.index', ['category' => $category->name]) }}"
                           class="px-4 py-2 bg-gray-800 text-gray-200 rounded-lg hover:bg-yellow-400 hover:text-gray-900 transition-colors">
                            {{ $category->name }}
                            <span class="text-gray-400 text-sm">({{ $category->games_count }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
