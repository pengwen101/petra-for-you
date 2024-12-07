@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <div class = "mt-[-64px] mx-auto px-20 py-10 h-screen w-full flex justify-center items-center">
        <div class = "flex sm:flex-row flex-col gap-10 justify-center items-center w-full h-full">
            <div class = "flex flex-col gap-3 justify-center h-full w-[30%]">
                <div class = "text-3xl text-dark-blue">Welcome back, {{Auth::user()->name}}!</div>
                <div class = "to-below cursor-pointer px-4 py-2 w-fit  bg-summer text-white">Explore events, for you.</div>
            </div>

            <!--Right Swiper-->
            <div class = "flex flex-col gap-5 bg-light-yellow p-10 h-fit items-center justify-center max-w-[70%]">
                <div class = "text-xl font-bold text-midnight">Events this month</div>
                    <div class = "max-w-[500px]">
                        <div class="w-75 swiper mySwiper">
                            <div class="swiper-wrapper">
                                @foreach ($eventsThisMonth as $event)
                                    <div class="swiper-slide">
                                        <div class="h-[400px] rounded-lg bg-gray-200 dark:bg-gray-700">
                                            @php
                                                // Truncate the description
                                                $truncatedDescription = strlen($event->description) > 60 ? substr($event->description, 0, 60) . '...' : $event->description;
                                                
                                                // Format dates using PHP
                                                $start_date = \Carbon\Carbon::parse($event->start_date)->format('d/m/Y');
                                                $end_date = \Carbon\Carbon::parse($event->end_date)->format('d/m/Y');
                                                $max_register_date = \Carbon\Carbon::parse($event->max_register_date)->format('d/m/Y');
                                                
                                                // Generate event tags HTML
                                                $eventTagsHtml = '';
                                                foreach ($event->tags as $tag) {
                                                    $eventTagsHtml .= '<strong class="rounded border border-indigo-500 dark:border-indigo-900 dark:bg-indigo-900 bg-dark-blue px-3 py-1.5 text-[10px] font-medium text-white">' . ($tag->name) . '</strong>';
                                                }
                                            @endphp
                                            <x-cards.bookmark>
                                                <x-slot name="title">{{ $event->title }}</x-slot>
                                                <x-slot name="description">{{ $truncatedDescription }}</x-slot>
                                                <x-slot name="tags">{!! $eventTagsHtml !!}</x-slot>
                                                <x-slot name="random">{{ $event->id }}</x-slot> 
                                                <x-slot name="max_register_date">{{ $max_register_date }}</x-slot>
                                                <x-slot name="start_date">{{ $start_date }}</x-slot>
                                                <x-slot name="end_date">{{ $end_date }}</x-slot>
                                                <x-slot name="event_id">{{ $event->id }}</x-slot> 
                                            </x-cards.bookmark>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-10 min-h-screen" id = "events-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class = "text-xl font-bold dark:text-gray-200">Events for you</h2>

            @foreach($tags as $tag)

                <div class = "text-lg">{{$tag}}</div>

            @endforeach

            <div id = "suggested-events" class="py-5 flex gap-5 pb-10 overflow-y-auto dark:text-gray-200 ">
                @foreach ($suggestedEvents as $event)
                    <div class=' flex-none w-full sm:w-[49%] shadow rounded-lg '>
                        @php
                            // Truncate the description
                            $truncatedDescription = strlen($event->description) > 60 ? substr($event->description, 0, 60) . '...' : $event->description;
                            
                            // Format dates using PHP
                            $start_date = \Carbon\Carbon::parse($event->start_date)->format('d/m/Y');
                            $end_date = \Carbon\Carbon::parse($event->end_date)->format('d/m/Y');
                            $max_register_date = \Carbon\Carbon::parse($event->max_register_date)->format('d/m/Y');
                            
                            // Generate event tags HTML
                            $eventTagsHtml = '';
                            foreach ($event->tags as $tag) {
                                $eventTagsHtml .= '<strong class="rounded border border-indigo-500 dark:border-indigo-900 dark:bg-indigo-900 bg-dark-blue px-3 py-1.5 text-[10px] font-medium text-white">' . e($tag->name) . '</strong>';
                            }
                        @endphp
                        <x-cards.bookmark>
                            <x-slot name="title">{{ $event->title }}</x-slot>
                            <x-slot name="description">{{ $truncatedDescription }}</x-slot>
                            <x-slot name="tags">{!! $eventTagsHtml !!}</x-slot>
                            <x-slot name="random">{{ $event->id }}</x-slot> 
                            <x-slot name="max_register_date">{{ $max_register_date }}</x-slot>
                            <x-slot name="start_date">{{ $start_date }}</x-slot>
                            <x-slot name="end_date">{{ $end_date }}</x-slot>
                            <x-slot name="event_id">{{ $event->id }}</x-slot> 
                        </x-cards.bookmark>
                    </div>
                @endforeach
            </div>

            <h2 class = "text-xl font-bold mt-5 dark:text-gray-200">All Events</h2>

            <div id="event_list" class="py-5 grid grid-cols-1 sm:grid-cols-2 gap-5 pb-10 dark:text-gray-200">
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {

        document.querySelector(".to-below").addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('#events-section').scrollIntoView({
                    behavior: 'smooth'
                });
            });

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
            url: '/api/events/suggested/{{ Auth::id() }}',
            type: 'GET',
            success: function(response) {
                let html = '';
                console.log(response);
                response.forEach((event, index) => {
                    let truncatedDescription = event.description.substring(0, 60);
                    let start_date = new Date(event.start_date);
                    let end_date = new Date(event.end_date);
                    let max_register_date = new Date(event.max_register_date);
                    start_date =
                        `${start_date.getDate()}/${start_date.getMonth()+1}/${start_date.getFullYear()}`;
                    end_date =
                        `${end_date.getDate()}/${end_date.getMonth()+1}/${end_date.getFullYear()}`;

                    max_register_date =
                        `${max_register_date.getDate()}/${max_register_date.getMonth()+1}/${max_register_date.getFullYear()}`;

                    let eventTagsHtml = '';
                    event.tags.forEach(tag => {
                        // eventTagsHtml += `<div class="px-2 py-1 rounded-full bg-green-100 text-xs text-green-500">${tag.name}</div>`;
                        eventTagsHtml += `<strong class="rounded border border-indigo-500 dark:border-indigo-900 dark:bg-indigo-900 bg-dark-blue px-3 py-1.5 text-[10px] font-medium text-white">${tag.name}</strong>`;
                    });
                    html += `
                        <div class=' flex-none w-full sm:w-[49%] shadow rounded-lg '>
                            <x-cards.bookmark>
                                <x-slot name="title">${event.title}</x-slot>
                                <x-slot name="description">${truncatedDescription} ...</x-slot>
                                <x-slot name="tags">${eventTagsHtml}</x-slot>
                                <x-slot name="random">${event.id}</x-slot> 
                                <x-slot name="max_register_date">${max_register_date}</x-slot>
                                <x-slot name="start_date">${start_date}</x-slot>
                                <x-slot name="end_date">${end_date}</x-slot>
                                // <p class="mb-3 font-semibold text-xs text-gray-700/70 dark:text-gray-400">${start_date} - ${end_date}</p>
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
            comp$: function() {
                console.log('comp$');
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
                    let max_register_date = new Date(event.max_register_date);
                    start_date =
                        `${start_date.getDate()}/${start_date.getMonth()+1}/${start_date.getFullYear()}`;
                    end_date =
                        `${end_date.getDate()}/${end_date.getMonth()+1}/${end_date.getFullYear()}`;

                    max_register_date =
                        `${max_register_date.getDate()}/${max_register_date.getMonth()+1}/${max_register_date.getFullYear()}`;


                    let eventTagsHtml = '';
                    event.tags.forEach(tag => {
                        // eventTagsHtml +=
                        //     `<div class="px-2 py-1 rounded-full bg-green-100 text-xs text-green-500">${tag.name}</div>`;
                        eventTagsHtml += `<strong class="rounded border dark:border-indigo-900 dark:bg-indigo-900 border-indigo-500 bg-dark-blue px-3 py-1.5 text-[10px] font-medium text-white">${tag.name}</strong>`;
                    });

                    html += `
                        <div class=' flex-none w-full shadow rounded-lg '>
                            <x-cards.bookmark>
                                <x-slot name="title">${event.title}</x-slot>
                                <x-slot name="description">${truncatedDescription} ...</x-slot>
                                <x-slot name="tags">${eventTagsHtml}</x-slot>
                                <x-slot name="random">${event.id}</x-slot> 
                                <x-slot name="max_register_date">${max_register_date}</x-slot>
                                <x-slot name="start_date">${start_date}</x-slot>
                                <x-slot name="end_date">${end_date}</x-slot>
                                // <p class="mb-3 font-semibold text-xs text-gray-700/70 dark:text-gray-400">${start_date} - ${end_date}</p>
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
            comp$: function() {
                console.log('comp$');
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
                    $bookmarkedEventIds = response.map(event => event.id);
                    console.log(bookmarkedEventIds);
                    $('.bookmark').each(function() {
                        $eventId = $(this).siblings('input[name="event_id"]').val();
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
                comp$: function() {
                    console.log('comp$d');
                }
            });
        });
    });
</script>
