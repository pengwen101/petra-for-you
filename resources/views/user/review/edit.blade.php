<x-app-layout>
    <x-slot name="title">
        Edit Review
    </x-slot>

    <div class=" m-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-5">
        <h1 id="user_bookmark"
            class="mb-4 font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookmarks') }}
        </h1>
        <form action="{{ route('user.updateReview', ['id' => $booking->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('POST')
            <h2 id="stars" class="font-light uppercase text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rating') }}
            </h2>
            <div class="flex space-x-4">
                @for ($i = 1; $i <= 5; $i++)
                    <label class="inline-flex items-center">
                        <input type="radio" name="stars" value="{{ $i }}" {{ old('stars', $booking->stars) == $i ? 'checked' : '' }} class="form-radio text-blue-500">
                        <span class="ml-2">{{ $i }}</span>
                    </label>
                @endfor
            </div>
            <div class="space-y-2">
            <h2 id="user_event" class="font-light uppercase text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Review') }}
            </h2>
            <textarea name="review" id="review" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" rows="5" required>{{ old('review', $booking->review) }}</textarea>
            </div>
            
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300 ease-in-out">
            Update Review
            </button>
        </form>
    </div>
</x-app-layout>