
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
                                $start_date = Carbon::parse($booking->event->start_date);
                                $year = $start_date->format('Y');
                                $month = $start_date->format('M');
                                $day = $start_date->format('d');
                            @endphp
                            <!-- {{$year}} {{$month}} {{$day}} -->
                            <x-history-card
                            :title="$booking->event->title"
                            :description="$booking->event->description"
                            :stars="$booking->stars"
                            :year="$year"
                            :month="$month"
                            :day="$day"
                            :random="$booking->event->id"
                            ></x-history-card>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <br><br>
        @endforeach
    </div>
</x-app-layout>