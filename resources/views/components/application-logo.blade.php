<!-- <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}> -->
    <!-- <image href="{{ asset('images/pfy6.svg') }}" x="10" y="10" height="80" width="80"/> -->
    <!-- <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" /> -->
<!-- </svg> -->
@php
    $image = asset('images/pfy6.png');
    if (config('app.theme') === 'dark') {
        $image = asset('images/pfy7.png');
    }
@endphp

<svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <image href="{{ $image }}" x="10" y="10" height="80" width="80"/>
</svg>