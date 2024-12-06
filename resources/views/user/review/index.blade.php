@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('History > Review') }}
        </h2>
    </x-slot>
    <div class="py-12">
        @php
            $start_date = Carbon::parse($event->start_date);
            $year = $start_date->format('Y');
            $month = $start_date->format('M');
            $day = $start_date->format('d');
        @endphp
    <!-- {{$reviews}} -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 id="user_event" class=" font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __("Event Review") }}
            </h1> <br>
            <div class="article flex justify-center bg-white dark:bg-gray-800 transition">
                <div class="rotate-180 p-2 [writing-mode:_vertical-lr]">
                    <time
                    class="flex items-center justify-between gap-4 text-xs font-bold uppercase text-gray-900 dark:text-gray-200"
                    >
                    <span>{{ $year }}</span>
                    <span class="w-px flex-1 bg-gray-900/10"></span>
                    <span>{{ $month }} {{ $day }}</span>
                    </time>
                </div>
                <div class="hidden sm:block sm:basis-56 max-w-96">
                    <img
                    alt=""
                    src="https://picsum.photos/300/300?random={{ $event->id }}" 
                    class="aspect-square h-full w-full object-cover"
                    />
                </div>
                <div class="flex flex-1 flex-col justify-between">
                    <div class="border-s border-gray-900/10 p-4 sm:border-l-transparent sm:p-6">
                        
                    <div class="stars">
                        @for ($i = 0; $i < 5; $i++)
                            @if ($i < $averageStars)
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-yellow-400 inline-block" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-gray-300 inline-block" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <p href="#">
                        <h3 class="font-bold uppercase text-gray-900 dark:text-gray-200">
                        {{ $event->event->title }}
                        </h3>
                    </p>

                    <p class="mt-2 line-clamp-3 text-sm/relaxed text-gray-700 dark:text-gray-300">
                        {{ $event->event->description }}
                    </p>
                    </div>
                </div>
            </div>
            <br> <br>

        <!-- aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa -->
        <h1 id="user_review" class=" font-light uppercase text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("User Review") }}
        </h1> <br>
            <div class="shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-1 lg:gap-8">
                @foreach ($reviews as $review) <!-- unsing card component doesn't work argh -->
                    <div class="h-max rounded-lg bg-gray dark:bg-gray-800">
                        <article class="rounded-xl border-2 bg-white">
                            <div class="flex items-start gap-4 p-4 sm:p-6 lg:p-8 bg-white dark:bg-slate-800">
                                <a href="#" class="block shrink-0">
                                    <img alt="" src="https://picsum.photos/300/300?random={{ $review->user_id }}" class="size-20 rounded-full object-cover" />
                                </a>
                                <div>
                                    <div class="stars">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $review->stars)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-yellow-400 inline-block" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-300 inline-block" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <h3 class="font-medium sm:text-sm text-black dark:text-white">
                                        <p> {{$review->user->name}} </p>
                                    </h3>
                                    <p class="line-clamp-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{$review->review}}
                                    </p>
                                    @if ($review->user_id == Auth::id())
                                        <a href="{{ route('user.editReview', $review->id) }}" class="text-xs opacity-50 text-blue-500 dark:opacity-100">edit</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
