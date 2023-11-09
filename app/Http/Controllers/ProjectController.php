<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller{
    public function index()
    {
        $projects = Project::paginate(10)->withQueryString();
        return view('project.read', compact('projects'));
    }

    public function sortingByProgress()
    {
        $sorted = $projects->sortByDesc('progress');
        echo $sorted->values()->all();  

        return view('project.read', ['projects' => $sorted]);
    }

    public function addProject(Request $request)
    {

        $request->validate([
            'projectName' => 'required',
            'projectDescription' => 'required|max:200',
            'projectAddress' => 'required',
            'projectProgress' => 'required|numeric|min: 1|max: 100',
            'projectPriority' => 'required',
            'projectDeadline' => 'required|date',
            'projectStatus' => 'required',
        ]);

        $project = Project::create([
            'name' => $request->projectName,
            'description' => $request->projectDescription,
            'address' => $request->projectAddress,
            'progress' => $request->projectProgress,
            'priority' => $request->projectPriority,
            'deadline' => $request->projectDeadline,
            'status' => $request->projectStatus,
        ]);

        return redirect()->route('project.read');
    }

    public function updateProjectForm($id){
        $project = Project::findorFail($id);
        return view('project.updateForm', compact('project'));
    }

    public function updateProject(Request $request, $id){

        $request->validate([
            'projectName' => 'required',
            'projectDescription' => 'required|max:200',
            'projectAddress' => 'required',
            'projectProgress' => 'required|numeric|min: 1|max: 100',
            'projectPriority' => 'required',
            'projectDeadline' => 'required|date',
            'projectStatus' => 'required',
        ]);
        
        Project::findOrFail($id)->update([
            'name' => $request->projectName,
            'description' => $request->projectDescription,
            'address' => $request->projectAddress,
            'progress' => $request->projectProgress,
            'priority' => $request->projectPriority,
            'deadline' => $request->projectDeadline,
            'status' => $request->projectStatus,
        ]);

        return redirect()->route('project.read');
    }

    public function deleteProject(Request $request){
        $project = Project::find($request->id);
        $project->delete();
        
        return redirect()->route('project.read');
    }
}

