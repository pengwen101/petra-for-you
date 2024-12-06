@extends('myAdmin.base')

@section('contents')

   
<div class="max-w-md mx-auto my-20 bg-white p-6 rounded-lg shadow-md dark:bg-gray-800">
    @if (session('success'))
        <div class="mb-4 text-green-700 bg-green-100 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    <h1 class="text-2xl font-bold text-center mb-6 dark:text-white">{{isset($booking) ? "Edit" : "Add"}} Booking</h1>
    <form id = "booking-form"
        action="{{ isset($booking) ? route('admin.booking.update', $booking->id) : route('admin.booking.add') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($booking))
                        @method('put')
        @else
                        @method('post')
        @endif
        
        <h3 class = "text-lg mb-6 font-bold border-b-2 dark:text-white">Event Information</h3>
        <!-- Event -->
        <div class="mb-6 grid grid-cols-8">
            <label for = "event_id" class="col-span-2 text-sm font-medium text-black dark:text-white">Event</label>
            <select onchange="isPayment(this);" name="event_id" id="event_id"
                class="col-span-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                @if(!isset($booking))
                <option value="" disabled selected>Select an Event</option>

                @endif
                @foreach ($events as $event)
                    <option 
                    value="{{ $event->id }}" {{ isset($booking) && ($event->id == $booking->event->id) ? 'selected' : '' }}
                    data-price="{{$event->price}}">
                        {{ $event->title }} | {{$event->organizer->name}} | {{$event->venue}}
                    </option>
                @endforeach
            </select>
        </div>


        <h3 class = "text-lg mb-6 font-bold border-b-2 dark:text-white">User Information</h3>
        <!-- User -->
        <div class="mb-6 grid grid-cols-8">
            <label for = "user_id" class="col-span-2 text-sm font-medium text-black dark:text-white">User</label>
            <select name="user_id" id="user_id"
                class="col-span-6 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                @if(!isset($booking))
                <option value="" disabled selected>Select a User</option>
                @endif
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ isset($booking) && ($user->id == $booking->user->id) ? 'selected' : '' }}>
                        {{ $user->email }} | {{$user->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div id = "payment-proof-container" class = "{{isset($booking) && $booking->event->price>0 ? '' : 'hidden'}} mb-6">
       

            <h3 class = "text-lg mb-6 font-bold border-b-2 dark:text-white">Proof of Payment</h3>
            <!-- Proof of Payment -->
            <div class="mb-6">
                <div id = "price" class = "text-sm font-medium text-gray-700 dark:text-white"></div>
                <input type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*"
                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white"
                    >
            </div>
            @error('proof_of_payment')
                <div class = "text-sm text-red-500">{{$message}}</div>
            @enderror

            @if(isset($booking))

            <img src = '{{asset('storage/'. $booking->payment_url)}}'>

            @endif
             
        </div>

        

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit"
                class="px-4 py-2 text-white bg-emerald-600 border-2 border-emerald-700 rounded-lg hover:bg-emerald-700 focus:outline-none dark:bg-green-800 dark:hover:bg-green-900 dark:border-2 dark:border-green-600">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection

@section('script')

<script>
    function isPayment(selectElement) {
        // Get the selected option
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;

        console.log(price);

        // Reference to the container for dynamic input
        const container = document.getElementById('payment-proof-container');

        // Check if the price is greater than 0
        if (price > 0) {
            container.classList.remove("hidden");
            console.log("berhasil");
            console.log(document.getElementById("price"));
            document.getElementById("price").innerHTML = `Rp ${price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace('.', ',')}`;
        }else{
            container.classList.add("hidden");
        }
    }

        $(document).ready(function(){
            $("#booking-form").submit(function(e){
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "Make sure your data is correct",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Submit"
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Loading...',
                            text: 'Submitting your answer...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        try{
                            const response = await $.ajax({
                            url: $(this).attr("action"),
                            type: "post",
                            data: new FormData(this),
                            processData: false,
                            contentType: false,
                            });

                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Your answer is stored successfully!',
                                }).then(() => {
                                    console.log("berhasil")
                                    window.location.href = "{{ route('admin.booking') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        }catch(error){
                            if (error.status === 422) {
                                const errors = error.responseJSON.errors;
                                let errorMessage = '';
                                for (const field in errors) {
                                    errorMessage += `${errors[field]}\n`;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    text: errorMessage.trim(),
                                });
                            }else{
                                Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!',

                                });
                            }
                            console.error(error);

                        }


                    }
                });

            });

        });

   

</script>

@endsection
