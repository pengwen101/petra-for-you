<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white shadow-md p-6 my-20 dark:bg-gray-800">
        <!-- Event Title -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">{{ $event->title }}</h1>
        </div>

        <!-- Event Details -->
        <div class="mt-6">
            <p class="text-gray-700 text-lg dark:text-white"><strong>Organizer:</strong> {{ $event->organizer->name }}</p>
            <p class="text-gray-700 text-lg dark:text-white"><strong>Venue:</strong> {{ $event->venue }}</p>
            <p class="text-gray-700 text-lg dark:text-white"><strong>Date:</strong>
                {{ \Carbon\Carbon::parse($event->start_date)->format('D, M d Y') }} -
                {{ \Carbon\Carbon::parse($event->end_date)->format('D, M d Y') }}
            </p>
            <p class="text-gray-700 text-lg dark:text-white"><strong>Time:</strong>
                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
            </p>
            <p class="text-gray-700 text-lg dark:text-white"><strong>Price:</strong> Rp {{ number_format($event->price, 2) }}</p>
            <p class="text-gray-700 mt-4 text-lg dark:text-white"><strong>About This Event:</strong></p>
            <p class="text-gray-600 dark:text-white">{{ $event->description }}</p>
        </div>

        <!-- Event Categories -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Categories</h2>
            <div class="flex flex-wrap gap-4 mt-4">
                @foreach ($event->eventCategories->unique('id') as $category)
                    <div
                        class="px-4 py-2 bg-blue-100 text-blue-800 text-sm rounded-2xl shadow-lg border-2 border-blue-300 dark:border-blue-400 dark:bg-blue-900 dark:text-blue-200">
                        {{ $category->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Event Tags -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Tags</h2>
            <div class="flex flex-wrap gap-4 mt-4">
                @foreach ($event->tags->unique('id') as $tag)
                    <div
                        class="px-4 py-2 bg-green-100 text-green-800 text-sm rounded-2xl shadow-lg border-2 border-green-300 dark:text-green-200 dark:border-green-400 dark:bg-green-900">
                        {{ $tag->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Register Button -->
        <div class="mt-8">
            <a href="/booking/{{ $event->id }}"
                class="block w-full text-center bg-emerald-600 border-2 border-emerald-700 text-white py-3 rounded-lg hover:bg-emerald-700 transition shadow-lg dark:bg-green-800 dark:hover:bg-green-900 dark:border-green-600 dark:border-2">
                Book Now
            </a>
        </div>
    </div>
</x-app-layout>
