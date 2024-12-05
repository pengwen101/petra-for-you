<article class="overflow-hidden rounded-lg shadow dark:bg-slate-800 transition hover:scale-105 hover:shadow-2xl min-h-full flex flex-col">
    <img alt="" src="https://picsum.photos/400/400?random={{ $random }}" class="h-56 w-full object-cover" />

    <div class="bg-white p-4 sm:p-6 flex-grow flex flex-col dark:bg-slate-800">
        <time datetime="2022-10-10" class="block text-xs text-gray-500"> {{ $slot }} </time>

        <a href="#">
            @isset($title)
                <h3 class="mt-0.5 text-lg text-gray-900 dark:text-white">{{ $title }}</h3>
            @endisset
        </a>
        @isset($description)
            <p class="mt-2 line-clamp-3 dark:text-slate-400 text-sm/relaxed text-gray-500">
                {{ $description }}
            </p>
        @endisset

        <a href="#" class="group inline-flex items-center gap-1 text-sm font-medium text-blue-600 mt-auto">
            Find out more
      
            <span aria-hidden="true" class="block transition-all group-hover:ms-0.5 rtl:rotate-180">
              &rarr;
            </span>
        </a>
    </div>
</article>
