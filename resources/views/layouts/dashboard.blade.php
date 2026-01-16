<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Perpustakaan</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <x-sidebar />

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <x-dashboard-navbar />

            <main class="w-full flex-grow p-6">
                @yield('content')
            </main>

            <footer class="bg-white p-4 text-center text-xs text-gray-400 border-t">
                &copy; {{ date('Y') }} Library System.
            </footer>
        </div>

    </div>

</body>

</html>
