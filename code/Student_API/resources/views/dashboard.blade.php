<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- Quick Navigation -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Students Section -->
                <a href="{{ route('students.index') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">📚 Students</h3>
                        <p class="text-gray-600 dark:text-gray-400">Manage student records and information</p>
                    </div>
                </a>

                <!-- Profile Section -->
                <a href="{{ route('profile.edit') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">👤 Profile</h3>
                        <p class="text-gray-600 dark:text-gray-400">Update your account settings</p>
                    </div>
                </a>

                @if(auth()->user()->isAdmin())
                <!-- Admin Section -->
                <a href="{{ route('admin.users') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">⚙️ Admin</h3>
                        <p class="text-gray-600 dark:text-gray-400">Manage users and system settings</p>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
