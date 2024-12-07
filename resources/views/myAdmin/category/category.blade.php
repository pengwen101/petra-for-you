@extends('myAdmin.base')

@section('contents')
@if (session('success'))
    <div class="mb-4 text-green-700 bg-green-100 p-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif
<div class="p-10 m-10">
    <div class="flex justify-between mb-6">
        <h3 class="text-xl font-bold">Category</h3>
        <button onclick="openModal('addModal')" class="rounded-full px-4 py-2 bg-green-100 text-green-500">
            Add Category
        </button>
    </div>

    <table id="categories-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->notes }}</td>
                    <td>
                        <button onclick="openModal('editModal', {{ $category }})"
                            class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</button>
                        <form action="{{ route('admin.category.remove', $category->id) }}" method="POST"
                            class="inline-block" id="delete-form-{{ $category->id }}">
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
        <h2 class="text-xl font-bold mb-4">Add Category</h2>
        <form action="{{ route('admin.category.add') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="notes" class="block text-gray-700">Notes</label>
                <input type="textarea" name="notes" id="notes" class="w-full px-4 py-2 border rounded">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('addModal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden"
    aria-hidden="true" role="dialog" aria-modal="true">
    <div class="bg-white p-6 rounded shadow-lg">
        <h2 class="text-xl font-bold mb-4">Edit Category</h2>
        <form id="editForm" action="{{ route('admin.category.update', ['category' => $category->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="editName" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="editName" class="w-full px-4 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="editNotes" class="block text-gray-700">Notes</label>
                <input type="textarea" name="notes" id="editNotes" class="w-full px-4 py-2 border rounded">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('editModal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalId, category = null) {
        document.getElementById(modalId).classList.remove('hidden');
        if (category) {
            document.getElementById('editName').value = category.name;
            document.getElementById('editNotes').value = category.notes;
            document.getElementById('editForm').action = `/admin/category/${category.id}`;
        }
        document.getElementById(modalId).setAttribute('aria-hidden', 'false');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.getElementById(modalId).setAttribute('aria-hidden', 'true');
    }

    window.onclick = function (event) {
        var modals = document.querySelectorAll('.fixed');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    }

    document.onkeydown = function (event) {
        if (event.key === 'Escape') {
            var modals = document.querySelectorAll('.fixed');
            modals.forEach(modal => {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById("categories-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#categories-table", {
                searchable: true,
                sortable: true
            });
        }
    });
</script>
@endsection