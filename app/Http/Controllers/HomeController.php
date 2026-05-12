<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Project;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            // Dashboard data for authenticated users
            $user = auth()->user();
            $suggestionsCount = $user->suggestions()->count();
            $savedProjectsCount = $user->savedProjects()->count();
            $recentSuggestions = $user->suggestions()->latest()->take(5)->get();
            $featuredSensors = Sensor::where('is_active', true)->latest()->take(6)->get();
            $featuredProjects = Project::where('is_active', true)->where('is_featured', true)->take(4)->get();
            
            return view('home', compact('user', 'suggestionsCount', 'savedProjectsCount', 'recentSuggestions', 'featuredSensors', 'featuredProjects'));
        } else {
            // Public home data for guests
            $featuredSensors = Sensor::where('is_active', true)->latest()->take(6)->get();
            $featuredProjects = Project::where('is_active', true)->where('is_featured', true)->latest()->take(4)->get();
            $latestVideos = Video::where('is_active', true)->latest()->take(4)->get();
            
            return view('home', compact('featuredSensors', 'featuredProjects', 'latestVideos'));
        }
    }
}
