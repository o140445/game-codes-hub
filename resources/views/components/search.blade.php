
<form method="GET" action="{{ route('games.index') }}" class="space-y-6">
    <!-- Search Bar -->
    <div class="flex gap-4">
        <div class="flex-1">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search games..."
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white text-gray-800 placeholder-gray-500 focus:border-gray-400 focus:bg-white focus:outline-none transition">
        </div>
        <button type="submit"
                class="px-6 py-3 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors">
            Search
        </button>
    </div>
</form>
