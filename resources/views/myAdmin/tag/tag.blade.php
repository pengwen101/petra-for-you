@extends('myAdmin.base')

@section('contents')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <span class="text-2xl font-bold">Tags</span>
        <button onclick="openModal('addModal')" class="bg-blue-500 text-white px-4 py-2 rounded">Add Tag</button>
    </div>
    <table class="min-w-full bg-white mt-4">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $tag->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $tag->name }}</td>
                    <td class="py-2 px-4 border-b">
                        <button onclick="openModal('editModal', {{ $tag }})" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</button>
                        <form action="{{ route('admin.tag.remove', $tag->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded shadow-lg">
        <h2 class="text-xl font-bold mb-4">Add Tag</h2>
        <form action="{{ route('admin.tag.add') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('addModal')" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded shadow-lg">
        <h2 class="text-xl font-bold mb-4">Edit Tag</h2>
        <form id="editForm" action="admin.tag.update" method="POST"></form>
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="editName" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="editName" class="w-full px-4 py-2 border rounded">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('editModal')" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalId, tag = null) {
        document.getElementById(modalId).classList.remove('hidden');
        if (tag) {
            document.getElementById('editName').value = tag.name;
            document.getElementById('editForm').action = `/tags/${tag.id}`;
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>
@endsection