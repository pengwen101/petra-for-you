@extends('organizer.dashboard')

@section('title', 'Organizer Bookings')
@section('cdn')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('content')
    <div class="mb-2 p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        @if (session('success'))
            <div class="mb-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @elseif (session('error'))
            <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-3 gap-4 mb-4">
            @foreach ($events as $e)
                <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                    
                </div>    
            @endforeach
            
        </div>

    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection