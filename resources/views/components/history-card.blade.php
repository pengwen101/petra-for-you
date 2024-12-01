<article class="flex bg-white transition hover:shadow-xl h-[300px]">
  <div class="rotate-180 p-2 [writing-mode:_vertical-lr]">
    <time
      class="flex items-center justify-between gap-4 text-xs font-bold uppercase text-gray-900"
    >
      <span>{{ $year }}</span>
      <span class="w-px flex-1 bg-gray-900/10"></span>
      <span>{{ $month }} {{ $day }}</span>
    </time>
  </div>

  <div class="hidden sm:block sm:basis-56">
    <img
      alt=""
      src="{{ asset('images/assump.jpg') }}"
      class="aspect-square h-full w-full object-cover"
    />
  </div>

  <div class="flex flex-1 flex-col justify-between">
    <div class="border-s border-gray-900/10 p-4 sm:border-l-transparent sm:p-6">
      <a href="#">
        <h3 class="font-bold uppercase text-gray-900">
          {{ $title }}
        </h3>
      </a>

      <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-700">
        {{ $description }}
      </p>
    </div>

    <div class="sm:flex sm:items-end sm:justify-end">
      <a
        href="#"
        class="block bg-yellow-300 px-5 py-3 text-center text-xs font-bold uppercase text-gray-900 transition hover:bg-yellow-400"
      >
        Review
      </a>
    </div>
  </div>
</article>