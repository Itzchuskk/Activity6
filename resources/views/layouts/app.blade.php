<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Activity 10')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 text-gray-900">
    <header class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="font-semibold text-lg">Activity 10</a>
            <nav class="flex gap-4">
                <a href="{{ route('courses.index') }}" class="hover:underline">Courses</a>
                <a href="{{ route('kits.index') }}" class="hover:underline">Robotics Kits</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if (session('status'))
            <x-alert type="success" class="mb-4">{{ session('status') }}</x-alert>
        @endif
        @yield('content')
    </main>

    <footer class="border-t">
        <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-gray-600">
            © {{ date('Y') }} — All rights reserved.
        </div>
    </footer>
</body>

</html>