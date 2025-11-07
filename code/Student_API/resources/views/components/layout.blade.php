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
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="bg-blue-600 text-white p-4 flex flex-col sm:flex-row sm:justify-between">
        <div>
            <a href="{{ url('/') }}" class="font-bold text-lg">Student Database</a>
        </div>
        <div class="mt-2 sm:mt-0">
            @auth
                <span>Welcome, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="ml-3 text-white underline hover:text-gray-200">Logout</button>
                </form>

                <ul class="flex flex-col sm:flex-row sm:space-x-4 mt-2 sm:mt-0">
                    <li><a href="{{ route('students.index') }}" class="hover:underline">🎓 Manage Students</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="hover:underline">👤 Edit Profile</a></li>
                    @if(auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.users') }}" class="hover:underline">⚙️ Admin Panel</a></li>
                    @endif
                </ul>
            @else
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Page Content Slot -->
    <main class="flex-grow p-6">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-center text-sm text-gray-600 py-3">
        © {{ date('Y') }} Student Database App — All Rights Reserved.
    </footer>

</body>
</html>
