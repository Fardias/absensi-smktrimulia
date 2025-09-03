<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Absensi Siswa' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-lg font-bold">Absensi Siswa</h1>
            <div class="flex items-center space-x-4">
                @auth
                <span>{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">
                        Logout
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-1 max-w-5xl mx-auto p-6 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center py-3 mt-6">
        <p class="text-sm text-gray-600">&copy; {{ date('Y') }} Sistem Absensi Siswa</p>
    </footer>

</body>

</html>