<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    public function getAll(){
        $projects = Project::all();

        return view('project.index', compact('projects'));
    }

    public function createProject(){
        $attributes = request()->validate([
            'name' => 'required',
        ]);

        $attributes['code'] = request()->code;
        $attributes['short'] = request()->short;
        $attributes['description'] = request()->description;
        $attributes['created_by'] = auth()->user()->id;

        Project::create($attributes);

        return response()->json(['status' => 'success']);
    }

    public function createProjectSuccess(){
        return redirect()->route('projects')->with(['status' => 'Training has been created successfully']);
    }

    public function updateProject()
    {
        $attributes = request()->validate([
            'name' => 'required',
        ]);

        $attributes['code'] = request()->code;
        $attributes['short'] = request()->short;
        $attributes['description'] = request()->description;
        $attributes['updated_by'] = auth()->user()->id;

        Project::find(request()->id)->update($attributes);

        return response()->json(['status' => 'success']);
    }

    public function updateProjectSuccess(){
        return redirect()->route('projects')->with('status', 'The project has been updated successfully.');
    }

    public function deleteProject(){
        Project::find(request()->id)->delete();

        return redirect()->route('projects')->with('status', 'The project has been deleted successfully.');
    }
}
