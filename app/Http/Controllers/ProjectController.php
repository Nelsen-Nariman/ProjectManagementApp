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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Project $project)
    {
        //
    }

    public function edit(Project $project)
    {
        //
    }

    public function update(Request $request, Project $project)
    {
        //
    }

    public function destroy(Project $project)
    {
        //
    }
}
