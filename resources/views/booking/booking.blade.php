<x-app-layout>
    <div class="max-w-md mx-auto mt-20 bg-white p-6 rounded-lg shadow-md dark:bg-gray-800">
        <h1 class="text-2xl font-bold text-center mb-6 dark:text-white">Upload Proof of Payment</h1>
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 p-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('booking.store', $event_id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Proof of Payment -->
            <div class="mb-6">
                <label for="proof_of_payment" class="block text-sm font-medium text-gray-700 dark:text-white">Proof of Payment</label>
                <input type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*"
                       class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:text-white"
                       required>
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
</x-app-layout>
