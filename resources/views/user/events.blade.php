<x-app-layout>
    <x-slot name="header">
        <a href="#user_event"
            class="relative inline-flex items-center justify-center p-1 me-1 overflow-hidden text-sm font-medium text-gray-900 group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <span
                class="relative px-5 py-2 transition-all ease-in duration-75 rounded-md bg-white dark:bg-gray-900 group-hover:bg-opacity-0">
                # My Bookings
            </span>
        </a>
        <a href="#user_bookmark"
            class="relative inline-flex items-center justify-center p-1 me-2 overflow-hidden text-sm font-medium text-gray-900 group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
            <span
                class="relative px-5 py-2 transition-all ease-in duration-75 rounded-md bg-white dark:bg-gray-900 group-hover:bg-opacity-0">
                # My Bookmarks
            </span>
        </a>
    </x-slot>

    <div class=" m-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-5">
        {{-- // display events in horizontal list --}}
        <h1 id="user_event" class=" font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookings') }}
        </h1>
        <div class="relative ">
            <div id="user_event_list" class="mb-10 flex overflow-x-auto space-x-4 py-5">
            </div>
            <!-- Add Navigation -->
            <button type="button"
                class="bookingButton prevEvent absolute top-16 left-[-2%] border-2 font-medium rounded-full text-sm p-2.5 m-2 text-center inline-flex items-center text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1L5 5l4 4M5 5h8" />
                </svg>
                <span class="sr-only">Icon description</span>
            </button>

            <button type="button"
                class="bookingButton nextEvent absolute top-16 right-[-2%] border-2 font-medium rounded-full text-sm p-2.5 m-2 text-center inline-flex items-center text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
                <span class="sr-only">Icon description</span>
            </button>

        </div>


        <h1 id="user_bookmark"
            class="mb-4 font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookmarks') }}
        </h1>
        <div class='bookmark-alert'></div>
        <div id="user_bookmark_list" class="grid grid-cols-1 sm:grid-cols-2 gap-5 pb-10">
        </div>

    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() {
        let user_id = {{ Auth::user()->id }};
        $.ajax({
            // url: `/api/events/bookings/${user_id}`,
            url: `/api/events`,
            type: "GET",
            success: function(response) {
                if (response) {
                    let html = '';
                    if (response.length == 0) {
                        html = `
                            <div class="flex w-full text-center items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">No Bookings!</span> You have not booked any event yet.
                                </div>
                            </div>
                        `;
                        $('.bookingButton').hide();
                    } else {
                        response.forEach((event, index) => {
                            let truncatedTitle = event.title.substring(0, 40);
                            let truncatedDescription = event.description.substring(0, 50);
                            let start_date = new Date(event.start_date);
                            let end_date = new Date(event.end_date);
                            start_date =
                                `${start_date.getDate()}/${start_date.getMonth()+1}/${start_date.getFullYear()}`;
                            end_date =
                                `${end_date.getDate()}/${end_date.getMonth()+1}/${end_date.getFullYear()}`;
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
                    }
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
            $('#user_event_list').animate({
                scrollLeft: '-=500'
            }, 'fast');
        });
        $('.nextEvent').click(function() {
            $('#user_event_list').animate({
                scrollLeft: '+=500'
            }, 'fast');
        });
        $.ajax({
            url: `/api/events/bookmarks/${user_id}`,
            type: "GET",
            success: function(response) {
                if (response) {
                    let html = '';
                    if (response.length == 0) {
                        html = `
                            <div class="flex w-full text-center items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <div>
                                    <span class="font-medium">No Bookmarks!</span> You have not bookmarked any event yet.
                                </div>
                            </div>
                        `;
                        $('.bookmark-alert').html(html);
                    } else {
                        response.forEach((event, index) => {
                            let truncatedDescription = event.description.substring(0, 100);
                            let start_date = new Date(event.start_date);
                            let end_date = new Date(event.end_date);
                            start_date =
                                `${start_date.getDate()}/${start_date.getMonth()+1}/${start_date.getFullYear()}`;
                            end_date =
                                `${end_date.getDate()}/${end_date.getMonth()+1}/${end_date.getFullYear()}`;
                            let eventTagsHtml = '';
                            event.tags.forEach(tag => {
                                eventTagsHtml +=
                                    `<div class="px-2 py-1 rounded-full bg-green-100 text-xs text-green-500">${tag.name}</div>`;
                            });
                            html += `
                                <div class=' flex-none w-full shadow rounded-lg '>
                                    <x-cards.bookmark>
                                        <x-slot name="title">${event.title}</x-slot>
                                        <x-slot name="description">${truncatedDescription} ...</x-slot>
                                        <x-slot name="tags">${eventTagsHtml}</x-slot>
                                        <x-slot name="random">${event.id}</x-slot> 
                                        <p class="mb-3 font-semibold text-xs text-gray-700/70 dark:text-gray-400">${start_date} - ${end_date}</p>
                                        <x-slot name="event_id">${event.id}</x-slot>
                                    </x-cards.bookmark>
                                </div>
                            `;
                        });

                        $('#user_bookmark_list').html(html);
                    }
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


<script>
    //change button color when bookmarked
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Fetch bookmarked events
        function fetchBookmarkedEvents() {
            $.ajax({
                url: '/api/events/bookmarks/{{ Auth::id() }}',
                type: 'GET',
                success: function(response) {
                    let bookmarkedEventIds = response.map(event => event.id);
                    console.log(bookmarkedEventIds);
                    $('.bookmark').each(function() {
                        let eventId = $(this).siblings('input[name="event_id"]').val();
                        if (bookmarkedEventIds.includes(parseInt(eventId))) {
                            $(this).find('svg').attr('fill', 'red');
                        }
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
        fetchBookmarkedEvents();

        $(document).on('click', '.bookmark', function(e) {
            e.preventDefault();
            if ($(this).find('svg').attr('fill') == 'red') {
                $(this).find('svg').attr('fill', 'None');
            } else {
                $(this).find('svg').attr('fill', 'red');
            }
            // Submit the form after changing the color
            $.post({
                url: '/api/events/bookmarks',
                data: {
                    event_id: $(this).siblings('input[name="event_id"]').val(),
                    user_id: $(this).siblings('input[name="user_id"]').val()
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr);
                },
                complete: function() {
                    console.log('completed');
                }
            });
        });
    });
</script>
