<header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __('Delete Account') }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>
</header>

<!-- Simple confirmation approach -->
<form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirmDelete()">
    @csrf
    @method('delete')
    
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ __('Enter your password to confirm deletion:') }}
        </label>
        <input
            id="password"
            name="password"
            type="password"
            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            placeholder="{{ __('Password') }}"
            required
        />
        @if($errors->userDeletion->get('password'))
            <div class="mt-2 text-sm text-red-600">
                @foreach($errors->userDeletion->get('password') as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>

    <button 
        type="submit"
        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
    >
        {{ __('Delete Account') }}
    </button>
</form>

<script>
function confirmDelete() {
    return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone and all your data will be permanently lost.');
}
</script>
                        />
                        @if($errors->userDeletion->get('password'))
                            <div class="mt-2 text-sm text-red-600">
                                @foreach($errors->userDeletion->get('password') as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="hideDeleteModal()"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showDeleteModal() {
    console.log('showDeleteModal called');
    var modal = document.getElementById('deleteModal');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        console.log('Modal shown');
    } else {
        console.error('Modal element not found');
        alert('Error: Modal element not found');
    }
}

function hideDeleteModal() {
    console.log('hideDeleteModal called');
    var modal = document.getElementById('deleteModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        console.log('Modal hidden');
    }
}

// Close modal when pressing Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        hideDeleteModal();
    }
});

// Test if script is loading
console.log('Delete account script loaded successfully');
</script>