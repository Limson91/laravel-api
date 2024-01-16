<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    //INDEX
    public function index() {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    //SHOW
    public function show(Project $project) {
        $project->load('technologies'); 
        return view('admin.projects.show', compact('project'));
    }

    //CREATE
    public function create() {
        $technologies = Technology::all();
        return view('admin.projects.create', compact('technologies'));
    }

    //STORE
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'required|string',
            'description' => 'required|string',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|array',
            'technologies.*'=> 'exists:technologies,id',
        ]);

        $project = Project::create($request->only(['title', 'image_path', 'description', 'type_id']));

        if($request->has('technologies')) {
            $project->technologies()->attach($request->input('technologies'));
        }

        return redirect()->route('admin.projects.index')->with('succes', 'Project has been successfully created!');
    }

    //EDIT
    public function edit(Project $project) {
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'technologies'));
    }

    //UPDATE
    public function update(Request $request, Project $project) {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'required|string',
            'description' =>'required|string',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
        ]);

        $project->update($request->only(['title', 'image_path', 'description', 'type_id']));

        if($request->has('technologies')) {
            $project->technologies()->sync($request->input('technologies'));
        } else {
            $project->technologies()->detach();
        }

        return redirect()->route('admin.project.index')->with('success', 'Project has been successfully edited!');
    }
}
