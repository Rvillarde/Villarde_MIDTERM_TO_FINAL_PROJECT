<x-layouts.app :title="__('Add New Category')">
    @if(session('success'))
        <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

    <!-- Add Category (Glow Form) -->
    <div class="bg-gray-900 p-6 rounded-xl border border-blue-500/40 shadow-[0_0_25px_rgba(0,120,255,0.5)]">
        <h3 class="text-xl font-semibold mb-6 text-white drop-shadow-[0_0_10px_rgba(0,150,255,0.8)]">Add New Category</h3>

        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300">Name</label>
                    <input type="text" name="name"
                        class="mt-1 block w-full px-3 py-2 bg-gray-800 text-white rounded-md border border-blue-600/40 shadow-[0_0_12px_rgba(0,100,255,0.4)] focus:ring-blue-500"
                        required>
                    @error('name')
                    <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300">Description</label>
                    <textarea name="description" rows="3"
                        class="mt-1 block w-full px-3 py-2 bg-gray-800 text-white rounded-md border border-blue-600/40 shadow-[0_0_12px_rgba(0,100,255,0.4)]"></textarea>
                    @error('description')
                    <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


            </div>

            <button type="submit"
                class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition shadow-[0_0_18px_rgba(0,150,255,0.8)] hover:shadow-[0_0_24px_rgba(0,180,255,1)]">
                Add Category
            </button>
        </form>
    </div>

    <!-- Search and Filter -->
    <div class="bg-gray-900 p-6 rounded-xl border border-green-500/40 shadow-[0_0_25px_rgba(0,255,0,0.4)] mb-6">
        <h3 class="text-xl font-semibold mb-6 text-white drop-shadow-[0_0_12px_rgba(0,255,0,0.8)]">Search & Filter Categories</h3>

        <form method="GET" action="{{ route('categories.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-0">
                <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or description"
                    class="w-full px-3 py-2 bg-gray-800 text-white rounded-md border border-green-600/40 shadow-[0_0_12px_rgba(0,200,0,0.4)] focus:ring-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Filter</label>
                <select name="filter"
                    class="px-3 py-2 bg-gray-800 text-white rounded-md border border-green-600/40 shadow-[0_0_12px_rgba(0,200,0,0.4)] focus:ring-green-500">
                    <option value="">All Categories</option>
                </select>
            </div>

            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition shadow-[0_0_18px_rgba(0,255,0,0.8)] hover:shadow-[0_0_24px_rgba(0,255,150,1)]">
                Apply
            </button>

            @if(request('search') || request('filter'))
                <a href="{{ route('categories.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md font-medium transition shadow-[0_0_15px_rgba(100,100,100,0.6)]">
                    Clear Filters
                </a>
            @endif
        </form>
    </div>

    <!-- Categories Table (Glow Version) -->
    <div class="bg-gray-900 p-6 rounded-xl border border-purple-500/40 shadow-[0_0_25px_rgba(180,0,255,0.4)]">
        <h3 class="text-xl font-semibold mb-6 text-white drop-shadow-[0_0_12px_rgba(200,0,255,0.8)]">Categories</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse text-white">
                <thead>
                    <tr class="bg-gray-800 border-b border-purple-500/30">
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Games</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-800 hover:shadow-[0_0_15px_rgba(200,0,255,0.6)] transition">

                        <td class="px-4 py-4 whitespace-nowrap text-sm">{{ $category->name }}</td>
                        <td class="px-4 py-4 text-sm text-gray-300 max-w-xs truncate">{{ $category->description }}</td>
                        <td class="px-4 py-4 text-sm text-gray-300">{{ $category->games_count }} games</td>

                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium space-x-2">

                            <!-- EDIT BUTTON -->
                            <button
                                class="bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded-md text-xs font-medium shadow-[0_0_12px_rgba(255,200,0,0.6)] hover:shadow-[0_0_16px_rgba(255,230,0,0.9)] transition"
                                data-id="{{ $category->id }}"
                                data-name="{{ $category->name }}"
                                data-description="{{ $category->description }}"
                                data-photo="{{ $category->photo }}"
                                onclick="openEditModal(this)">
                                Edit
                            </button>

                            <!-- DELETE BUTTON -->
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-xs font-medium shadow-[0_0_12px_rgba(255,0,0,0.7)] hover:shadow-[0_0_18px_rgba(255,50,50,1)]">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal (Glow Style) -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-70 hidden backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-900 text-white p-6 rounded-xl w-1/2 border border-blue-500/40 shadow-[0_0_40px_rgba(0,150,255,0.9)]">

                <h3 class="text-lg font-semibold mb-4 drop-shadow-[0_0_10px_rgba(0,150,255,1)]">Edit Category</h3>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="editId">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-300">Name</label>
                            <input type="text" name="name" id="editName"
                                class="mt-1 w-full bg-gray-800 border border-blue-600/40 text-white p-2 rounded-md shadow-[0_0_12px_rgba(0,100,255,0.5)]"
                                required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-300">Description</label>
                            <textarea name="description" id="editDescription" rows="3"
                                class="mt-1 w-full bg-gray-800 border border-blue-600/40 text-white p-2 rounded-md shadow-[0_0_12px_rgba(0,100,255,0.5)]"></textarea>
                        </div>



                    </div>

                    <div class="mt-6 flex gap-3">
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-[0_0_20px_rgba(0,150,255,1)]">
                            Update
                        </button>

                        <button type="button" onclick="closeEditModal()"
                            class="bg-gray-700 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                            Cancel
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

    <script>
        function openEditModal(button) {
            document.getElementById('editId').value = button.dataset.id;
            document.getElementById('editName').value = button.dataset.name;
            document.getElementById('editDescription').value = button.dataset.description;
            document.getElementById('editForm').action = '/categories/' + button.dataset.id;
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
        window.onload = function() {
            const successEl = document.getElementById('successMessage');
            const errorEl = document.getElementById('errorMessage');
            if (successEl) {
                setTimeout(() => { 
                    successEl.style.transition = "opacity 1s ease-out";
                    successEl.style.opacity = '0';
                    setTimeout(() => { successEl.style.display = 'none'; }, 1000);
                }, 5000);
            }
            if (errorEl) {
                setTimeout(() => { 
                    errorEl.style.transition = "opacity 1s ease-out";
                    errorEl.style.opacity = '0';
                    setTimeout(() => { errorEl.style.display = 'none'; }, 1000);
                }, 5000);
            }
        }
    </script>
</x-layouts.app>
