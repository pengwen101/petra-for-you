<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Welcome') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <div id="event_list" class="py-5 grid grid-cols-1 sm:grid-cols-2 gap-5 pb-10">
            </div>

        </div>
    </div>

    <div class="container" id="eventList">

    </div>
</x-app-layout>

<script>
    $('document').ready(function() {
        $.ajax({
            url: '/api/events',
            type: 'GET',
            success: function(response) {
                let eventList = $('#event-list');
                let html = '';
                response.forEach((event, index) => {
                    let truncatedDescription = event.description.substring(0, 100);
                    let start_date = new Date(event.start_date);
                    let end_date = new Date(event.end_date);
                    start_date =
                        `${start_date.getDate()}/${start_date.getMonth()+1}/${start_date.getFullYear()}`;
                    end_date =
                        `${end_date.getDate()}/${end_date.getMonth()+1}/${end_date.getFullYear()}`;
                    html += `
                        <div class=' flex-none w-full shadow rounded-lg '>
                            <x-cards.bookmark>
                                <x-slot name="title">${event.title}</x-slot>
                                <x-slot name="description">${truncatedDescription} ...</x-slot>
                                <x-slot name="random">${event.id}</x-slot> 
                                <p class="mb-3 font-semibold text-xs text-gray-700/70 dark:text-gray-400">${start_date} - ${end_date}</p>
                                <x-slot name="event_id">${event.id}</x-slot> 
                            </x-cards.bookmark>
                        </div>
                    `;
                });
                $('#event_list').html(html);
            },
            error: function(xhr) {
                console.log(xhr);
            },
            complete: function() {
                console.log('complete');
            }
        });
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