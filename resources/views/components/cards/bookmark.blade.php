
<div>
    <a class="flex flex-col items-center h-full bg-white border border-gray-200 rounded-t-lg shadow md:flex-row md:max-w-xl min-w-full hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <img class="object-cover w-full rounded-t-lg h-60 md:min-h-full lg:h-full md:min-w-32 md:max-w-44 md:rounded-none md:rounded-s-lg" src="https://picsum.photos/300/300?random={{ $random }}" alt="">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <div>
                <h5 class="mb-2 text-xl h-3rem font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>
                {{ $slot }}
            </div>
            <p class="mb-3 h-3rem font-normal text-gray-700 dark:text-gray-400">{{ $description }}</p>
            <div class = "flex flex-wrap w-full gap-3">
               {!! $tags !!}
            </div>
        </div>
    </a>
    <div class="w-full flex">
        <button type="button" class="w-full text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-200  font-medium text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Detail
        </button>
        <button type="button" class="w-full text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-200  font-medium text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            Booking
        </button>
        <input type="hidden" name="event_id" disabled value="{{ $event_id }}">
        <input type="hidden" name="user_id" disabled value="{{ Auth::id() }}">
        <button type="button" id="" class="bookmark text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 font-medium text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
            <svg class="h-8 w-8 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" /></svg>
        </button>
    
    </div>
</div>

