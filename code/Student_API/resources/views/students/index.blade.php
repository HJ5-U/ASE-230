<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Students') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Return to Dashboard Link -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                    ← Return to Dashboard
                </a>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">

                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Add New Student Form -->
                <form method="POST" action="{{ route('students.store') }}" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Name" class="border p-2 rounded" required>
                    <input type="text" name="course" placeholder="Course" class="border p-2 rounded" required>
                    <input type="text" name="major" placeholder="Major" class="border p-2 rounded" required>
                    <input type="number" name="year" placeholder="Year" class="border p-2 rounded" min="1" max="5" required>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Add</button>
                </form>

                <!-- Search Section -->
                <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200">Search Students</h3>
                    
                    <!-- Search by ID -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search by ID:</label>
                        <div class="flex gap-2">
                            <input type="number" id="searchById" placeholder="Enter student ID" class="border p-2 rounded flex-1">
                            <button onclick="searchStudentById()" class="bg-green-600 text-white px-4 py-2 rounded">Search ID</button>
                        </div>
                    </div>

                    <!-- Search by Other Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name:</label>
                            <input type="text" id="searchByName" placeholder="Enter name" class="border p-2 rounded w-full">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Course:</label>
                            <input type="text" id="searchByCourse" placeholder="Enter course" class="border p-2 rounded w-full">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Major:</label>
                            <input type="text" id="searchByMajor" placeholder="Enter major" class="border p-2 rounded w-full">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year:</label>
                            <input type="number" id="searchByYear" placeholder="Enter year" class="border p-2 rounded w-full" min="1" max="5">
                        </div>
                    </div>

                    <!-- Search Buttons -->
                    <div class="mt-4 flex gap-2 flex-wrap">
                        <button onclick="searchByField('name')" class="bg-purple-600 text-white px-3 py-1 rounded text-sm">Search Name</button>
                        <button onclick="searchByField('course')" class="bg-purple-600 text-white px-3 py-1 rounded text-sm">Search Course</button>
                        <button onclick="searchByField('major')" class="bg-purple-600 text-white px-3 py-1 rounded text-sm">Search Major</button>
                        <button onclick="searchByField('year')" class="bg-purple-600 text-white px-3 py-1 rounded text-sm">Search Year</button>
                        <button onclick="showAllStudents()" class="bg-gray-600 text-white px-3 py-1 rounded text-sm">Show All</button>
                        <button onclick="clearSearch()" class="bg-red-600 text-white px-3 py-1 rounded text-sm">Clear</button>
                    </div>

                    <!-- Search Results Info -->
                    <div id="searchInfo" class="mt-3 text-sm text-gray-600 dark:text-gray-400" style="display: none;">
                        <span id="searchResultText"></span>
                    </div>
                </div>

                <!-- Students Table -->
                <table class="w-full border-collapse border">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2 border">Name</th>
                            <th class="p-2 border">Course</th>
                            <th class="p-2 border">Major</th>
                            <th class="p-2 border">Year</th>
                            <th class="p-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                <td class="p-2 border">{{ $student->name }}</td>
                                <td class="p-2 border">{{ $student->course }}</td>
                                <td class="p-2 border">{{ $student->major }}</td>
                                <td class="p-2 border">{{ $student->year }}</td>
                                <td class="p-2 border text-center">
                                    <!-- Edit Button with Inline Form -->
                                    <details class="inline">
                                        <summary class="bg-yellow-500 text-white px-2 py-1 rounded cursor-pointer">Edit</summary>
                                        <div class="mt-2 p-2 border rounded bg-gray-50">
                                            <form action="{{ route('students.update', $student->id) }}" method="POST" class="space-y-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" value="{{ $student->name }}" class="w-full p-1 border rounded text-sm" placeholder="Name" required>
                                                <input type="text" name="course" value="{{ $student->course }}" class="w-full p-1 border rounded text-sm" placeholder="Course" required>
                                                <input type="text" name="major" value="{{ $student->major }}" class="w-full p-1 border rounded text-sm" placeholder="Major" required>
                                                <input type="number" name="year" value="{{ $student->year }}" class="w-full p-1 border rounded text-sm" placeholder="Year" min="1" max="5" required>
                                                <div class="flex gap-1">
                                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs">Save</button>
                                                    <button type="button" onclick="this.closest('details').removeAttribute('open')" class="bg-gray-500 text-white px-2 py-1 rounded text-xs">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </details>

                                    <!-- Delete Button -->
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded" onclick="return confirm('Delete this student?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Delete All Button (for admin) -->
                @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('students.destroyAll') }}" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-700 text-white px-3 py-2 rounded"
                            onclick="return confirm('Are you sure? This will delete ALL records!')">
                            Delete All Students
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Store original students data for reset functionality
        let originalStudentsData = null;
        
        // Function to search student by ID
        function searchStudentById() {
            const id = document.getElementById('searchById').value.trim();
            if (!id) {
                alert('Please enter a student ID');
                return;
            }
            
            fetch(`/students/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Student not found');
                    }
                    return response.json();
                })
                .then(student => {
                    displaySearchResults([student], `Found student with ID: ${id}`);
                })
                .catch(error => {
                    displaySearchResults([], `No student found with ID: ${id}`);
                });
        }

        // Function to search by field (name, course, major, year)
        function searchByField(field) {
            let value;
            let searchUrl;
            
            switch(field) {
                case 'name':
                    value = document.getElementById('searchByName').value.trim();
                    searchUrl = `/students/by-name/${encodeURIComponent(value)}`;
                    break;
                case 'course':
                    value = document.getElementById('searchByCourse').value.trim();
                    searchUrl = `/students/by-course/${encodeURIComponent(value)}`;
                    break;
                case 'major':
                    value = document.getElementById('searchByMajor').value.trim();
                    searchUrl = `/students/by-major/${encodeURIComponent(value)}`;
                    break;
                case 'year':
                    value = document.getElementById('searchByYear').value;
                    searchUrl = `/students/by-year/${value}`;
                    break;
            }
            
            if (!value) {
                alert(`Please enter a ${field} to search for`);
                return;
            }
            
            fetch(searchUrl)
                .then(response => response.json())
                .then(students => {
                    displaySearchResults(students, `Search results for ${field}: "${value}" (${students.length} found)`);
                })
                .catch(error => {
                    displaySearchResults([], `Error searching by ${field}: ${error.message}`);
                });
        }

        // Function to display search results
        function displaySearchResults(students, message) {
            // Store original data if not already stored
            if (originalStudentsData === null) {
                originalStudentsData = document.querySelector('tbody').innerHTML;
            }
            
            // Show search info
            const searchInfo = document.getElementById('searchInfo');
            const searchResultText = document.getElementById('searchResultText');
            searchResultText.textContent = message;
            searchInfo.style.display = 'block';
            
            // Update table body
            const tbody = document.querySelector('tbody');
            
            if (students.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="p-4 text-center text-gray-500">No students found for your search.</td></tr>';
            } else {
                tbody.innerHTML = students.map(student => `
                    <tr>
                        <td class="p-2 border">${student.name}</td>
                        <td class="p-2 border">${student.course}</td>
                        <td class="p-2 border">${student.major}</td>
                        <td class="p-2 border">${student.year}</td>
                        <td class="p-2 border text-center">
                            <!-- Edit Button with Inline Form -->
                            <details class="inline">
                                <summary class="bg-yellow-500 text-white px-2 py-1 rounded cursor-pointer">Edit</summary>
                                <div class="mt-2 p-2 border rounded bg-gray-50">
                                    <form action="/students/${student.id}" method="POST" class="space-y-2">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="text" name="name" value="${student.name}" class="w-full p-1 border rounded text-sm" placeholder="Name" required>
                                        <input type="text" name="course" value="${student.course}" class="w-full p-1 border rounded text-sm" placeholder="Course" required>
                                        <input type="text" name="major" value="${student.major}" class="w-full p-1 border rounded text-sm" placeholder="Major" required>
                                        <input type="number" name="year" value="${student.year}" class="w-full p-1 border rounded text-sm" placeholder="Year" min="1" max="5" required>
                                        <div class="flex gap-1">
                                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs">Save</button>
                                            <button type="button" onclick="this.closest('details').removeAttribute('open')" class="bg-gray-500 text-white px-2 py-1 rounded text-xs">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </details>
                            <!-- Delete Button -->
                            <form action="/students/${student.id}" method="POST" class="inline">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded" onclick="return confirm('Delete this student?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                `).join('');
            }
        }

        // Function to show all students (reset)
        function showAllStudents() {
            // Hide search info
            document.getElementById('searchInfo').style.display = 'none';
            
            // Clear all search fields
            document.getElementById('searchById').value = '';
            document.getElementById('searchByName').value = '';
            document.getElementById('searchByCourse').value = '';
            document.getElementById('searchByMajor').value = '';
            document.getElementById('searchByYear').value = '';
            
            // Reload the page to show original data
            location.reload();
        }

        // Function to clear search inputs
        function clearSearch() {
            document.getElementById('searchById').value = '';
            document.getElementById('searchByName').value = '';
            document.getElementById('searchByCourse').value = '';
            document.getElementById('searchByMajor').value = '';
            document.getElementById('searchByYear').value = '';
            document.getElementById('searchInfo').style.display = 'none';
            
            // Reset table if search results are shown
            if (originalStudentsData) {
                showAllStudents();
            }
        }

        // Add Enter key support for search inputs
        document.addEventListener('DOMContentLoaded', function() {
            // Store original table data immediately on page load
            originalStudentsData = document.querySelector('tbody').innerHTML;
            
            document.getElementById('searchById').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') searchStudentById();
            });
            
            document.getElementById('searchByName').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') searchByField('name');
            });
            
            document.getElementById('searchByCourse').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') searchByField('course');
            });
            
            document.getElementById('searchByMajor').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') searchByField('major');
            });
        });
    </script>
</x-app-layout>
