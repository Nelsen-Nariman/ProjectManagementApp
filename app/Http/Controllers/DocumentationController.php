<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DocumentationController extends Controller
{
    public function index($area_id)
    {
        $area = Area::findOrFail($area_id);
        $documentations = $area->documentations()->paginate(10);
        return view('contents.project-management.area-management.documentation.manage', compact('documentations', 'area_id'));
    }

    public function addDocumentation(Request $request, $area_id)
    {

        $request->validate([
            'documentationName' => [
                'required',
                'unique:documentations,name',
                Rule::unique('documentations', 'name')
            ],
            'documentationDescription' => 'required|max:200',
            'documentationImage' => 'required',
            'documentationImage.*' => 'file|mimes:jpg,png,jpeg',
        ]);

        $file = $request->file('documentationImage');
        $name = $file->getClientOriginalName();
        $filename = now()->timestamp.'_'.$name;

        $imageUrl = Storage::disk('public')->putFileAs('ListImage', $file, $filename);

        Documentation::create([
            'name' => $request->documentationName,
            'description' => $request->documentationDescription,
            'image' => $imageUrl,
            'area_id' => $area_id,
        ]);

        return redirect()->route('documentation.read', $area_id);
    }

    public function showAddDocumentationForm($area_id)
    {
        return view('contents.project-management.area-management.documentation.addForm', compact('area_id'));
    }

    public function updateDocumentationForm($id){
        $documentation = Documentation::findorFail($id);
        return view('contents.project-management.area-management.documentation.updateForm', compact('documentation'));
    }

    public function updateDocumentationLogic(Request $request, $id){

        $request->validate([
            'documentationName' => 'required',
            'documentationDescription' => 'required',
            'documentationImage' => 'required',
            'documentationImage.*' => 'file|mimes:jpg,png,jpeg',
        ]);

        $file = $request->file('documentationImage');
        $name = $file->getClientOriginalName();
        $filename = now()->timestamp.'_'.$name;

        $imageUrl = Storage::disk('public')->putFileAs('ListImage', $file, $filename);
        
        $documentation = Documentation::findorFail($id);

        Documentation::findOrFail($id)->update([
            'name' => $request->documentationName,
            'description' => $request->documentationDescription,
            'image' => $imageUrl,
        ]);

        return redirect()->route('documentation.read', $documentation->area_id);
    }

    public function deleteDocumentation(Request $request){
        $documentation = Documentation::find($request->id);
        $image_path = public_path().'\storage/'.$documentation->image;
        unlink($image_path);
        $documentation->delete();

        return redirect()->route('documentation.read', ['area_id' => $documentation->area_id]);
        
    }
}
