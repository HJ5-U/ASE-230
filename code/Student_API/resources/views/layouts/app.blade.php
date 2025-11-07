<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Student Database') }}</title>

    @unless(app()->environment('testing'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endunless
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <a href="{{ url('/') }}" class="font-bold">Student Database</a>

        @auth
            <span class="ml-3">Welcome, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="ml-3 bg-transparent border-none text-white hover:underline">Logout</button>
            </form>

            <ul class="mt-4 space-y-2">
                <li><a href="{{ route('students.index') }}" class="text-blue-200 hover:text-white underline">🎓 Manage Students</a></li>
                <li><a href="{{ route('profile.edit') }}" class="text-blue-200 hover:text-white underline">👤 Edit Profile</a></li>
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.users') }}" class="text-blue-200 hover:text-white underline">⚙️ Admin Panel</a></li>
                @endif
            </ul>
        @else
            <a href="{{ route('login') }}" class="text-blue-200 hover:text-white underline">Login</a>
        @endauth
    </nav>

    <main class="p-6">
        {{ $slot }}
    </main>

    <footer class="bg-gray-200 text-center text-gray-600 text-sm py-4">
        © {{ date('Y') }} Student Database. All Rights Reserved.
    </footer>
</body>
</html>
