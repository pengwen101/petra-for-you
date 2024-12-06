@extends('myAdmin.base')

@section('contents')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <span class="text-2xl font-bold">User</span>
    </div>
    <table class="min-w-full bg-white mt-4">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $user->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                    <td class="py-2 px-4 border-b">
                        <button onclick="openModal('editModal', {{ $user }})"
                            class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</button>
                        <form action="{{ route('admin.user.remove', $user->id) }}" method="POST" class="inline-block">
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

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden"
    aria-hidden="true" role="dialog" aria-modal="true">
    <div class="bg-white p-6 rounded shadow-lg">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>
        <form id="editForm" action="{{ route('admin.user.update', ['user' => ':id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="editName" class="block text-gray-700">Name</label>
                <input type="text" name="name" id="editName" class="w-full px-4 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="editEmail" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="editEmail" class="w-full px-4 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="editPassword" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="editPassword" class="w-full px-4 py-2 border rounded">
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
    function openModal(modalId, user = null) {
        document.getElementById(modalId).classList.remove('hidden');
        if (user) {
            document.getElementById('editName').value = user.name;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editForm').action = `/admin/user/${user.id}`;
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
</script>
@endsection