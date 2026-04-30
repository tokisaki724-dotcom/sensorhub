<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::where('is_active', true)->latest()->paginate(12);
        return view('sensors.index', compact('sensors'));
    }

    public function show($slug)
    {
        $sensor = Sensor::where('slug', $slug)->firstOrFail();
        $relatedProjects = $sensor->projects()->where('is_active', true)->take(3)->get();
        $relatedVideos = $sensor->videos()->where('is_active', true)->take(3)->get();
        return view('sensors.show', compact('sensor', 'relatedProjects', 'relatedVideos'));
    }
}
