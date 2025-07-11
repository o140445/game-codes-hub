<!-- Top Navigation -->
<nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-50 border-b border-gray-200" x-data="{ open: false }">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="/" class="text-2xl font-bold text-gray-800">
            <img src="/logo.png" alt="GameCodesHub" class="w-48 h-10">
        </a>
        <!-- Desktop menu -->
        <ul class="hidden md:flex gap-6 text-gray-600 font-medium">
            <li><a href="/" class="hover:text-gray-900 transition-colors">Home</a></li>
            <li><a href="/games" class="hover:text-gray-900 transition-colors">Games</a></li>
        </ul>

        <!-- Mobile hamburger button -->
        <button @click="open = !open" class="md:hidden text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-transition class="md:hidden bg-white border-t border-gray-200">
        <ul class="px-4 py-2 space-y-2">
            <li><a href="/" class="block py-2 text-gray-600 hover:text-gray-900 transition-colors">Home</a></li>
            <li><a href="/games" class="block py-2 text-gray-600 hover:text-gray-900 transition-colors">Games</a></li>
            <li><a href="/codes" class="block py-2 text-gray-600 hover:text-gray-900 transition-colors">Codes</a></li>
            <li><a href="/articles" class="block py-2 text-gray-600 hover:text-gray-900 transition-colors">Articles</a></li>
        </ul>
    </div>
</nav>
