<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">🚀 User Registration</h1>
        <p class="mb-4 text-gray-700">Create a new account to access the system.</p>

        {{-- Success message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Error message --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 p-3 mb-4 rounded">
                <strong>Please fix the following:</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label class="font-semibold">Username:</label>
                <input type="text" name="name" value="{{ old('name') }}" class="border p-2 w-full rounded" required>
                <p class="text-sm text-gray-600">Choose a unique username (3–20 characters)</p>
            </div>

            <div>
                <label class="font-semibold">Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" class="border p-2 w-full rounded" required>
                <p class="text-sm text-gray-600">We'll use this for account recovery</p>
            </div>

            <div>
                <label class="font-semibold">Password:</label>
                <input type="password" name="password" class="border p-2 w-full rounded" required>
                <p class="text-sm text-gray-600">Must include uppercase, lowercase, number, and symbol.</p>
            </div>

            <div>
                <label class="font-semibold">Confirm Password:</label>
                <input type="password" name="password_confirmation" class="border p-2 w-full rounded" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create Account
            </button>
        </form>

        <p class="mt-4"><a href="{{ route('login') }}" class="text-blue-700 underline">Already have an account? Login</a></p>
    </div>
</x-guest-layout>
