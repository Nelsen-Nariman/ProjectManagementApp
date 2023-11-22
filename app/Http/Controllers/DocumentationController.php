<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentationController extends Controller
{
    public function index()
    {
        $documentations = Documentation::paginate(10)->withQueryString();
        return view('documentation.manage', compact('documentations'));
    }

    public function addDocumentation(Request $request)
    {

        $request->validate([
            'documentationName' => 'required',
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
        ]);

        return redirect()->route('documentation.read');
    }

    public function updateDocumentationForm($id){
        $documentation = Documentation::findorFail($id);
        return view('documentation.updateForm', compact('documentation'));
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
        
        Documentation::findOrFail($id)->update([
            'name' => $request->documentationName,
            'description' => $request->documentationDescription,
            'image' => $imageUrl,
        ]);

        return redirect()->route('documentation.read');
    }

    public function deleteDocumentation(Request $request){
        $documentation = Documentation::find($request->id);
        $documentation->delete();
        
        return redirect()->route('documentation.read');
    }
}
