
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 id="user_event" class=" font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Finished Events') }}
        </h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <!-- {{$bookings}} -->
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
                        @foreach ($bookings as $booking)
                            <div class="h-max rounded-lg bg-gray-200 dark:bg-gray-700">
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
                                ></x-history-card>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>