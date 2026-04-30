<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::with('user')->latest()->paginate(10);
        return view('admin.suggestions.index', compact('suggestions'));
    }

    public function show(Suggestion $suggestion)
    {
        $suggestion->load('user');
        return view('admin.suggestions.show', compact('suggestion'));
    }

    public function updateStatus(Request $request, Suggestion $suggestion)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,implemented,rejected',
        ]);

        $suggestion->update($validated);

        return back()->with('success', 'Suggestion status updated successfully!');
    }
}
