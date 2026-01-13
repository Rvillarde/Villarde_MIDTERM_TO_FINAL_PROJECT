<x-layouts.app :title="__('Dashboard')">
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
    <div class="flex h-full w-full flex-1 flex-col gap-10 rounded-xl">

    <!-- STEAM HEADER WITH GLOW -->
    <div class="w-full h-48 rounded-xl bg-gradient-to-r from-gray-900 to-gray-700 shadow-[0_0_25px_rgba(0,150,255,0.5)] border border-blue-600/50 flex items-end p-8">
        <div>
            <h1 class="text-4xl font-bold text-white drop-shadow-[0_0_8px_rgba(0,150,255,0.8)]">
                FAKE STEAM STORE
            </h1>
            <p class="text-gray-300 text-lg mt-1">Manage your game library style.</p>
        </div>
    </div>

    <!-- STATS WITH GLOW -->
    <div class="grid auto-rows-min gap-6 md:grid-cols-3">
        <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/40 shadow-[0_0_15px_rgba(0,130,255,0.4)] hover:shadow-[0_0_25px_rgba(0,160,255,0.8)] transition">
            <h3 class="text-lg font-semibold text-white">Total Games</h3>
            <p class="text-3xl font-bold text-blue-400 mt-2">{{ $totalGames }}</p>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl border border-green-500/40 shadow-[0_0_15px_rgba(0,255,120,0.4)] hover:shadow-[0_0_25px_rgba(0,255,150,0.8)] transition">
            <h3 class="text-lg font-semibold text-white">Total Categories</h3>
            <p class="text-3xl font-bold text-green-400 mt-2">{{ $totalCategories }}</p>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl border border-purple-500/40 shadow-[0_0_15px_rgba(180,0,255,0.4)] hover:shadow-[0_0_25px_rgba(200,0,255,0.8)] transition">
            <h3 class="text-lg font-semibold text-white">Total Users</h3>
            <p class="text-3xl font-bold text-purple-400 mt-2">{{ $totalUsers }}</p>
        </div>
    </div>

    <!-- ADD GAME FORM WITH GLOW -->
    <div class="bg-gray-900 p-6 rounded-xl border border-blue-500/40 shadow-[0_0_25px_rgba(0,120,255,0.5)]">
        <h3 class="text-2xl font-semibold mb-6 text-white drop-shadow-[0_0_10px_rgba(0,130,255,0.7)]">
            Add New Game
        </h3>

        <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-gray-300 text-sm">Title</label>
                    <input type="text" name="title"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md focus:ring-blue-500 shadow-[0_0_12px_rgba(0,100,255,0.4)]">
                </div>

                <div>
                    <label class="text-gray-300 text-sm">Category</label>
                    <select name="category_id"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="text-gray-300 text-sm">Release Year</label>
                    <input type="number" name="release_year"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md shadow-[0_0_12px_rgba(0,100,255,0.4)]">
                </div>

                <div class="md:col-span-2">
                    <label class="text-gray-300 text-sm">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md shadow-[0_0_12px_rgba(0,100,255,0.4)]"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="text-gray-300 text-sm">Photo</label>
                    <input type="file" name="photo" accept="image/*"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md shadow-[0_0_12px_rgba(0,100,255,0.4)]">
                </div>

            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-[0_0_18px_rgba(0,120,255,0.8)] hover:shadow-[0_0_25px_rgba(0,150,255,1)] transition">
                Add Game
            </button>
        </form>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="bg-gray-900 p-6 rounded-xl border border-blue-500/40 shadow-[0_0_25px_rgba(0,120,255,0.5)] mb-6">
        <h3 class="text-2xl font-semibold mb-4 text-white drop-shadow-[0_0_10px_rgba(0,130,255,0.7)]">
            Search & Filter Games
        </h3>
        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label class="text-gray-300 text-sm">Search by Title</label>
                <input type="text" name="search" value="{{ $request->search }}" placeholder="Enter game title..."
                    class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md focus:ring-blue-500 shadow-[0_0_12px_rgba(0,100,255,0.4)]">
            </div>
            <div class="flex-1 min-w-64">
                <label class="text-gray-300 text-sm">Filter by Category</label>
                <select name="category_id"
                    class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $request->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-[0_0_18px_rgba(0,120,255,0.8)] hover:shadow-[0_0_25px_rgba(0,150,255,1)] transition">
                Search
            </button>
            <a href="{{ route('dashboard') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg shadow-[0_0_12px_rgba(255,255,255,0.3)] transition">
                Clear Filters
            </a>
        </form>
    </div>

    <!-- GAMES GRID -->
    <h3 class="text-3xl font-semibold text-white drop-shadow-[0_0_12px_rgba(0,150,255,0.8)]">Games</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        @foreach($games as $game)

        <div
            class="bg-gray-800 border border-blue-500/40 rounded-xl shadow-[0_0_20px_rgba(0,120,255,0.4)] hover:shadow-[0_0_35px_rgba(0,150,255,0.8)] transition overflow-hidden group">

            <div class="h-40 bg-gray-700 bg-cover bg-center group-hover:shadow-[0_0_20px_rgba(0,150,255,0.9)] transition flex items-center justify-center">
                @if($game->photo)
                    <img src="{{ asset('storage/' . $game->photo) }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                @else
                    <div class="text-6xl font-bold text-blue-400">{{ substr($game->title, 0, 1) }}</div>
                @endif
            </div>

            <div class="p-5">
                <h4 class="text-lg font-bold text-white group-hover:text-blue-300 drop-shadow-[0_0_8px_rgba(0,150,255,0.8)] transition">
                    {{ $game->title }}
                </h4>

                <p class="text-gray-400 text-sm mt-2 h-12 overflow-hidden">{{ $game->description }}</p>

                <p class="text-gray-500 text-xs mt-3">Released:
                    <span class="text-gray-300">{{ $game->release_year }}</span>
                </p>

                <p class="text-gray-500 text-xs">Category:
                    <span class="text-gray-300">{{ $game->category->name ?? 'N/A' }}</span>
                </p>

                <div class="flex justify-between mt-4">

                    <!-- EDIT BUTTON -->
                    <button onclick="openEditModal(this)"
                        data-id="{{ $game->id }}"
                        data-title="{{ $game->title }}"
                        data-description="{{ $game->description }}"
                        data-release_year="{{ $game->release_year }}"
                        data-category_id="{{ $game->category_id }}"
                        data-photo="{{ $game->photo }}"
                        class="text-xs bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1 rounded-md shadow-[0_0_12px_rgba(255,200,0,0.6)] hover:shadow-[0_0_16px_rgba(255,230,0,0.9)]">
                        Edit
                    </button>

                    <form action="{{ route('games.destroy', $game) }}" method="POST"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button
                            class="text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow-[0_0_12px_rgba(255,0,0,0.6)] hover:shadow-[0_0_16px_rgba(255,50,50,1)]">
                            Delete
                        </button>
                    </form>

                </div>

            </div>
        </div>

        @endforeach
    </div>

    <!-- GLOW MODAL -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-70 hidden z-50 backdrop-blur-sm">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-gray-900 p-8 rounded-xl border border-blue-500/40 shadow-[0_0_40px_rgba(0,150,255,0.8)] w-1/2">

                <h3 class="text-2xl font-semibold text-white mb-4 drop-shadow-[0_0_10px_rgba(0,150,255,1)]">
                    Edit Game
                </h3>

                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="editId" name="id">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="text-gray-300 text-sm">Title</label>
                            <input id="editTitle" name="title"
                                class="mt-1 w-full bg-gray-800 border border-blue-600/40 text-white p-2 rounded-md shadow-[0_0_12px_rgba(0,100,255,0.5)]">
                        </div>

                        <div>
                            <label class="text-gray-300 text-sm">Release Year</label>
                            <input id="editReleaseYear" name="release_year" type="number"
                                class="mt-1 w-full bg-gray-800 border border-blue-600/40 text-white p-2 rounded-md">
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-gray-300 text-sm">Description</label>
                            <textarea id="editDescription" name="description" rows="3"
                                class="mt-1 w-full bg-gray-800 border border-blue-600/40 text-white p-2 rounded-md"></textarea>
                        </div>

                        <div>
                            <label class="text-gray-300 text-sm">Category</label>
                            <select id="editCategoryId" name="category_id"
                                class="mt-1 w-full bg-gray-800 border border-blue-600/40 text-white p-2 rounded-md">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-gray-300 text-sm">Photo (leave empty to keep current)</label>
                            <input type="file" name="photo" accept="image/*"
                                class="mt-1 w-full bg-gray-800 border border-blue-600/40 text-white p-2 rounded-md shadow-[0_0_12px_rgba(0,100,255,0.5)]">
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-[0_0_20px_rgba(0,150,255,0.9)]">
                            Update
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="bg-gray-700 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow-[0_0_12px_rgba(255,255,255,0.3)]">
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
        document.getElementById('editTitle').value = button.dataset.title;
        document.getElementById('editDescription').value = button.dataset.description;
        document.getElementById('editReleaseYear').value = button.dataset.release_year;
        document.getElementById('editCategoryId').value = button.dataset.category_id;
        // Note: File inputs can't be pre-filled for security reasons, so photo is not set
        document.getElementById('editForm').action = '/games/' + button.dataset.id;
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
