
<form action="/games" method="GET" class="mb-4 w-full">
    <div class="flex w-full shadow-lg rounded-lg overflow-hidden bg-gray-900 border border-gray-700">
        <span class="flex items-center px-3 text-gray-400">
            <!-- 搜索图标 -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
        </span>
        <input
            type="text"
            name="search"
            placeholder="Search All Games"
            class="flex-1 px-4 py-3 text-base bg-gray-900 text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
        >
        <button type="submit" class="bg-yellow-400 text-gray-900 px-6 py-3 font-semibold hover:bg-yellow-300 transition-all duration-200">
            Go
        </button>
    </div>
</form>
