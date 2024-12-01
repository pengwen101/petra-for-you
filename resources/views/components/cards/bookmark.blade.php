
<div>
    <a class="flex flex-col items-center h-full bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl min-w-full hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
        <img class="object-cover w-full rounded-t-lg h-60 md:h-full md:min-w-32 md:max-w-40 md:rounded-none md:rounded-s-lg" src="https://picsum.photos/300/300?random={{ $random }}" alt="">
        <div class="flex flex-col justify-between p-4 leading-normal">
            <div>
                <h5 class="mb-2 text-xl h-3rem font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>
                {{ $slot }}
            </div>
            <p class="mb-3 h-3rem font-normal text-gray-700 dark:text-gray-400">{{ $description }}</p>
        </div>
    </a>
    <div class="w-full grid grid-flow-col">

    </div>
</div>
