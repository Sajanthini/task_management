<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        return view('admin.project.index');
    }

    public function edit(Project $project)
    {
        return view('admin.project.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated() + ['user_id' => auth()->id()]);

        return to_route('admin.projects.index')->with('message', 'Project Updated');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')->with('message', 'Project Deleted !');
    }

}
