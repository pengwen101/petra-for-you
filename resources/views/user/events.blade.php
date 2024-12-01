<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="mb-3 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Events') }}
        </h2> --}}
        {{-- //add navigation link --}}
        <a href="#user_event_list" class="relative inline-flex items-center justify-center p-1 me-1 overflow-hidden text-sm font-medium text-gray-900 group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <span class="relative px-5 py-2 transition-all ease-in duration-75 rounded-md bg-white dark:bg-gray-900 group-hover:bg-opacity-0">
            # My Bookings
            </span>
        </a>
        <a href="#user_bookmark_list" class="relative inline-flex items-center justify-center p-1 me-2 overflow-hidden text-sm font-medium text-gray-900 group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <span class="relative px-5 py-2 transition-all ease-in duration-75 rounded-md bg-white dark:bg-gray-900 group-hover:bg-opacity-0">
            # My Bookmarks
            </span>
        </a>
        {{-- <a href="#user_event_list" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium  text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"># My Bookings</a>
        <a href="#" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"># My Bookmarks</a>
             --}}
    </x-slot>

    <div class=" m-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-5" >
            {{-- // display events in horizontal list --}}
        <h1 class=" font-black uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookings') }}
        </h1>
        <div class="relative ">
            <div id="user_event_list" class="mb-10 flex overflow-x-auto space-x-4 py-5"> 
            </div>
            <!-- Add Navigation -->
            <button type="button" class="prevEvent absolute top-16 left-[-2%] border-2 font-medium rounded-full text-sm p-2.5 m-2 text-center inline-flex items-center text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1L5 5l4 4M5 5h8"/>
                </svg>
                <span class="sr-only">Icon description</span>
            </button>

            <button type="button" class=" nextEvent absolute top-16 right-[-2%] border-2 font-medium rounded-full text-sm p-2.5 m-2 text-center inline-flex items-center text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
                <span class="sr-only">Icon description</span>
            </button>
    
        </div>
        

        <h1 class="mb-3 font-black uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookmarks') }}
        </h1>
        <div id="user_bookmark_list" class="grid grid-cols-2">
        </div> 

    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {
        let user_id = {{ Auth::user()->id }};
        $.ajax({
            url: `{{ route('api.events') }}`,
            type: "GET",
            success: function(response) {
                if (response) {
                    let html = '';
                    response.forEach((event, index) => {
                        let truncatedTitle = event.title.substring(0, 40);
                        let truncatedDescription = event.description.substring(0, 45);
                        html += `
                            <div class='flex-none w-64 shadow rounded-lg '>
                                <x-cards.base>
                                    <x-slot name="title">${truncatedTitle}</x-slot>
                                    <x-slot name="description">${truncatedDescription} ...</x-slot>
                                    <x-slot name="random">${index}</x-slot> 
                                    <p class="mb-3 font-semibold text-sm text-gray-700 dark:text-gray-400">Date: ${event.start_date}</p>
                                </x-cards.base>
                            </div>
                        `;
                    });
                    $('#user_event_list').html(html); 
                    
                }
            },
            error: function(xhr) {
                console.log(xhr);
            },
            complete: function() {
                console.log('completed');
            }
        });
        $('.prevEvent').click(function() {
            $('#user_event_list').animate({ scrollLeft: '-=500'}, 'fast');
        });

        $('.nextEvent').click(function() {
            $('#user_event_list').animate({ scrollLeft: '+=500' }, 'fast');
        });
        $.ajax({
            url: `/api/events`,
            type: "GET",
            success: function(response) {
                if (response) {
                    let html = '';
                    response.forEach((event, index) => {
                        let truncatedDescription = event.description.substring(0, 45);
                        html += `
                            <div class=' flex-none w-full shadow rounded-lg '>
                                <x-cards.horizontal>
                                    <x-slot name="title">${event.title}</x-slot>
                                    <x-slot name="description">${truncatedDescription} ...</x-slot>
                                    <x-slot name="random">${index}</x-slot> 
                                    <p class="mb-3 font-semibold text-sm text-gray-700 dark:text-gray-400">Date: ${event.start_date}</p>
                                </x-cards.horizontal>
                            </div>
                        `;
                    });
                    $('#user_bookmark_list').html(html); 
                    
                    
                }
            },
            error: function(xhr) {
                console.log(xhr);
            },
            complete: function() {
                console.log('completed');
            }
        })


    });


</script>

