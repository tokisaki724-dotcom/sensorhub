<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::with('user')->latest()->paginate(10);
        $stats = [
            'total' => Suggestion::count(),
            'pending' => Suggestion::where('status', 'pending')->count(),
            'reviewed' => Suggestion::where('status', 'reviewed')->count(),
            'implemented' => Suggestion::where('status', 'implemented')->count(),
        ];

        return view('super-admin.suggestions.index', compact('suggestions', 'stats'));
    }

    public function show(Suggestion $suggestion)
    {
        $suggestion->load('user');

        return view('super-admin.suggestions.show', compact('suggestion'));
    }

    public function updateStatus(Request $request, Suggestion $suggestion)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,implemented,rejected',
        ]);

        $suggestion->update($validated);

        return back()->with('success', 'Suggestion status updated successfully.');
    }
}
