<?php

namespace App\Http\Controllers;
use App\Models\Project;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AreaController extends Controller{

    public function index($project_id)
    {
        $project = Project::findOrFail($project_id);

        $areas = $project->areas()->paginate(10);
        // dd($areas);
        return view('contents.project-management.area-management.area-list', compact('areas', 'project_id'));
    }

    public function addArea(Request $request, $project_id)
{
    $request->validate([
        'areaName' => [
            'required',
            'unique:areas,name',
            Rule::unique('areas', 'name')
        ],
        'areaDescription' => 'required|max:200',
    ]);

    Area::create([
        'name' => $request->areaName,
        'description' => $request->areaDescription,
        'project_id' => $project_id,
    ]);
    

    // Retrieve areas after adding the new one
    $project = Project::findOrFail($project_id);
    $areas = $project->areas()->paginate(10);

    return view('contents.project-management.area-management.area-list', compact('areas', 'project_id'));
}

    public function showAddAreaForm($project_id)
    {
        return view('contents.project-management.area-management.add-area', compact('project_id'));
    }

    public function updateFormArea($id)
    {
        $area = Area::findOrFail($id);
        return view('contents.project-management.area-management.update-area', compact('area'));
    }

    public function updateArea(Request $request,$id)
    {
        $request->validate([
            'areaName' => 'required',
            'areaDescription' => 'required|max:200',
        ]);
        
        $area = Area::findOrFail($id);

        Area::findOrFail($id)->update([
            'name' => $request->areaName,
            'description' => $request->areaDescription,
        ]);

        return redirect()->route('areas.index', $area->project_id);
    }

    public function deleteArea(Request $request)
    {
        $area = Area::findOrFail($request->id);
        $area->delete();

        return redirect()->route('areas.index', $area->project_id);
    }
}
