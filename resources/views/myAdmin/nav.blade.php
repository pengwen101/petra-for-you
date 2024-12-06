<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-center items-center">
        <div class="relative group">
            <button class="text-white font-semibold hover:bg-gray-700 py-2 px-5 rounded">
                Master Data
            </button>
            <div class="absolute hidden group-hover:block bg-white shadow-lg rounded-lg">
                <a href="{{ route('event_categories.index') }}"
                    class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Master Event Category</a>
                <a href="{{ route('organizers.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Master Organizer</a>
                <a href="{{ route('events.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Master Event</a>
            </div>
        </div>
        <a href="{{ url('/') }}" class="text-white font-semibold hover:bg-gray-700 py-2 px-4 rounded">Events</a>
    </div>
</nav>