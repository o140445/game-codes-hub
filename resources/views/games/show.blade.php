@extends('layouts.app')

@section('seo_title', $game->name . ' - GameCodesHub')
@section('seo_description', $game->description )
@section('seo_keywords', $game->name . ', game codes, gaming')
@section('seo_canonical', url('/' . $game->slug))

@section('structured_data')
    @verbatim
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "Game",
              "name": "{{ $game->title }}",
              "description": "{{ $game->description . ' Updated July 2025 – unlock your power now!' ?? Str::limit(strip_tags($game->content), 160) }}",
              "url": "{{ route('games.show', $game->id) }}",
              "image": "{{ $game->image ? asset('storage/'.$game->image) : 'https://gamecodeshub.com/og/gag.jpeg' }}",
              "author": {
                "@type": "Person",
                "name": "{{ $game->author ?? 'GameCodesHub' }}"
              },
              "datePublished": "{{ $game->created_at->toISOString() }}",
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
<div class="max-w-6xl w-full mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="/" class="hover:text-gray-800 transition-colors">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="/games" class="hover:text-gray-800 transition-colors">Games</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-800">{{ $game->name }}</li>
        </ol>
    </nav>

    <!-- Game Header -->
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8 border border-gray-200">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 ">
            <!-- Game Image -->
            <div class="lg:col-span-1">
                <img src="{{ asset($game->image) }}"
                     alt="{{ $game->name }}"
                     class="w-full h-64 lg:h-80 object-cover rounded-lg shadow-lg">
            </div>

            <!-- Game Info -->
            <div class="lg:col-span-2 flex flex-col gap-4 justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $game->name }}</h1>

                    <div class="flex flex-wrap gap-4 mb-6">
                        @if($game->category)
                            <span class="px-3 py-1 bg-gray-800 text-white rounded-full text-sm font-medium">
                                {{ $game->category }}
                            </span>
                        @endif
                        @if($game->platform)
                            <span class="px-3 py-1 bg-gray-200 text-gray-800 rounded-full text-sm">
                                {{ $game->platform }}
                            </span>
                        @endif
                    </div>


                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ $game->summary ?? 'No summary available.' }}
                    </p>
                </div>


                <!-- Game Stats -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $game->codes_total ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Total Codes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $game->codes_valid ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Valid Codes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $game->created_at->format('M Y') }}</div>
                        <div class="text-sm text-gray-600">Added</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Game Content Section -->
    @if($game->content)
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8 border border-gray-200">
            <div class="prose max-w-none text-gray-800">
                {!! $game->content !!}
            </div>
        </div>
    @endif

    <!-- Game Codes Section -->
    @if($game->codes && $game->codes->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        {{ $game->name  }}
        </h2>

        <div class="gap-2 flex flex-col">
            @foreach($game->codes as $code)
                <div class="bg-gray-50 rounded-lg p-2 shadow hover:shadow-lg transition-shadow duration-200 text-gray-800 w-full flex flex-col md:flex-row items-center gap-2 justify-between">
                    <div class="flex-1 bg-white rounded-lg pl-2 border border-gray-200 md:w-7/12 w-full flex justify-between">
                        <div class="flex items-center gap-2 ">
                            @if($code->is_latest)
                                <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full font-medium">NEW</span>
                            @endif
                            <code class="text-gray-800 font-mono text-sm break-all">{{ $code->code ?? 'No code available' }}</code>
                        </div>

                        <button
                        class="copy-btn bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors font-medium min-w-[80px]"
                        data-code="{{ $code->code ?? '' }}"
                        onclick="copyCode(this)"
                        >
                            Copy
                        </button>
                    </div>

                    <div class="text-gray-500 text-sm md:w-5/12 w-full text-end">
                        <span class="text-gray-500 text-sm">
                            {{ $code->name ?? 'No name available' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
             {{ $game->name  }}
        </h2>
        <p class="text-gray-600">Currently, there are no codes available for this game.</p>
    </div>
    @endif


    <!-- Expired Codes -->
    @if ($game->invalidCodes && $game->invalidCodes->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            Expired Codes
        </h2>

        <div class="gap-2 flex flex-col">
            @foreach($game->invalidCodes as $code)
                <div class="bg-gray-50 rounded-lg p-2 shadow hover:shadow-lg transition-shadow duration-200 text-gray-800 w-full flex flex-col md:flex-row items-center gap-2 justify-between">
                    <div class="flex-1 bg-white rounded-lg p-2 border border-gray-200 md:w-7/12 w-full flex justify-between">
                        <code class="text-gray-600 font-mono text-sm break-all">{{ $code->code ?? 'No code available' }}</code>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif


    <!-- How to Redeem Section -->
    @if($game->how_to_redeem)
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            How to Redeem Codes
        </h2>
        <div class="prose max-w-none text-gray-800">
            {!! $game->how_to_redeem !!}
        </div>
    </div>
    @endif

    <!-- FAQ Section -->
    @if($game->faq)
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mb-8 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
             FAQ
        </h2>
        <div class="prose max-w-none  text-gray-800">
            {!! $game->faq !!}
        </div>
    </div>
    @endif



    <!-- Related Games Section -->
    @if(isset($relatedGames) && $relatedGames->count() > 0)
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <span class="text-gray-600">🎮</span> Related Games
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relatedGames as $relatedGame)
                <x-game-card :game="$relatedGame" size="default" />
            @endforeach
        </div>
    </div>
    @endif

    <script>
        function copyCode(button) {
            const code = button.dataset.code;
            const textArea = document.createElement('textarea');
            textArea.value = code;
            document.body.appendChild(textArea);
            textArea.select();

            try {
                document.execCommand('copy');
                button.textContent = 'Copied!';
                button.classList.add('bg-green-500', 'hover:bg-green-600');
                button.classList.remove('bg-gray-800', 'hover:bg-gray-700');
                setTimeout(() => {
                    button.textContent = 'Copy';
                    button.classList.remove('bg-green-500', 'hover:bg-green-600');
                    button.classList.add('bg-gray-800', 'hover:bg-gray-700');
                }, 2000);
            } catch (err) {
                console.error('Failed to copy code:', err);
                button.textContent = 'Error!';
                button.classList.add('bg-red-500', 'hover:bg-red-600');
                button.classList.remove('bg-gray-800', 'hover:bg-gray-700');
                setTimeout(() => {
                    button.textContent = 'Copy';
                    button.classList.remove('bg-red-500', 'hover:bg-red-600');
                    button.classList.add('bg-gray-800', 'hover:bg-gray-700');
                }, 2000);
            } finally {
                document.body.removeChild(textArea);
            }
        }
    </script>
</div>
@endsection
