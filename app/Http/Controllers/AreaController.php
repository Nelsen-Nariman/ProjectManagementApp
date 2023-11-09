<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller{
    public function addArea(Request $request, $project_id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required|max:200',
        ]);

        $areaInput = $request->all();
        $areaInput['project_id'] = $project_id;

        Area::create($areaInput);

        return redirect()->route('area.read');
    }

    public function updateFormArea($id)
    {
        $area = Area::findOrFail($id);
        return view('area.updateForm', compact('area'));
    }

    public function updateArea($id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required|max:200',
        ]);
        
        Project::findOrFail($id)->update([
            'name' => $request->projectName,
            'description' => $request->projectDescription,
        ]);

        return redirect()->route('area.read');
    }

    public function deleteArea(Request $request)
    {
        $area = Area::findOrFail($request->id);
        $area->delete();

        return redirect()->route('area.read');
    }
}
