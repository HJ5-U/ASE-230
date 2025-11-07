<x-guest-layout>
    
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-lg mx-auto text-center bg-white p-6 rounded shadow">
        @if ($wasLoggedIn)
            <div class="bg-green-50 border border-green-400 p-4 mb-4 rounded">
                <h2 class="text-xl font-bold text-green-700">✅ Logout Successful</h2>
                <p>Goodbye, <strong>{{ $username }}</strong>! You have been safely logged out.</p>
            </div>
        @else
            <div class="bg-blue-50 border border-blue-400 p-4 mb-4 rounded">
                <h2 class="text-xl font-bold text-blue-700">ℹ️ Already Logged Out</h2>
                <p>You are not currently logged in.</p>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row justify-center gap-3 mt-6">
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded">🔑 Login Again</a>
            <a href="{{ route('dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded">🏠 Main Menu</a>
        </div>

        <p class="mt-6 text-gray-600"><em>Always logout when using shared or public computers!</em></p>
    </div>
</x-guest-layout>
