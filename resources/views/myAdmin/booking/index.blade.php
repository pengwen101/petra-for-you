@extends('myAdmin.base')

@section('contents')
    @if (session('success'))
        <div class="mb-4 text-green-700 bg-green-100 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    <div class = "p-10 m-10">



        <div class = "flex justify-between mb-6">
            <h3 class = "text-xl font-bold">Booking</h3>
            <a href = "{{ route('admin.booking.create') }}" class = "rounded-full px-4 py-2 bg-green-100 text-green-500">
                Add Booking
            </a>
        </div>




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
                @foreach ($bookings as $booking)
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $booking->id }}</td>
                        <td>{{ $booking->user->email }}</td>
                        <td>{{ $booking->event->title }}</td>
                        <td>{{ $booking->status }}</td>
                        <td>{{ $booking->review }}</td>
                        <td>{{ $booking->stars }}</td>
                        <td>
                            <!-- Modal toggle -->
                            <button data-modal-target="view-photo" data-modal-toggle="view-photo"
                                data-src = "{{ asset('storage/' . $booking->payment_url) }}"
                                class="view-photo block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button">
                                View
                            </button>
                        </td>
                        <td>
                            @if ($booking->is_payment_validated)
                                <form method = "post" action = "{{ route('admin.booking.validate', $booking->id) }}">
                                    @csrf
                                    @method('put')
                                    <button type = "submit"
                                        class = "text-center cursor-pointer px-2 py-1 rounded-full bg-red-100 text-red-500 border-[1px] border-red-500">
                                        Unvalidate
                                    </button>
                                </form>
                            @else
                                <form method = "post" action = "{{ route('admin.booking.validate', $booking->id) }}">
                                    @csrf
                                    @method('put')
                                    <button type = "submit"
                                        class = "text-center cursor-pointer px-2 py-1 rounded-full bg-green-100 text-green-500 border-[1px] border-green-500">
                                        Validate
                                    </button>
                                </form>
                            @endif
                        </td>

                        <td>

                            <a href = "{{route('admin.booking.edit', $booking->id)}}" class = "text-center cursor-pointer px-2 py-1 rounded-full bg-yellow-100 text-yellow-500 border-[1px] border-yellow-500">
                                Edit
                            </a>

                            <form method = "post" action = "{{ route('admin.booking.remove', $booking->id) }}">
                                @csrf
                                @method('delete')
                                <button type = "submit"
                                    class = "m-2 text-center cursor-pointer px-2 py-1 rounded-full bg-red-100 text-red-500 border-[1px] border-red-500">
                                    Delete
                                </button>
                            </form>
                            
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Main modal -->
    <div id="view-photo" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600">
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="view-photo">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <img src = ''>
                </div>
            </div>
        </div>
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

        $(document).ready(function() {
            $(".view-photo").click(function(e) {
                let paymentPictureUrl = $(this).attr('data-src');
                let modal = $("#view-photo");
                modal.find("img").attr("src", paymentPictureUrl);
            });
        });
    </script>
@endsection
