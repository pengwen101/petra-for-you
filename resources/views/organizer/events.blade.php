@extends('organizer.dashboard')

@section('title', 'Organizer Events')
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
        <form action="{{ route('organizer.addEvent') }}" class="max-w-3xl w-full mx-auto grid grid-cols-2 gap-2"
            method="POST">
            @csrf
            <div>
                <div class="mb-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                        Title</label>
                    <input type="text" id="title" name="title"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        placeholder="Servant Leadership Training" required />
                    @error('title')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="venue" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Venue</label>
                    <input type="text" id="venue" name="venue" placeholder="Surabaya"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required />
                    @error('venue')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="max_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Maximum Registration Date</label>
                    <input type="date" id="max_date" name="max_register_date"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required />
                    @error('max_register_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-5 grid grid-cols-2 gap-2">
                    <div>
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start
                            date</label>
                        <input type="datetime-local" id="start_date" name="start_datetime"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required />
                        @error('start_date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End
                            date</label>
                        <input type="datetime-local" id="end_date" name="end_datetime"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required />
                        @error('end_date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
            <div>
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Price
                </label>
                <input type="number" id="price" name="price"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    required />
                @error('price')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror


                <input type="hidden" name='organizer_id' value="{{ Auth::guard('organizer')->user()->id }}">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                    Description</label>

                <textarea id="message" name="description" rows="4"
                    class="mb-5 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Event description here..."></textarea>
                @error('description')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror

                <div class="grid grid-cols-2 gap-2">
                    <div class="mb-5">
                        <label for="tags"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tags</label>
                        <select
                            class="tag shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            id="tags" name="tag_id[]" multiple="multiple">
                            @if (count($tags) > 0)
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('tag_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="categories"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catgeories</label>
                        <select
                            class="category shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            id="categories" name="event_category_id[]" multiple="multiple">
                            @if (count($categories) > 0)
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('event_category_id')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>


            <button type="submit"
                class="text-white bg-black hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit
            </button>
        </form>

    </div>


    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class=" mb-4 p-4 overflow-auto rounded bg-gray-50 dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
            </p>
            <table id="search-table">
                <thead>
                    <tr>
                        <th>
                            <span class="flex items-center">
                                Title
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Venue
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Description
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Max Register Date
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Start Date
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                End Date
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Tags
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Categories
                            </span>
                        </th>
                        <th>
                            <span class="flex items-center">
                                Actions
                            </span>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @if (count($events) > 0)
                        @foreach ($events as $e)
                            <tr>
                                <td>{{ $e->title }}</td>
                                <td>{{ $e->venue }}</td>
                                <td>{{ $e->description }}</td>
                                <td>{{ $e->max_register_date }}</td>
                                <td>{{ $e->start_date }}</td>
                                <td>{{ $e->end_date }}</td>

                                <td>
                                    @foreach ($e->tags as $tag)
                                        <span
                                            class="inline-block m-1 bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded">{{ $tag->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($e->eventCategories as $category)
                                        <span
                                            class="inline-block m-1 bg-blue-200 text-blue-800 text-xs px-2 py-1 rounded">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('organizer.toggleEvent', ['event' => $e->id]) }}"
                                        method="POST">
                                        @csrf
                                        <label class="inline-flex items-center mb-5 cursor-pointer">
                                            <input type="checkbox" name="is_shown" value="1" class="sr-only peer"
                                                {{ $e->is_shown ? 'checked' : '' }} onchange="this.form.submit()">
                                            <div
                                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                            </div>
                                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Is
                                                Shown</span>
                                        </label>
                                    </form>
                                    <form action="{{ route('organizer.deleteEvent') }}" method="POST" class="mb-2">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $e->id }}">
                                        <button type="submit"
                                            class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete
                                        </button>
                                    </form>
                                    {{-- update form  --}}
                                    <input type="hidden" value="{{ $e->id }}">
                                    <button data-modal-target="default-modal" data-modal-toggle="default-modal"
                                        class="updateModal mb-2 block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        Update
                                    </button>
                                    <button data-modal-target="booking-modal" data-modal-toggle="booking-modal"
                                        class="bookingModal block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        type="button">
                                        Booking
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    <!-- Update modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Update Event
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
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
                    <form action="{{ route('organizer.updateEvent') }}"
                        class="max-w-3xl w-full mx-auto grid grid-cols-2 gap-2" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" class="" id="update_id" name="id">
                        <div>
                            <div class="mb-5">
                                <label for="update_title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                                    Title</label>
                                <input type="text" id="update_title" name="title"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                    placeholder="Servant Leadership Training" required />
                                @error('title')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="update_venue"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Venue</label>
                                <input type="text" id="update_venue" name="venue" placeholder="Surabaya"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                    required />
                                @error('venue')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="update_max_date"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Maximum Registration Date</label>
                                <input type="date" id="update_max_date" name="max_register_date"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                    required />
                                @error('max_register_date')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-5 grid grid-cols-2 gap-2">
                                <div>
                                    <label for="update_start_date"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start
                                        date</label>
                                    <input type="datetime-local" id="update_start_date" name="start_datetime"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                        required />
                                    @error('start_date')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="update_end_date"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End
                                        date</label>
                                    <input type="datetime-local" id="update_end_date" name="end_datetime"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                        required />
                                    @error('end_date')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div>
                            <label for="update_price"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Price
                            </label>
                            <input type="number" id="update_price" name="price"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                required />
                            @error('price')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror

                            <input type="hidden" name='organizer_id'
                                value="{{ Auth::guard('organizer')->user()->id }}">
                            <label for="update_description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                                Description</label>

                            <textarea id="update_description" name="description" rows="4"
                                class="mb-5 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Event description here..."></textarea>
                            @error('description')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror

                            <div class="grid grid-cols-2 gap-2">
                                <div class="mb-5">
                                    <label for="update_tag"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tags</label>
                                    <select
                                        class="update_tag shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                        id="update_tag" name="tag_id[]" multiple="multiple">
                                        @if (count($tags) > 0)
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('tag_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-5">
                                    <label for="update_category"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catgeories</label>
                                    <select
                                        class="update_category shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                        id="update_category" name="event_category_id[]" multiple="multiple">
                                        @if (count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('event_category_id')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        <button type="submit"
                            class="text-white bg-black hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit
                        </button>
                    </form>

                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    {{-- <button data-modal-hide="default-modal" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I
                        accept</button> --}}
                    <button data-modal-hide="default-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Booking modal -->
    <div id="booking-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Booking Table
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="booking-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4 overflow-auto">

                    <table id="booking-table">
                        <thead>
                            <tr>
                                <th>
                                    <span class="flex items-center">
                                        Name
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Status
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Proof of Payment
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Validation
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="" id="booking-body">
                        </tbody>
                    </table>


                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    {{-- <button data-modal-hide="booking-modal" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I
                        accept</button> --}}
                    <button data-modal-hide="booking-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                $('.tag').select2({
                    placeholder: 'Select tags',

                });
                $('.category').select2({
                    placeholder: 'Select categories',

                });
                $('.update_tag').select2({
                    placeholder: 'Select tags',
                    allowClear: true,

                });
                $('.update_category').select2({
                    placeholder: 'Select categories',
                    allowClear: true,
                });
            });

            // update is_shown when button is toggled
            $('.peer').change(function() {
                $(this).closest('form').submit();
            });

        });
    </script>

    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }

        if (document.getElementById("booking-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#booking-table", {
                searchable: true,
                sortable: false
            });
        }

        function formatDateTime(date, time) {
            // Ensure the time is in the format HH:MM:SS
            const timeParts = time.split(':');
            const formattedTime = `${timeParts[0]}:${timeParts[1]}`;

            // Combine date and time in the format YYYY-MM-DDTHH:MM
            return `${date}T${formattedTime}`;
        }

        //when modal is toggled fill the form with the data using ajax
        document.querySelectorAll('.updateModal').forEach(item => {
            item.addEventListener('click', function() {
                const modal = document.getElementById('default-modal');
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                const id = $(this).siblings('input').val();
                $.ajax({
                    url: '/api/events',
                    data: {
                        id: id
                    },
                    type: 'GET',
                    success: function(response) {
                        if (response) {


                            const dataset = Array.isArray(response) ? response : [response];
                            dataset.forEach(data => {
                                if (data.id == id) {
                                    document.getElementById('update_id').value = id;
                                    document.getElementById('update_title').value = data
                                        .title;
                                    document.getElementById('update_venue').value = data
                                        .venue;
                                    document.getElementById('update_max_date').value =
                                        data.max_register_date;
                                    document.getElementById('update_start_date').value =
                                        formatDateTime(data.start_date, data
                                            .start_time);
                                    document.getElementById('update_end_date').value =
                                        formatDateTime(data.end_date, data.end_time);
                                    document.getElementById('update_price').value = data
                                        .price;
                                    document.getElementById('update_description')
                                        .value = data.description;
                                    const tagIds = data.tags.map(tag => tag.id);
                                    const categoryIds = data.event_categories.map(
                                        category => category.id);
                                    $('.update_tag').val(tagIds).trigger('change');
                                    $('.update_category').val(categoryIds).trigger(
                                        'change');
                                }
                            })

                        }
                    }
                });
            });
        });

        document.querySelectorAll('.bookingModal').forEach(item => {
            item.addEventListener('click', function() {
                const modal = document.getElementById('booking-modal');
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                const id = $(this).siblings('input').val();
                console.log(id);
                $.ajax({
                    url: `/api/events/book-event/${id}`,
                    // data: {
                    //     id: id
                    // },
                    type: 'GET',
                    success: function(response) {

                        console.log(response);
                        let html = '';
                        if (response) {
                            console.log(response.length)

                            if (response.length == 0) {
                                html += `<tr>
                                    <td colspan="4" class="text-center">No bookings yet</td>
                                    
                            
                                </tr>`;
                            } else {
                                response.forEach(data => {
                                    html += `<tr>
                                    <td>${data.user.name}</td>
                                    <td>${data.status}</td>
                                    <td>${data.payment_url}</td>
                                    <td>
                                    <form action="/organizer/bookings/toggle/${data.id}"
                                        method="GET">
                                        @csrf
                                        <label class="inline-flex items-center mb-5 cursor-pointer">
                                            <input type="checkbox" name="is_payment_validated" value="1" class="sr-only peer"
                                                ${data.is_payment_validated ? 'checked' : ''} onchange="this.form.submit()">
                                            <div
                                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                            </div>
                                        </label>
                                    </form>
                                    </td>
                                </tr>`;
                                });
                            }
                            console.log(html);
                            $('#booking-table tbody').html(html);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching bookings:', error);
                    }
                });
            });
        });
    </script>
@endsection
