@extends('layouts.app')

@section('seo_title', 'GameCodesHub – Roblox & Mobile Game Codes')
@section('seo_description', 'CodesHub is your go-to source for the latest redeem codes across Roblox and mobile games. Find active codes for Da Hood, Anime Saga, Grow a Garden, and more. Updated daily!')
@section('seo_keywords', 'game codes, gaming rewards, roblox codes, mobile game codes, gaming content')
@section('seo_canonical', url('/'))

@section('structured_data')
    @verbatim
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "WebSite",
              "name": "GameCodesHub",
              "url": "https://gamecodeshub.com/",
              "description": "GameCodesHub shares daily updated redeem codes for Roblox and mobile games including Da Hood, Grow a Garden, and Anime Saga.",
              "inLanguage": "en",
              "publisher": {
                "@type": "Organization",
                "name": "GameCodesHub",
                "url": "https://gamecodeshub.com/"
              }
            }
        </script>
    @endverbatim
@endsection


@section('content')
<div class="max-w-6xl w-full mx-auto px-2 sm:px-4 py-4 sm:py-8">
    <div class="mb-4 max-w-6xl mx-auto">
        @include('components.search')
    </div>

    <!-- POPULAR -->
    <div class="mb-4 max-w-6xl mx-auto">
        <h2 class="text-lg sm:text-xl font-bold mb-4 flex items-center gap-2 text-gray-200">
            <span class="text-xl sm:text-2xl text-yellow-400">⭐️</span> POPULAR
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-8 ">
            <!-- Main Card -->
            <div class="md:col-span-2 bg-gray-900 rounded-lg shadow-lg p-3 sm:p-4 flex flex-col md:flex-row gap-3 sm:gap-4
            transition-all duration-200 hover:scale-105 hover:shadow-xl group cursor-pointer border border-gray-700 relative">
                <a href="{{ route('games.show', $data['first']['slug']) }}" class="w-full md:h-96 h-48">
                    <img src="{{ asset($data['first']['image']) }}" alt="{{ $data['first']['slug'] }}" class="rounded-lg w-full h-full object-fill">
                </a>
                <!-- 悬浮在图片上 左下角 -->
                <div class="absolute bottom-5 left-5 flex items-center justify-center">
                    <h1 class=" text-3xl sm:text-2xl font-bold mb-2 transition-colors duration-200 group-hover:text-yellow-400 text-white">{{ $data['first']['name'] }}</h1>
                </div>

            </div>
            <!-- Small Cards -->
            <div class="flex flex-col gap-2 sm:gap-4">
                @foreach($data['recommended'] as $game)
                <a href="{{ route('games.show', $game['slug']) }}"  class="flex gap-2 sm:gap-3 bg-gray-900 rounded-lg shadow-lg p-2 transition-all duration-200 hover:scale-105 hover:shadow-xl group cursor-pointer border border-gray-700">
                    <img src="{{ asset($game['image']) }}" class="rounded w-20 h-14 sm:w-24 sm:h-16 object-cover" alt="{{ $game['slug'] }}">
                    <div class="flex-1 flex flex-col justify-between pb-2">
                        <h4 class="font-semibold text-xs sm:text-sm mb-1 transition-colors duration-200 group-hover:text-yellow-400 text-gray-200">{{ $game['name'] }}</h4>
                        <div class="text-xs text-gray-500 flex items-center gap-1 sm:gap-2">
                            <span>By {{ $game['author'] }}</span>
                            <span>{{ $game['update_date'] }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- HOT GAMES -->
    <div class="mb-10">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-gray-200">
                <span class="text-2xl text-yellow-400">🔥</span> HOT GAMES
            </h2>
            <a href="/games" class="text-yellow-400 hover:text-yellow-300 transition-colors">View All </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-10">
            @foreach($data['hot'] as $game)
                <x-game-card :game="$game" size="default" />
            @endforeach
        </div>
    </div>

    <!-- NEW GAMES -->
    <div class="mb-10">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-gray-200">
                <span class="text-2xl text-yellow-400">📰</span> Last Updated
            </h2>
            <a href="/" class="text-yellow-400 hover:text-yellow-300 transition-colors">View All </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($data['new'] as $game)
                <x-game-card :game="$game" size="default" />
            @endforeach
        </div>
    </div>
</div>
@endsection
