@extends('myAdmin.base')

@section('contents')
    @if (session('success'))
        <div class="mb-4 text-green-700 bg-green-100 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    <div class="p-10 m-10">
        <div class="flex justify-between mb-6">
            <h3 class="text-xl font-bold">Tags</h3>
            <button onclick="openModal('addModal')" class="rounded-full px-4 py-2 bg-green-100 text-green-500">
                Add Tag
            </button>
        </div>

        <table id="tags-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $tag->id }}</td>
                        <td>{{ $tag->name }}</td>
                        <td>
                            <button onclick="openModal('editModal', {{ $tag }})" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</button>
                            <form action="{{ route('admin.tag.remove', $tag->id) }}" method="POST" class="inline-block" id="delete-form-{{ $tag->id }}">
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
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden"
        aria-hidden="true" role="dialog" aria-modal="true">
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-xl font-bold mb-4">Edit Tag</h2>
            <form id="editForm" action="{{ route('admin.tag.update', ['tag' => $tag->id]) }}" method="POST">
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
                document.getElementById('editForm').action = `/admin/tag/${tag.id}`;
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
            if (document.getElementById("tags-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                const dataTable = new simpleDatatables.DataTable("#tags-table", {
                    searchable: true,
                    sortable: true
                });
            }
        });
    </script>
@endsection
