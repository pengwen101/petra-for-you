@extends('myAdmin.base')

@section('contents')
    <div class = "p-10 m-10">
        <h3 class = "text-xl font-bold mb-6">Booking</h3>

        <table id="bookings-table">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            ID
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            User Email
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Event Title
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Status
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Review
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Stars
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Payment Photo
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Validate Payment
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Action
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$booking->id}}</td>
                        <td>{{$booking->user->email}}</td>
                        <td>{{$booking->event->title}}</td>
                        <td>{{$booking->status}}</td>
                        <td>{{$booking->review}}</td>
                        <td>{{$booking->stars}}</td>
                        <td>                            
                            <!-- Modal toggle -->
                            <button data-modal-target="booking-{{$booking->id}}" data-modal-toggle="booking-{{$booking->id}}" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                View
                            </button>
                        </td>


                        <td>
                            @if($booking->is_payment_validated)
                                <div class = "text-center cursor-pointer px-2 py-1 rounded-full bg-red-100 text-red-500 border-[1px] border-red-500">
                                    Unvalidate
                                </div>
                            @else
                                <div class = "text-center cursor-pointer px-2 py-1 rounded-full bg-green-100 text-green-500 border-[1px] border-green-500">
                                    Validate
                                </div>
                            @endif
                        </td>

                        <td>                            
                           
                        </td>

                    </tr>
                    <!-- Main modal -->
                    <div id="booking-{{$booking->id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600">
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="booking-{{$booking->id}}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="p-4 md:p-5 space-y-4">
                                    <img src = '{{ asset('storage/'.$booking->payment_url)}}'>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        if (document.getElementById("bookings-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#bookings-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endsection
