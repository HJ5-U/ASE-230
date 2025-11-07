<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Return to Dashboard Link -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                    ← Return to Dashboard
                </a>
            </div>

            <!-- Dashboard Content -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">🏠 User Dashboard</h1>

                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded mb-4">
                        <h3 class="text-gray-900 dark:text-gray-100">Welcome, {{ auth()->user()->name }} 👋</h3>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Joined:</strong> {{ auth()->user()->created_at->format('F j, Y') }}</p>
                    </div>

                    <div class="mb-4">
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 transition">🚪 Logout</button>
                        </form>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900/20 p-4 border rounded mb-4">
                        <h3 class="text-gray-900 dark:text-gray-100">🔒 Protected Section</h3>
                        <p class="text-gray-700 dark:text-gray-300">Admin Access: {{ auth()->user()->isAdmin() ? '✅ GRANTED' : '❌ DENIED' }}</p>
                    </div>

                    @if (auth()->user()->isAdmin())
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 border rounded mb-4">
                            <h3 class="text-gray-900 dark:text-gray-100">🔧 Session Info</h3>
                            <p class="text-gray-700 dark:text-gray-300"><strong>Session ID:</strong> {{ session()->getId() }}</p>
                            <p class="text-gray-700 dark:text-gray-300"><strong>Login Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
                            <p class="text-gray-700 dark:text-gray-300"><strong>Session Age:</strong> {{ gmdate('H:i:s', time() - session()->get('login_time', time())) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
