<article class="flex bg-white dark:bg-gray-800 transition hover:shadow-xl min-h-full h-[300px]">
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

            <div class = "font-bold text-xs mb-2">Max register date: {{$max_register_date}}</div>
            <div class = "flex flex-wrap w-full gap-2">
                {!! $tags !!}
            </div>
        </div>

        <div class="sm:flex sm:items-end sm:justify-end">
        <a
            href="/user/history/review/{{$booking_id}}"
            class="block bg-yellow-300 dark:bg-gray-800 px-5 py-3 text-center text-xs font-bold uppercase text-gray-900 dark:text-yellow-300 dark:hover:text-yellow-400 transition hover:bg-yellow-400"
        >
            Review
        </a>
        </div>
    </div>
</article>
