<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::latest()->paginate(10);
        return view('admin.sensors.index', compact('sensors'));
    }

    public function create()
    {
        return view('admin.sensors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'how_it_works' => 'required|string',
            'use_cases' => 'required|string',
            'components_needed' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sensors', 'public');
        }

        Sensor::create($validated);

        return redirect()->route('admin.sensors.index')
            ->with('success', 'Sensor created successfully!');
    }

    public function edit(Sensor $sensor)
    {
        return view('admin.sensors.edit', compact('sensor'));
    }

    public function update(Request $request, Sensor $sensor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'how_it_works' => 'required|string',
            'use_cases' => 'required|string',
            'components_needed' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sensors', 'public');
        }

        $sensor->update($validated);

        return redirect()->route('admin.sensors.index')
            ->with('success', 'Sensor updated successfully!');
    }

    public function destroy(Sensor $sensor)
    {
        $sensor->delete();
        return redirect()->route('admin.sensors.index')
            ->with('success', 'Sensor deleted successfully!');
    }
}
