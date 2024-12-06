<x-app-layout>
   
    <div class="max-w-md mx-auto my-20 bg-white p-6 rounded-lg shadow-md dark:bg-gray-800">
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 p-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="text-2xl font-bold text-center mb-6 dark:text-white">Booking Confirmation</h1>
        <form id = "booking-form" action="{{ route('booking.store', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h3 class = "text-lg mb-6 font-bold border-b-2">Event Information</h3>
            <!-- Title -->
            <div class="mb-6 grid grid-cols-8">
                <div class="col-span-2 text-sm font-medium text-black dark:text-white">Title</div>
                <div class="col-span-6 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white">
                    {{$event->title}}
                </div>
            </div>

            <!-- Organizer -->
            <div class="mb-6 grid grid-cols-8">
                <div class="col-span-2 text-sm font-medium text-black dark:text-white">Organizer</div>
                <div class="col-span-6 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white">
                    {{$event->organizer->name}}
                </div>
            </div>

            

            <!-- Start Date and Start Time -->
             <div class="mb-6 grid grid-cols-8">
                <div class="col-span-2 text-sm font-medium text-black dark:text-white">Date & Time</div>
                <div class="col-span-6 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white">
                    <div>Start: {{$event->start_date}} | {{$event->start_time}}</div>
                    <div>End: {{$event->end_date}} | {{$event->end_time}}</div>
                </div>
            </div>

            <!-- Place -->
            <div class="mb-6 grid grid-cols-8">
                <div class="col-span-2 text-sm font-medium text-black dark:text-white">Place</div>
                <div class="col-span-6 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white">
                    {{$event->venue}}
                </div>
            </div>



            <h3 class = "text-lg mb-6 font-bold border-b-2">Contact Information</h3>
            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-white">Name <span class = "text-red-500">*</span></label>
                <input type="text" id="name" name="name"
                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white"
                    value = '{{Auth::user()->name}}'
                    disabled>
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Email <span class = "text-red-500">*</span></label>
                <input type="text" id="email" name="email"
                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white"
                    value = '{{Auth::user()->email}}'
                    disabled>
            </div>

            <!-- Line ID -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">Line ID <span class = "text-red-500">*</span></label>
                <input type="text" id="line-id" name="line-id"
                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white"
                    value = '{{Auth::user()->line_id}}'
                    >
                @error('line_id')
                    <div class = "text-sm text-red-500">{{$message}}</div>
                @enderror
            </div>

           

            <!-- No Telp -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-white">No Telp <span class = "text-red-500">*</span></label>
                <input type="text" id="phone-number" name="phone-number"
                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white"
                    value = '{{Auth::user()->phone_number}}'
                    >
                @error('phone_number')
                    <div class = "text-sm text-red-500">{{$message}}</div>
                @enderror
            </div>


            @if($event->price > 0)
                <h3 class = "text-lg mb-6 font-bold border-b-2">Proof of Payment</h3>
                <!-- Proof of Payment -->
                <div class="mb-6">
                    <div class = "text-sm font-medium text-gray-700 dark:text-white">{{ sprintf("Rp %s", number_format($event->price, 2, ',', '.')) }}</div>
                    <input type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*"
                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white"
                        >
                </div>
                @error('proof_of_payment')
                    <div class = "text-sm text-red-500">{{$message}}</div>
                @enderror
            @endif

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                        class="px-4 py-2 text-white bg-emerald-600 border-2 border-emerald-700 rounded-lg hover:bg-emerald-700 focus:outline-none dark:bg-green-800 dark:hover:bg-green-900 dark:border-2 dark:border-green-600">
                    Submit
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
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
                                    window.location.href = "{{ route('user.history') }}";
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
            $.ajax([

            ])
        });
    </script>


    @endpush

</x-app-layout>


