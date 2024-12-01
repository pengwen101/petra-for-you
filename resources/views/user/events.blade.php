<x-app-layout>
    <x-slot name="header">
        <a href="#user_event" class="relative inline-flex items-center justify-center p-1 me-1 overflow-hidden text-sm font-medium text-gray-900 group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <span class="relative px-5 py-2 transition-all ease-in duration-75 rounded-md bg-white dark:bg-gray-900 group-hover:bg-opacity-0">
            # My Bookings
            </span>
        </a>
        <a href="#user_bookmark" class="relative inline-flex items-center justify-center p-1 me-2 overflow-hidden text-sm font-medium text-gray-900 group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <span class="relative px-5 py-2 transition-all ease-in duration-75 rounded-md bg-white dark:bg-gray-900 group-hover:bg-opacity-0">
            # My Bookmarks
            </span>
        </a>
    </x-slot>

    <div class=" m-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-5" >
            {{-- // display events in horizontal list --}}
        <h1 id="user_event" class=" font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
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
        

        <h1 id="user_bookmark" class="mb-3 font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookmarks') }}
        </h1>
        <div id="user_bookmark_list" class="grid grid-cols-1 sm:grid-cols-2 gap-5 pb-10">
        </div> 

    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {
        let user_id = {{ Auth::user()->id }};
        $.ajax({
            url: `/api/events`,
            type: "GET",
            success: function(response) {
                if (response) {
                    let html = '';
                    response.forEach((event, index) => {
                        let truncatedTitle = event.title.substring(0, 40);
                        let truncatedDescription = event.description.substring(0, 50);
                        let start_date = new Date(event.start_date);
                        let end_date = new Date(event.end_date);
                        start_date = `${start_date.getDate()}/${start_date.getMonth()+1}/${start_date.getFullYear()}`;
                        end_date = `${end_date.getDate()}/${end_date.getMonth()+1}/${end_date.getFullYear()}`;
                        html += `
                            <div class='flex-none w-64 shadow-lg rounded-lg '>
                                <x-cards.base>
                                    <x-slot name="title">${truncatedTitle}</x-slot>
                                    <x-slot name="description">${truncatedDescription} ...</x-slot>
                                    <x-slot name="random">${index}</x-slot> 
                                    <p class="mb-3 font-semibold text-xs text-gray-700/70 dark:text-gray-400">${start_date} - ${end_date}</p>
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
                        let truncatedDescription = event.description.substring(0, 100);
                        let start_date = new Date(event.start_date);
                        let end_date = new Date(event.end_date);
                        start_date = `${start_date.getDate()}/${start_date.getMonth()+1}/${start_date.getFullYear()}`;
                        end_date = `${end_date.getDate()}/${end_date.getMonth()+1}/${end_date.getFullYear()}`;
                        html += `
                            <div class=' flex-none w-full shadow rounded-lg '>
                                <x-cards.bookmark>
                                    <x-slot name="title">${event.title}</x-slot>
                                    <x-slot name="description">${truncatedDescription} ...</x-slot>
                                    <x-slot name="random">${index}</x-slot> 
                                    <p class="mb-3 font-semibold text-xs text-gray-700/70 dark:text-gray-400">${start_date} - ${end_date}</p>
                                </x-cards.bookmark>
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

