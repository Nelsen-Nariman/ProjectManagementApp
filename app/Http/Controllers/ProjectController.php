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

    public function sorting($typeSorting)
    {
        $sorted = null;

        if ($typeSorting === "byProgress") {
            $sorted = Project::orderBy('progress', 'desc')->paginate(10)->withQueryString();
        }else if ($typeSorting === "byName") {
            $sorted = Project::orderBy('name', 'asc')->paginate(10)->withQueryString();
        }
        
        $data = [
            'projects' => $sorted
        ];

        return view('contents.project-management.project-list', $data);
    }

    public function search(Request $request)
    {
        // dd($request->all());
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

        if ($request->has("priority")) {
            if ($request->priority != 1) {
                $query->where("priority", "like", "%$request->priority%");
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
            'projectPriority' => 'required',
            'projectDeadline' => 'required',
        ]);

        $date = \DateTime::createFromFormat('d-m-Y', $request->projectDeadline);
        $deadline = $date->format('Y-m-d');

        $projects =Project::create([
            'name' => $request->projectName,
            'description' => $request->projectDescription,
            'address' => $request->projectAddress,
            'progress' => 0,
            'priority' => $request->projectPriority,
            'deadline' => $deadline,
            'status' => "On Progress",
        ]);

        return redirect()->route('projects');
    }

    public function updateProjectForm($id){
        $project = Project::findorFail($id);
        $dateTime = new \DateTime($project->deadline);
        $project->deadline = $dateTime->format('d-m-Y');
        return view('contents.project-management.update-project', compact('project'));
    }

    public function updateProject(Request $request, $id){

        $request->validate([
            'projectName' => 'required',
            'projectDescription' => 'required|max:200',
            'projectAddress' => 'required',
            'projectPriority' => 'required',
            'projectDeadline' => 'required',
            'projectProgress' => 'required'
        ]);

        $status = "On Progress";
        $progress = (int)$request->projectProgress; // Casting to integer for comparison
        
        if ($progress === 100) {
            $status = "Completed"; // Add a semicolon here
        }
        
        $date = \DateTime::createFromFormat('d-m-Y', $request->projectDeadline);
        $deadline = $date->format('Y-m-d');
        
        Project::findOrFail($id)->update([
            'name' => $request->projectName,
            'description' => $request->projectDescription,
            'address' => $request->projectAddress,
            'priority' => $request->projectPriority,
            'deadline' => $deadline,
            'progress' => $request->projectProgress,
            'status' => $status
        ]);

        return redirect()->route('projects');
    }

    public function deleteProject(Request $request){
        $project = Project::find($request->id);
        $project->delete();
        
        return redirect()->route('projects');
    }
}
