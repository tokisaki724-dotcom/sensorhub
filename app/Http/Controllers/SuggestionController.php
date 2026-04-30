<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function mySuggestions()
    {
        $suggestions = auth()->user()->suggestions()->latest()->get();
        return view('user.suggestions', compact('suggestions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'difficulty' => 'nullable|string|in:Beginner,Intermediate,Advanced',
            'sensor_type' => 'nullable|string|max:255',
        ]);

        auth()->user()->suggestions()->create($request->all());
        
        return back()->with('success', 'Suggestion submitted successfully! We\'ll review it soon.');
    }
}
