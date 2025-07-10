<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('seo_title', 'GameCodesHub – Roblox & Mobile Game Codes')</title>
    <meta name="description" content="@yield('seo_description', 'Find the latest working redeem codes for top Roblox and mobile games. Updated daily with free rewards!')">
    <meta name="keywords" content="@yield('seo_keywords', 'Roblox, Mobile Game, Codes, Redeem Codes, Free Rewards')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(View::hasSection('seo_canonical'))
        <link rel="canonical" href="@yield('seo_canonical')">
    @else
        <link rel="canonical" href="{{ url()->current() }}">
    @endif



    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-800 min-h-screen">
    @include('components.navbar')
    <main class="pt-20">
        @yield('content')
    </main>
    @include('components.footer')
</body>
</html>
