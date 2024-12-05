<article class="flex bg-white dark:bg-gray-800 transition hover:shadow-xl min-h-full">
    <div class="rotate-180 p-2 [writing-mode:_vertical-lr]">
        <time datetime="2022-10-10"
            class="flex items-center justify-between gap-4 text-xs font-bold uppercase text-gray-900 dark:text-gray-400">
            <span>{{ $start_date }}</span>
            <span class="w-px flex-1 bg-gray-900/10 dark:bg-gray-400/10"></span>
            <span>{{ $end_date }}</span>
        </time>
    </div>

    <div class="hidden sm:block sm:basis-56">
        <img alt=""
            src="https://picsum.photos/400/400?random={{ $random }}"
            class="aspect-square h-full w-full object-cover" />
    </div>

    <div class="flex flex-1 flex-col justify-between">

        <div class="border-s border-gray-900/10 p-4 sm:border-l-transparent sm:p-6">

            <a href="#">
                <h3 class="font-bold uppercase text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
            </a>

            <p class="my-2 line-clamp-3 text-sm/relaxed text-gray-700 dark:text-slate-400">
                {{ $description }}
            </p>
            <div class = "flex flex-wrap w-full gap-2">
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
</article>
