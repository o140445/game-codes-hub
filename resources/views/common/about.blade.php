@extends('layouts.app')

@section('seo_title', 'About - GameCodesHub')
@section('seo_description', 'About GameCodesHub.')
@section('seo_keywords', 'About,GameCodesHub')
@section('seo_canonical', url('/about'))

@section('structured_data')
    @php
        $json = [
            '@context' => 'https://schema.org',
            '@type' => 'AboutPage',
            'name' => 'About GameCodesHub',
            'description' => 'Your ultimate destination for the latest and most reliable game codes, helping gamers unlock exclusive rewards and bonuses.',
            'url' => url('/about'),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'GameCodesHub',
                'url' => 'https://gamecodeshub.com/',
                'description' => 'GameCodesHub shares daily updated redeem codes for Roblox and mobile games including Da Hood, Grow a Garden, and Anime Saga.'
            ],
            'mainEntity' => [
                '@type' => 'Organization',
                'name' => 'GameCodesHub',
                'url' => 'https://gamecodeshub.com/',
                'description' => 'Your ultimate destination for the latest and most reliable game codes, helping gamers unlock exclusive rewards and bonuses.'
            ]
        ];
        $json = json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    @endphp

    <script type="application/ld+json">
        {!! $json !!}
    </script>
@endsection

@section('content')
<div class="max-w-3xl w-full mx-auto px-4 py-12">
    <!-- Hero Section -->
    <section class="text-center mb-12">
        <div class="inline-block bg-gray-100 rounded-full p-4 mb-4 shadow">
            <span class="text-4xl text-gray-600">🎮</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 mb-3">About</h1>
        <p class="text-lg text-gray-600 max-w-xl mx-auto">
            Your ultimate destination for the latest and most reliable game codes,<br>
            helping gamers unlock exclusive rewards and bonuses.
        </p>
    </section>

    <!-- Mission Section -->
    <section class="mb-12">
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-10 border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-3 text-center">Our Mission</h2>
            <p class="text-gray-700 mb-3 text-center">
                We're passionate about gaming and committed to providing players with
                the most up-to-date, verified game codes. Our platform serves as a
                bridge between game developers and the gaming community.
            </p>
            <p class="text-gray-600 text-center">
                Whether you're a casual player or a hardcore gamer, we ensure you
                never miss out on valuable rewards and exclusive content.
            </p>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="text-center pt-8 border-t border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Join Our Community</h2>
        <p class="text-gray-600 mb-4">
            Have questions, suggestions, or want to contribute?<br>
            <a href="/contact" class="text-gray-800 underline hover:text-gray-600">Contact us</a> or follow us on social media!
        </p>
    </section>
</div>
@endsection
