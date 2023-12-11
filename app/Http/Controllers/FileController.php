<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FileController extends Controller
{
    public function index($project_id)
    {
        $project = Project::findOrFail($project_id);
        $files = $project->files()->paginate(10);
        return view('contents.project-management.suratPenting.manage', compact('files', 'project_id'));
    }

    public function addFile(Request $request, $project_id)
    {

        $request->validate([
            'fileName' => [
                'required',
                'unique:files,name',
                Rule::unique('files', 'name')
            ],
            'fileDescription' => 'required|max:200',
            'fileDoc' => 'required',
            'fileDoc.*' => 'file|mimes:doc,docx,pdf,xls,xlsx,ppt,pptx',
        ]);

        $suratPenting = $request->file('fileDoc');
        $name = $suratPenting->getClientOriginalName();
        $suratPentingName = now()->timestamp.'_'.$name;

        $suratPentingUrl = Storage::disk('public')->putFileAs('ListFile', $suratPenting, $suratPentingName);

        File::create([
            'name' => $request->fileName,
            'description' => $request->fileDescription,
            'doc' => $suratPentingUrl,
            'project_id' => $project_id,
        ]);

        return redirect()->route('file.read', $project_id);
    }

    public function showAddFileForm($project_id)
    {
        return view('contents.project-management.suratPenting.addForm', compact('project_id'));
    }

    public function updateFileForm($id){
        $file = File::findorFail($id);
        return view('contents.project-management.suratPenting.updateForm', compact('file'));
    }

    public function updateFileLogic(Request $request, $id)
    {
        $request->validate([
            'fileName' => [
                'required',
                Rule::unique('files', 'name')->ignore($id),
            ],
            'fileDescription' => 'required|max:200',
            'fileDoc' => 'required',
            'fileDoc.*' => 'file|mimes:doc,docx,pdf,xls,xlsx,ppt,pptx',
        ]);

        $suratPenting = $request->file('fileDoc');
        $name = $suratPenting->getClientOriginalName();
        $suratPentingName = now()->timestamp . '_' . $name;

        $suratPentingUrl = Storage::disk('public')->putFileAs('ListFile', $suratPenting, $suratPentingName);

        $file = File::findOrFail($id);

        $file->update([
            'name' => $request->input('fileName'),
            'description' => $request->input('fileDescription'),
            'doc' => $suratPentingUrl,
        ]);

        return redirect()->route('file.read', $file->project_id);
    }


    public function deleteFile(Request $request){
        $file = File::find($request->id);
        $suratPenting_path = public_path().'\storage/'.$file->doc;
        unlink($suratPenting_path);
        $file->delete();

        return redirect()->route('file.read', ['project_id' => $file->project_id]);
    }
}
