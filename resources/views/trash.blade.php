<x-layouts.app :title="__('Trash')">

    <div class="flex w-full flex-col gap-10">

        <!-- ================= STEAM HEADER ================= -->
        <div
            class="relative overflow-hidden w-full h-44 rounded-2xl 
                   bg-gradient-to-r from-[#0b0f1a] via-[#141a2e] to-[#0b0f1a]
                   border border-red-500/40
                   shadow-[0_0_40px_rgba(255,60,60,0.45)]">

            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,80,80,0.15),transparent_60%)]"></div>

            <div class="relative h-full flex items-end p-8">
                <div>
                    <h1
                        class="text-4xl font-extrabold tracking-wide text-white
                               drop-shadow-[0_0_12px_rgba(255,80,80,0.9)]">
                        TRASH BIN
                    </h1>
                    <p class="text-gray-400 mt-1 text-sm tracking-wide">
                        Deleted games — restore or permanently remove
                    </p>
                </div>
            </div>
        </div>

        <!-- ================= SEARCH & FILTER ================= -->
        <div
            class="bg-[#0b1222]/80 backdrop-blur-xl p-6 rounded-2xl
                   border border-blue-500/30
                   shadow-[0_0_30px_rgba(0,120,255,0.35)]">

            <form method="GET" action="{{ route('trash.index') }}"
                class="flex flex-wrap gap-5 items-end">

                <div class="flex-1 min-w-[240px]">
                    <label class="text-gray-400 text-xs uppercase tracking-wider">
                        Search
                    </label>
                    <input type="text" name="search" value="{{ $request->search }}"
                        placeholder="Search games..."
                        class="w-full mt-2 px-4 py-2.5
                               bg-[#0e162b] text-white
                               border border-blue-500/30 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-blue-500/60
                               shadow-[inset_0_0_10px_rgba(0,120,255,0.25)]">
                </div>

                <div class="flex-1 min-w-[240px]">
                    <label class="text-gray-400 text-xs uppercase tracking-wider">
                        Category
                    </label>
                    <select name="category_id"
                        class="w-full mt-2 px-4 py-2.5
                               bg-[#0e162b] text-white
                               border border-blue-500/30 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-blue-500/60">
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
                    class="px-6 py-2.5 rounded-xl font-semibold text-white
                           bg-gradient-to-r from-blue-500 to-blue-700
                           hover:from-blue-600 hover:to-blue-800
                           shadow-[0_0_20px_rgba(0,120,255,0.9)]
                           transition-all duration-200">
                    Filter
                </button>

                <a href="{{ route('trash.index') }}"
                    class="px-6 py-2.5 rounded-xl text-white
                           bg-gray-600/80 hover:bg-gray-700
                           shadow-[0_0_14px_rgba(255,255,255,0.25)]
                           transition">
                    Clear
                </a>

                <a href="{{ route('trash.export.pdf', request()->query()) }}"
                    class="px-6 py-2.5 rounded-xl font-semibold text-black
                           bg-gradient-to-r from-green-400 to-green-600
                           hover:from-green-500 hover:to-green-700
                           shadow-[0_0_18px_rgba(0,255,150,0.9)]
                           transition">
                    Export PDF
                </a>
            </form>
        </div>

        <!-- ================= STATS ================= -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-[#0e162b]/80 backdrop-blur-xl p-6 rounded-2xl
                       border border-red-500/40
                       shadow-[0_0_22px_rgba(255,60,60,0.6)]">
                <h3 class="text-sm uppercase tracking-wider text-gray-400">
                    Trashed Games
                </h3>
                <p class="text-4xl font-extrabold text-red-400 mt-2">
                    {{ $totalTrashed }}
                </p>
            </div>
        </div>

        <!-- ================= TABLE ================= -->
        <div
            class="bg-[#0b1222]/90 backdrop-blur-xl rounded-2xl
                   border border-blue-500/30
                   shadow-[0_0_30px_rgba(0,120,255,0.35)]
                   overflow-x-auto">

            <table class="min-w-full text-sm">
                <thead class="bg-[#0e162b] border-b border-blue-500/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-gray-400 uppercase">Title</th>
                        <th class="px-6 py-4 text-left text-gray-400 uppercase">Description</th>
                        <th class="px-6 py-4 text-left text-gray-400 uppercase">Year</th>
                        <th class="px-6 py-4 text-left text-gray-400 uppercase">Category</th>
                        <th class="px-6 py-4 text-left text-gray-400 uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-700/60">
                    @forelse($trashedGames as $game)
                        <tr
                            class="hover:bg-[#141d35]/70 transition-all duration-200">

                            <td class="px-6 py-4 font-semibold text-white">
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

                            <td class="px-6 py-4 flex gap-3">
                                <form method="POST" action="{{ route('games.restore', $game->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        class="px-4 py-1.5 rounded-lg text-xs font-semibold
                                               bg-green-400 hover:bg-green-500 text-black
                                               shadow-[0_0_12px_rgba(0,255,150,0.9)]
                                               transition">
                                        Restore
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('games.force-delete', $game->id) }}"
                                    onsubmit="return confirm('Are you sure you want to permanently delete this game?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-4 py-1.5 rounded-lg text-xs font-semibold
                                               bg-red-600 hover:bg-red-700 text-white
                                               shadow-[0_0_14px_rgba(255,50,50,0.9)]
                                               transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="px-6 py-8 text-center text-gray-400 italic">
                                No trashed games found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>
