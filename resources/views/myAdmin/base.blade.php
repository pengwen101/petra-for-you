<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>myAdmin</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @yield('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex flex-col">
        @include('myAdmin.nav')

        <main class="flex-grow">
            <div class="container mx-auto px-4 py-6">
                @yield('contents')
            </div>
        </main>
        <footer class="bg-gray-800 text-white py-4 mt-6">
            <div class="container mx-auto text-center text-sm">
                &copy; {{ date('Y') }} Petra for You myAdmin. All rights reserved.
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

    <script type="module">
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
    @yield('script')
</body>

</html>