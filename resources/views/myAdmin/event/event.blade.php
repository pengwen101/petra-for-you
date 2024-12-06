@extends('myAdmin.base')

@section('contents')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <span class="text-2xl font-bold">Event</span>
    </div>
    <table class="min-w-full bg-white mt-4">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Title</th>
                <th class="py-2 px-4 border-b">Venue</th>
                <th class="py-2 px-4 border-b">Start & End</th>
                <th class="py-2 px-4 border-b">Price</th>
                <th class="py-2 px-4 border-b">Shown</th>
                <th class="py-2 px-4 border-b">Tags</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $event->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $event->title }}</td>
                    <td class="py-2 px-4 border-b">{{ $event->venue }}</td>
                    <td class="py-2 px-4 border-b">
                        <div>{{ date('d F Y H:i', strtotime($event->start_date . ' ' . $event->start_time)) }}</div>
                        <div>{{ date('d F Y H:i', strtotime($event->end_date . ' ' . $event->end_time)) }}</div>
                    </td>
                    <td class="py-2 px-4 border-b">{{ $event->price }}</td>
                    <td class="py-2 px-4 border-b">{{ $event->is_shown ? 'Yes' : 'No' }}</td>
                    <td class="py-2 px-4 border-b">
                        @if($event->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($event->tags as $tag)
                                                        @php
                                                            $hash = crc32(strtolower($tag->name));
                                                            $color = sprintf('#%06X', $hash & 0xFFFFFF);
                                                        @endphp
                                                        <span class="px-2 py-1 rounded text-white"
                                                            style="background-color: {{ $color }}">{{ ucwords(strtolower($tag->name)) }}</span>
                                        @endforeach
                                    </div>
                        @else
                            <span>No Tags</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        <form action="{{ route('admin.event.remove', $event->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Hide</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection