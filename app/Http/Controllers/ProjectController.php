<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SavedProject;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_active', true)->with('sensor')->latest()->paginate(12);
        return view('projects.index', compact('projects'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->with('sensor')->firstOrFail();
        $isSaved = auth()->check() && SavedProject::where('user_id', auth()->id())->where('project_id', $project->id)->exists();
        return view('projects.show', compact('project', 'isSaved'));
    }

    public function saved()
    {
        $savedProjects = SavedProject::where('user_id', auth()->id())->with('project')->latest()->get();
        return view('user.saved-projects', compact('savedProjects'));
    }

    public function toggleSave(Project $project)
    {
        $savedProject = SavedProject::where('user_id', auth()->id())->where('project_id', $project->id)->first();
        
        if ($savedProject) {
            $savedProject->delete();
            return back()->with('success', 'Project removed from saved list.');
        } else {
            SavedProject::create([
                'user_id' => auth()->id(),
                'project_id' => $project->id,
            ]);
            return back()->with('success', 'Project saved successfully!');
        }
    }
}
