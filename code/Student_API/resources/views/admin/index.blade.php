
<div class="max-w-6xl mx-auto">
    <!-- Return to Dashboard Link -->
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
            ← Return to Dashboard
        </a>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">👥 User Management</h1>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-3 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 mb-3 rounded">{{ session('error') }}</div>
    @endif

    <h2 class="font-semibold mb-2">📊 User Stats</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        @foreach($stats as $key => $val)
        <div class="p-4 border rounded text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $val }}</div>
            <div class="capitalize">{{ str_replace('_', ' ', $key) }}</div>
        </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}" class="mb-6">
        @csrf
        <h3 class="font-semibold mb-2">Add User</h3>
        <input type="text" name="name" placeholder="Name" class="border p-2 mb-2 w-full">
        <input type="email" name="email" placeholder="Email" class="border p-2 mb-2 w-full">
        <input type="password" name="password" placeholder="Password" class="border p-2 mb-2 w-full">
        <select name="role" class="border p-2 mb-2 w-full">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button class="bg-blue-600 text-white px-3 py-2 rounded">Create</button>
    </form>

    <h2 class="font-semibold mb-2">All Users</h2>
    <table class="w-full border-collapse border">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Name</th>
                <th class="p-2">Email</th>
                <th class="p-2">Status</th>
                <th class="p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr class="border-t">
                <td class="p-2">{{ $u->id }}</td>
                <td class="p-2">{{ $u->name }}</td>
                <td class="p-2">{{ $u->email }}</td>
                <td class="p-2">
                    @if($u->is_active)
                        <span class="text-green-600 font-bold">Active</span>
                    @else
                        <span class="text-red-600 font-bold">Inactive</span>
                    @endif
                </td>
                <td class="p-2">
                    @if($u->id === auth()->id())
                        <span class="bg-gray-400 text-white px-2 py-1 rounded">Self</span>
                    @else
                        <form method="POST" action="{{ route('admin.users.toggle') }}" class="inline">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $u->id }}">
                            <input type="hidden" name="action" value="{{ $u->is_active ? 'deactivate' : 'activate' }}">
                            <button type="submit"
                                class="px-2 py-1 text-white rounded {{ $u->is_active ? 'bg-red-600' : 'bg-green-600' }}">
                                {{ $u->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-700 text-white px-2 py-1 rounded"
                                onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Admin Actions Section -->
    <div class="mt-8">
        <h2 class="font-semibold mb-4">🔧 Admin Actions</h2>
        
        <div class="bg-red-50 border border-red-200 rounded p-4">
            <h3 class="font-semibold text-red-800 mb-2">⚠️ Dangerous Actions</h3>
            <p class="text-red-700 text-sm mb-3">These actions cannot be undone. Use with extreme caution.</p>
            
            <!-- Delete All Students -->
            <form method="POST" action="{{ route('students.destroyAll') }}" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800"
                        onclick="return confirm('⚠️ WARNING: This will delete ALL student records permanently!\n\nThis action cannot be undone. Are you absolutely sure?')">
                    🗑️ Delete All Students
                </button>
            </form>
        </div>
    </div>
</div>

