@extends('myAdmin.base')

@section('contents')
<div class="container mx-auto p-10 m-10">
    <div class="flex justify-between mb-6">
        <h3 class="text-xl font-bold">Admin</h3>
        <button onclick="openModal('addModal')" class="rounded-full px-4 py-2 bg-green-100 text-green-500">
            Add Admin
        </button>
    </div>
    <table id="admin-table" class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm mt-4">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-3 px-6 border-b text-left">ID</th>
                <th class="py-3 px-6 border-b text-left">Name</th>
                <th class="py-3 px-6 border-b text-left">Active</th>
                <th class="py-3 px-6 border-b text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 border-b">{{ $admin->id }}</td>
                    <td class="py-3 px-6 border-b">{{ $admin->name }}</td>
                    <td class="py-3 px-6 border-b">{{ $admin->active ? 'Active' : 'Inactive' }}</td>
                    <td class="py-3 px-6 border-b">
                        <button onclick="openModal('editModal', {{ $admin }})"
                            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                            Edit
                        </button>
                        <form action="{{ route('admin.admin.remove', $admin->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                Deactivate
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div id="addModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden"
    aria-hidden="true" role="dialog" aria-modal="true">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Add Admin</h2>
        <form action="{{ route('admin.admin.add') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="name"
                    class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-200">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-200">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('addModal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition mr-2">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden"
    aria-hidden="true" role="dialog" aria-modal="true">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Edit Admin</h2>
        <form id="editForm" action="admin.admin.update" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="editName" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="editName"
                    class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-200">
            </div>
            <div class="mb-4">
                <label for="editPassword" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="editPassword"
                    class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-200">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('editModal')"
                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition mr-2">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalId, admin = null) {
        document.getElementById(modalId).classList.remove('hidden');
        if (admin) {
            document.getElementById('editName').value = admin.name;
            document.getElementById('editForm').action = `/admin/admin/${admin.id}`;
        }
        document.getElementById(modalId).setAttribute('aria-hidden', 'false');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.getElementById(modalId).setAttribute('aria-hidden', 'true');
    }

    window.onclick = function (event) {
        const modals = document.querySelectorAll('.fixed');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    }

    document.onkeydown = function (event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('.fixed');
            modals.forEach(modal => {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById("admin-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#admin-table", {
                searchable: true,
                sortable: true
            });
        }
    });
</script>
@endsection