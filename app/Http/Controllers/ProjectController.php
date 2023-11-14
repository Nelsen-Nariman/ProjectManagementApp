<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(10)->withQueryString();

        $data = [
            'projects' => $projects,
            'searchParam' => session('searchParams', [])
        ];

        return view('contents.project-management.project-list', $data);
    }

    public function search(Request $request)
    {
        $query = Project::query();

        if ($request->has("name")) {
            $query->where("name", "like", "%$request->name%");
        }

        if ($request->has("year")) {
            if ($request->year != 1) {
                $query->whereYear("created_at", $request->year);
            }
        }

        if ($request->has("status")) {
            if ($request->status != 1) {
                $query->where("status", "like", "%$request->status%");
            }
        }
        
        $preProjects = $query->paginate(10);
        $projects = $preProjects->appends($request->query());

        if ($projects->isEmpty()) {
            return redirect("projects")->with('errorSearch', 'There\'s no such thing as you mentioned before :(');
        } else {
            $data = [
                'projects' => $projects,
                'searchParams' => $request->all()
            ];

            return view('contents.project-management.project-list', $data);
        }
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
