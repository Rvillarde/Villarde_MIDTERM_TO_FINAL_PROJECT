<x-layouts.app :title="__('Trash')">

    <div class="flex h-full w-full flex-1 flex-col gap-10 rounded-xl">

        <!-- STEAM HEADER -->
        <div
            class="w-full h-40 rounded-xl bg-gradient-to-r from-gray-900 to-gray-700 shadow-[0_0_25px_rgba(255,60,60,0.6)] border border-red-600/50 flex items-end p-8">
            <div>
                <h1 class="text-4xl font-bold text-white drop-shadow-[0_0_8px_rgba(255,80,80,0.9)]">
                    TRASH BIN
                </h1>
                <p class="text-gray-300 text-lg mt-1">
                    Deleted games — restore or permanently remove
                </p>
            </div>
        </div>

        <!-- SEARCH & FILTER -->
        <div
            class="bg-gray-900 p-6 rounded-xl border border-blue-500/40 shadow-[0_0_25px_rgba(0,120,255,0.4)]">
            <form method="GET" action="{{ route('trash.index') }}"
                class="flex flex-wrap gap-4 items-end">

                <div class="flex-1 min-w-64">
                    <label class="text-gray-300 text-sm">Search</label>
                    <input type="text" name="search" value="{{ $request->search }}"
                        placeholder="Search games..."
                        class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md shadow-[0_0_12px_rgba(0,100,255,0.4)]">
                </div>

                <div class="flex-1 min-w-64">
                    <label class="text-gray-300 text-sm">Category</label>
                    <select name="category_id"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 text-white border border-blue-600/40 rounded-md">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $request->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-[0_0_18px_rgba(0,120,255,0.8)]">
                    Filter
                </button>

                <a href="{{ route('trash.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg shadow-[0_0_12px_rgba(255,255,255,0.3)]">
                    Clear
                </a>

                <a href="{{ route('trash.export.pdf', request()->query()) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-[0_0_18px_rgba(0,255,150,0.8)]">
                    Export PDF
                </a>
            </form>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-gray-800 p-6 rounded-xl border border-red-500/40 shadow-[0_0_18px_rgba(255,60,60,0.6)]">
                <h3 class="text-lg font-semibold text-white">Trashed Games</h3>
                <p class="text-3xl font-bold text-red-400 mt-2">{{ $totalTrashed }}</p>
            </div>
        </div>

        <!-- TABLE -->
        <div
            class="bg-gray-900 rounded-xl border border-blue-500/40 shadow-[0_0_25px_rgba(0,120,255,0.4)] overflow-x-auto">

            <table class="min-w-full text-sm">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-gray-300 uppercase">Title</th>
                        <th class="px-6 py-4 text-left text-gray-300 uppercase">Description</th>
                        <th class="px-6 py-4 text-left text-gray-300 uppercase">Year</th>
                        <th class="px-6 py-4 text-left text-gray-300 uppercase">Category</th>
                        <th class="px-6 py-4 text-left text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700">
                    @forelse($trashedGames as $game)
                        <tr class="hover:bg-gray-800 transition">

                            <td class="px-6 py-4 text-white font-medium">
                                {{ $game->title }}
                            </td>

                            <td class="px-6 py-4 text-gray-400">
                                {{ Str::limit($game->description, 50) }}
                            </td>

                            <td class="px-6 py-4 text-gray-400">
                                {{ $game->release_year }}
                            </td>

                            <td class="px-6 py-4 text-gray-400">
                                {{ $game->category->name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4 flex gap-2">

                                <form method="POST" action="{{ route('games.restore', $game->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="bg-green-500 hover:bg-green-600 text-black px-3 py-1 rounded-md shadow-[0_0_12px_rgba(0,255,150,0.8)] text-xs">
                                        Restore
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('games.force-delete', $game->id) }}"
                                    onsubmit="return confirm('Are you sure you want to permanently delete this game?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow-[0_0_12px_rgba(255,50,50,0.9)] text-xs">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="px-6 py-6 text-center text-gray-400">
                                No trashed games found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>
