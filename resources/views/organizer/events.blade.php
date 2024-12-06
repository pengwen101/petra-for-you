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

        <form class="max-w-3xl w-full mx-auto grid grid-cols-2 gap-2" method="POST">
            @csrf
            <div>
                <div class="mb-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                        Title</label>
                    <input type="text" id="title" name="title"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        placeholder="Servant Leadership Training" required />
                </div>
                <div class="mb-5">
                    <label for="venue" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Venue</label>
                    <input type="text" id="venue" name="venue" placeholder="Surabaya"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required />
                </div>
                <div class="mb-5">
                    <label for="max_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Maximum Registration Date</label>
                    <input type="date" id="max_date" name="max_register_date"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        required />
                </div>
                <div class="mb-5 grid grid-cols-2 gap-2">
                    <div>
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start
                            date</label>
                        <input type="date" id="start_date" name="start_date"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required />
                    </div>
                    <div>
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End
                            date</label>
                        <input type="date" id="end_date" name="end_date"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required />
                    </div>
                </div>

            </div>
            <div>


                <input type="hidden" name='organizer_id' value="{{ Auth::guard('organizer')->user()->id }}">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event
                    Description</label>
                
                <textarea id="message" name="description" rows="4"
                    class="mb-5 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Event description here..."></textarea>
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
                        <input type="hidden" name="tags" id="tags"
                            value="{{ isset($event) ? implode(',', json_decode($event->tags)) : '' }}">
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
                        <input type="hidden" name="tags" id="tags"
                            value="{{ isset($event) ? implode(',', json_decode($event->tags)) : '' }}">
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
                                
                                <td>{{ $e->tags }}</td>
                                <td>{{ $e->categories }}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
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
    </script>
@endsection
