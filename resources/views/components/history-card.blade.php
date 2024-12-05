<article class="flex bg-white dark:bg-gray-800 transition hover:shadow-xl h-[300px] ">
  <div class="rotate-180 p-2 [writing-mode:_vertical-lr]">
    <time
      class="flex items-center justify-between gap-4 text-xs font-bold uppercase text-gray-900 dark:text-gray-200"
    >
      <span>{{ $year }}</span>
      <span class="w-px flex-1 bg-gray-900/10"></span>
      <span>{{ $month }} {{ $day }}</span>
    </time>
  </div>

  <div class="hidden sm:block sm:basis-56">
    <img
      alt=""
      src="https://picsum.photos/300/300?random={{ $random }}" 
      class="aspect-square h-full w-full object-cover"
    />
  </div>

  <div class="flex flex-1 flex-col justify-between">
    <div class="border-s border-gray-900/10 p-4 sm:border-l-transparent sm:p-6">
      <a href="#">
        <h3 class="font-bold uppercase text-gray-900 dark:text-gray-200">
          {{ $title }}
        </h3>
      </a>

      <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-700 dark:text-gray-300">
        {{ $description }}
      </p>
    </div>

    <div class="sm:flex sm:items-end sm:justify-end">
      <a
        href="{{ route('user.review', $random) }}"
        class="block bg-yellow-300 dark:bg-gray-800 px-5 py-3 text-center text-xs font-bold uppercase text-gray-900 dark:text-yellow-300 dark:hover:text-yellow-400 transition hover:bg-yellow-400"
      >
        Review
      </a>
    </div>
  </div>
</article>