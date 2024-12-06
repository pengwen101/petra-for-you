@extends('myAdmin.base')

@section('contents')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <span class="text-2xl font-bold">Tags</span>
        <button onclick="openModal('addModal')" class="bg-blue-500 text-white px-4 py-2 rounded">Add Tag</button>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">ID</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">{{ $tag->id }}</th>
                        <td class="px-6 py-2">{{ $tag->name }}</td>
                        <td class="px-6 py-2 bg-gray-50 dark:bg-gray-800">
                            <button onclick="openModal('editModal', {{ $tag }})" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</button>
                            <form action="{{ route('admin.tag.remove', $tag->id) }}" method="POST" class="inline-block" id="delete-form-{{ $tag->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="confirmDelete({{ $tag->id }})" 
                                        class="bg-red-500 text-white px-4 py-2 rounded">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
        <form id="editForm" action="" method="POST">
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
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');

        if (tag) {
            // Populate the edit form with tag data
            const editNameInput = document.getElementById('editName');
            editNameInput.value = tag.name;

            // Update the action URL of the edit form dynamically
            const editForm = document.getElementById('editForm'); //// stil not workingg
            editForm.action = '/admin/tag/${tag.id}';
        }
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function confirmDelete(tagId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${tagId}`).submit();
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
                });
            }
        });
    }
</script>
@endsection