<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalGames = Game::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();

        $query = Game::with('category');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        $games = $query->get();
        $categories = Category::all();

        return view('dashboard', compact('totalGames', 'totalCategories', 'totalUsers', 'games', 'categories', 'request'));
    }

    public function exportPdf(Request $request)
    {
        $query = Game::with('category');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        $games = $query->get();

        $pdf = Pdf::loadView('pdf.games', compact('games'));

        $filename = 'games_export_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}
