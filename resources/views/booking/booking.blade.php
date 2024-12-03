<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-tr from-white to-slate-500 min-h-screen overflow-hidden relative">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
        <!-- Event Title -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800">{{ $event->title }}</h1>
        </div>

        <!-- Event Details -->
        <div class="mt-6">
            <p class="text-gray-700 text-lg"><strong>Organizer:</strong> {{ $event->organizer->name }}</p>
            <p class="text-gray-700 text-lg"><strong>Venue:</strong> {{ $event->venue }}</p>
            <p class="text-gray-700 text-lg"><strong>Date:</strong>
                {{ \Carbon\Carbon::parse($event->start_date)->format('D, M d Y') }} -
                {{ \Carbon\Carbon::parse($event->end_date)->format('D, M d Y') }}
            </p>
            <p class="text-gray-700 text-lg"><strong>Time:</strong>
                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
            </p>
            <p class="text-gray-700 text-lg"><strong>Price:</strong> Rp {{ number_format($event->price, 2) }}</p>
            <p class="text-gray-700 mt-4 text-lg"><strong>About This Event:</strong></p>
            <p class="text-gray-600">{{ $event->description }}</p>
        </div>

        <!-- Event Categories -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800">Categories</h2>
            <div class="flex flex-wrap gap-4 mt-4">
                @foreach ($event->eventCategories->unique('id') as $category)
                    <div
                        class="px-4 py-2 bg-blue-100 text-blue-800 text-sm rounded-2xl shadow-lg border-2 border-blue-300">
                        {{ $category->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Event Tags -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800">Tags</h2>
            <div class="flex flex-wrap gap-4 mt-4">
                @foreach ($event->tags->unique('id') as $tag)
                    <div
                        class="px-4 py-2 bg-green-100 text-green-800 text-sm rounded-2xl shadow-lg border-2 border-green-300">
                        {{ $tag->name }}
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Register Button -->
        <div class="mt-8">
            <a href="#"
                class="block w-full text-center bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition shadow-lg">
                Book Now
            </a>
        </div>
    </div>
</body>

</html>
