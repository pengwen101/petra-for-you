@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <div class = "mx-auto px-20 py-10 h-screen w-full flex justify-center items-center">
        <div class = "flex justify-around w-full">
            <div class = "flex flex-col gap-3">
                <div class = "text-3xl text-dark-blue">Lorem ipsum dolor sit amet.!</div>
                <div class = "cursor-pointer px-4 py-2 w-fit rounded-full bg-summer text-white">Explore events, for you.</div>
            </div>

            <div class = "flex flex-col gap-3">
                <div class = "text-3xl text-dark-blue">Events this month</div>
                <div class="w-75 swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($eventsThisMonth as $event)
                            <div class="swiper-slide">
                                <div class="h-[200px] w-[100px]">
                                    @php
                                        $start_date = Carbon::parse($event->start_date);
                                        $year = $start_date->format('Y');
                                        $month = $start_date->format('M');
                                        $day = $start_date->format('d');
                                    @endphp
                                    <!-- {{$year}} {{$month}} {{$day}} -->
                                    <x-history-card
                                    :title="$event->title"
                                    :description="$event->description"
                                    :year="$year"
                                    :month="$month"
                                    :day="$day"
                                    ></x-history-card>
                                </div>
                            </div>
                        @endforeach
                    </div>
    
                </div>
            </div>
            
          
        </div>



    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <h2 class = "text-xl font-bold">Suggested Events</h2>

            <div id = "suggested-events" class="py-5 flex gap-5 pb-10 overflow-y-auto ">
                
                
            </div>

            <h2 class = "text-xl font-bold mt-5">All Events</h2>

            <div id="event_list" class="py-5 grid grid-cols-1 sm:grid-cols-2 gap-5 pb-10">
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {

        var swiper = new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                loop: true,
                autoplay: {
                    delay: 1000,
                },
                coverflowEffect: {
                    rotate: 10,
                    stretch: 10,
                    depth: 100,
                    modifier: 2.5,
                    slideShadows: true,
                },


            });

        $.ajax({
            url: '/api/events/suggested/{{Auth::id()}}',
            type: 'GET',
            success: function(response) {
                let html = '';
                console.log(response)
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
                        eventTagsHtml += `<div class="px-2 py-1 rounded-full bg-green-100 text-xs text-green-500">${tag.name}</div>`;
                    });
                    html += `
                        <div class=' flex-none w-full sm:w-[49%] shadow rounded-lg '>
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
                $('#suggested-events').html(html);
            },
            error: function(xhr) {
                console.log(xhr);
            },
            complete: function() {
                console.log('complete');
            }
        });

        $.ajax({
            url: '/api/events',
            type: 'GET',
            success: function(response) {
                let eventList = $('#event-list');
                let html = '';
                response.forEach((event, index) => {
                    let truncatedDescription = event.description.substring(0, 60);
                    let start_date = new Date(event.start_date);
                    let end_date = new Date(event.end_date);
                    start_date =
                        `${start_date.getDate()}/${start_date.getMonth()+1}/${start_date.getFullYear()}`;
                    end_date =
                        `${end_date.getDate()}/${end_date.getMonth()+1}/${end_date.getFullYear()}`;

                    let eventTagsHtml = '';
                    event.tags.forEach(tag => {
                        eventTagsHtml += `<div class="px-2 py-1 rounded-full bg-green-100 text-xs text-green-500">${tag.name}</div>`;
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