<nav class="bg-gray-800 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <span class="text-lg font-bold">Panel</span>
            </div>

            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('admin.user') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">User</a>
                    <a href="{{ route('admin.event') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Event</a>
                    <a href="{{ route('admin.tag') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Tag</a>
                    <a href="{{ route('admin.category') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Category</a>
                    <a href="{{ route('admin.booking') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Booking</a>
                    <a href="{{ route('admin.organizer') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Organizer</a>
                    <a href="{{ route('admin.admin') }}"
                        class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Admin</a>
                </div>
            </div>

            <div class="-mr-2 flex md:hidden">
                <button id="menu-button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('admin.dashboard') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('admin.user') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700">User</a>
            <a href="{{ route('admin.event') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700">Event</a>
            <a href="{{ route('admin.tag') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700">Tag</a>
            <a href="{{ route('admin.category') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700">Category</a>
            <a href="{{ route('admin.booking') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700">Booking</a>
            <a href="{{ route('admin.organizer') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700">Organizer</a>
            <a href="{{ route('admin.admin') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-gray-700">Admin</a>
        </div>
    </div>
</nav>

<script>
    document.getElementById('menu-button').addEventListener('click', function () {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
</script>