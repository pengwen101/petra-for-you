
    <div class=" min-w-100 bg-white border overflow-hidden border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700">
        @isset($random)
            <a href="#">
                <img class="rounded-t-lg" src="https://picsum.photos/400/150?random={{ $random }}" alt="" />
            </a>
        @endisset
        <div class="p-5 flex flex-col justify-between h-full">
            <div class="mb-2">
                <a href="#">
                    @isset($title)
                        <h5 class="mb-1 h-[3rem] text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>    
                    @endisset
                </a>
            </div>
            <div>
                @isset($description)
                    <p class="mb-2 h-[3rem] text-sm font-normal text-gray-700 dark:text-gray-400">{{ $description }}</p>
                @endisset
                {{ $slot }}
            
            </div>

        </div>
        <div class="">
            <a href="#" class=" inline-flex w-full px-3 py-2 text-sm font-medium text-center text-white bg-blue-700  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Read more
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            
            </a>
        </div>
    </div>

    


