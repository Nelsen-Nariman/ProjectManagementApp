<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::paginate(10)->withQueryString();
        return view('suratPenting.manage', compact('files'));
    }

    public function addFile(Request $request)
    {

        $request->validate([
            'fileName' => 'required',
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
        ]);

        return redirect()->route('file.read');
    }

    public function updateFileForm($id){
        $file = File::findorFail($id);
        return view('suratPenting.updateForm', compact('file'));
    }

    public function updateFileLogic(Request $request, $id){

        $request->validate([
            'fileName' => 'required',
            'fileDescription' => 'required',
            'fileDoc' => 'required',
            'fileDoc.*' => 'file|mimes:doc,docx,pdf,xls,xlsx,ppt,pptx',
        ]);

        $suratPenting = $request->file('fileDoc');
        $name = $suratPenting->getClientOriginalName();
        $suratPentingName = now()->timestamp.'_'.$name;

        $suratPentingUrl = Storage::disk('public')->putFileAs('ListFile', $suratPenting, $suratPentingName);
        
        File::findOrFail($id)->update([
            'name' => $request->fileName,
            'description' => $request->fileDescription,
            'doc' => $suratPentingUrl,
        ]);

        return redirect()->route('file.read');
    }

    public function deleteFile(Request $request){
        $file = File::find($request->id);
        $suratPenting_path = public_path().'\storage/'.$file->doc;
        unlink($suratPenting_path);
        $file->delete();
        
        return redirect()->route('file.read');
    }
}
