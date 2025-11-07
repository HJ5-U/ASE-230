<x-guest-layout>
    <div class="text-center">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                🔒 Password Reset
            </h2>
        </div>

            
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">
                Need to Reset Your Password?
            </h3>
            
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                For security reasons, password resets must be handled by the system administrator.
            </p>
            
            <p class="text-gray-700 dark:text-gray-300 mb-4">
                Please contact the admin via email with your username or student ID:
            </p>
            
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md p-4 mb-4">
                <p class="text-lg font-mono text-blue-600 dark:text-blue-400">
                    📧 admin@example.com
                </p>
            </div>
            
            <p class="text-sm text-gray-600 dark:text-gray-400">
                The admin will verify your identity and provide you with a new temporary password.
            </p>
            
            <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    📋 <strong>Reset Process:</strong>
                </p>
                <ol class="text-xs text-gray-600 dark:text-gray-300 list-decimal list-inside space-y-1">
                    <li>Contact admin via email above</li>
                    <li>Admin will send you a password reset link</li>
                    <li>Click the link to access the <a href="#" onclick="alert('This requires a valid reset token from admin')" class="text-blue-500 hover:text-blue-700 underline">password reset form</a></li>
                    <li>Set your new password</li>
                </ol>
            </div>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center space-y-3">
            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition duration-150 ease-in-out">
                ← Back to Login
            </a>
            
            <!-- Demo/Testing Link (for development only) -->
            <div class="text-xs text-gray-500 dark:text-gray-400">
                <p>For testing purposes:</p>
                <a href="{{ route('password.reset', 'demo-token-123') }}" class="text-blue-500 hover:text-blue-700 underline">
                    🔧 View Password Reset Form (Demo)
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>