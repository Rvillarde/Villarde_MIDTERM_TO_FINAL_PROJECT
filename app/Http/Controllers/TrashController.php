<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TrashController extends Controller
{

    public function index(Request $request): View
    {
        $query = Game::onlyTrashed()->with('category');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        $trashedGames = $query->get();
        $totalTrashed = Game::onlyTrashed()->count();
        $categories = Category::all();

        return view('trash', compact('trashedGames', 'totalTrashed', 'categories', 'request'));
    }

    public function restore(string $id): RedirectResponse
    {
        $game = Game::onlyTrashed()->findOrFail($id);
        $game->restore();

        return redirect()->route('trash.index')->with('success', 'Game restored successfully!');
    }


    public function forceDelete(string $id): RedirectResponse
    {
        $game = Game::onlyTrashed()->findOrFail($id);
        $game->forceDelete();

        return redirect()->route('trash.index')->with('success', 'Game permanently deleted!');
    }

    public function exportPdf(Request $request)
    {
        $query = Game::onlyTrashed()->with('category');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        $games = $query->get();
        $totalTrashed = Game::onlyTrashed()->count();

        $stats = [
            ['label' => 'Trashed Games', 'value' => $totalTrashed],
        ];

        $title = 'Trashed Games List';
        $showDeletedAt = true;

        $pdf = \PDF::loadView('pdf.games', compact('games', 'stats', 'title', 'showDeletedAt'));

        return $pdf->download('trashed-games-list.pdf');
    }
}
