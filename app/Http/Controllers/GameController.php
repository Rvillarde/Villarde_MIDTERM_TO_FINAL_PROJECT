<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GameController extends Controller
{

    public function index(Request $request): View
    {
        $query = Game::with('category');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        $games = $query->get();
        $totalGames = Game::count();
        $totalCategories = Category::count();
        $totalUsers = \App\Models\User::count(); // Static or dynamic third card

        $categories = Category::all();

        return view('dashboard', compact('games', 'totalGames', 'totalCategories', 'totalUsers', 'categories', 'request'));
    }

    public function create()
    {
    
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'category_id' => 'nullable|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Game::create($validated);

        return redirect()->route('dashboard')->with('success', 'Game added successfully!');
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $game = Game::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'category_id' => 'nullable|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $game->update($validated);

        return redirect()->route('dashboard')->with('success', 'Game updated successfully!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->route('dashboard')->with('success', 'Game deleted successfully!');
    }


    public function exportPdf(Request $request)
    {
        $query = Game::with('category');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $filename = 'games.pdf';
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
            $category = Category::find($request->category_id);
            if ($category) {
                $filename = $category->name . '.pdf';
            }
        }

        $games = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.games', compact('games'));

        return $pdf->download($filename);
    }
}
