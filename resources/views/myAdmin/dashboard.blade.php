@extends('myAdmin.base')

@section('contents')
<div class="d-flex mt-10 pt-8">
    <div class="text-center items-center justify-center px-6 py-8 max-w-lg mx-auto mt-10">
        <h1 class="text-6xl sm:text-8xl font-bold mt-10 mb-10 transition-colors text-gradient" data-aos="fade-up"
            data-aos-duration="1000">
            Welcome Back Admin
        </h1>
    </div>
</div>
@endsection


@section('styles')
<style>
    @keyframes colorChange {
        0% {
            color: #7B61FF;
        }

        33% {
            color: #FF61AC;
        }

        66% {
            color: #61C4FF;
        }

        100% {
            color: #7B61FF;
        }
    }

    .text-gradient {
        animation: colorChange 3s infinite;
    }
</style>
@endsection