@extends('myAdmin.base')

@section('contents')
    @if (session('success'))
        <div class="mb-4 text-green-700 bg-green-100 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    <div class = "p-10 m-10">
        <h3 class = "text-xl font-bold">Organizer</h3>
        <table id="organizer-table">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            ID
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Name
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Description
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Type
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Instagram Link
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Website Link
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Phone Number
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            Line ID
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
                @foreach ($organizers as $organizer)
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $organizer->id }}</td>
                        <td>{{ $organizer->name }}</td>
                        <td>{{ $organizer->description }}</td>
                        <td>{{ $organizer->type }}</td>
                        <td>{{ $organizer->instagram_link }}</td>
                        <td>{{ $organizer->website_link }}</td>
                        <td>{{ $organizer->phone_number }}</td>
                        <td>{{ $organizer->line_id }}</td>
                        <td>
                            <form method = "post" action = "{{ route('admin.organizer.toggleActivate', $organizer->id) }}">
                                @csrf
                                @method('put')

                                @if($organizer->active == 1)
                                <button type = "submit"
                                    class = "m-2 text-center cursor-pointer px-2 py-1 rounded-full bg-red-100 text-red-500 border-[1px] border-red-500">
                                    Disactivate
                                </button>
                                @else

                                <button type = "submit"
                                    class = "m-2 text-center cursor-pointer px-2 py-1 rounded-full bg-green-100 text-green-500 border-[1px] border-green-500">
                                    Activate
                                </button>

                                @endif
                            </form>
                            
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
@endsection

@section('script')
    <script>
        if (document.getElementById("organizer-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#organizer-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endsection
