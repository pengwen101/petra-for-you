
@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('History') }}
        </h2>
    </x-slot>
    <div class="py-12">
        @foreach ($bookings as $title => $bookinges)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 id="user_event" class=" font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($title) }}
        </h1>
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
            {{ $bookinges->links() }}
            <br>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
                    @foreach ($bookinges as $booking)
                        <div class="h-max rounded-lg bg-gray dark:bg-gray-800">
                            @php
                                $truncatedDescription = strlen($booking->event->description) > 60 ? substr($booking->event->description, 0, 60) . '...' : $booking->event->description;
                                                
                                // Format dates using PHP
                                $start_date = \Carbon\Carbon::parse($booking->event->start_date)->format('d/m/Y');
                                $end_date = \Carbon\Carbon::parse($booking->event->end_date)->format('d/m/Y');
                                $max_register_date = \Carbon\Carbon::parse($booking->event->max_register_date)->format('d/m/Y');
                                
                                // Generate event tags HTML
                                $eventTagsHtml = '';
                                foreach ($booking->event->tags as $tag) {
                                    $eventTagsHtml .= '<strong class="rounded border border-indigo-500 dark:border-indigo-900 dark:bg-indigo-900 bg-dark-blue px-3 py-1.5 text-[10px] font-medium text-white">' . ($tag->name) . '</strong>';
                                }
                            @endphp
                            
                            <x-cards.bookmark-review>
                                <x-slot name="title">{{ $booking->event->title }}</x-slot>
                                <x-slot name="description">{{ $truncatedDescription }}</x-slot>
                                <x-slot name="tags">{!! $booking->eventTagsHtml !!}</x-slot>
                                <x-slot name="random">{{ $booking->event->id }}</x-slot> 
                                <x-slot name="max_register_date">{{ $max_register_date }}</x-slot>
                                <x-slot name="start_date">{{ $start_date }}</x-slot>
                                <x-slot name="end_date">{{ $end_date }}</x-slot>
                                <x-slot name="event_id">{{ $booking->event->id }}</x-slot> 
                            </x-cards.bookmark-review>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <br><br>
        @endforeach
    </div>
</x-app-layout>