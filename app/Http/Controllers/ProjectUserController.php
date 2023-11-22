<?php

namespace App\Http\Controllers;

use App\Models\Project_User;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function addProjectUser($project_id, $user_id)
    {
        $projectUser['project_id'] = $project_id;
        $projectUser['user_id'] = $user_id;


        Project_User::create($projectUser);

        return redirect()->route('projectUser.read');
    }

    // public function updateProjectUser(Request $request, $project_id, $user_id)
    // {
    //     $request->validate([
    //         'user_id' => 'required',
    //     ]);
        
    //     ProjectUser::findOrFail($id)->update([
    //         'user_id' => $request->user_id,
    //     ]);

    //     return redirect()->route('projectUser.read');
    // }

    public function deleteProjectUser(Request $request)
    {
        $projectUser = Project_User::findOrFail($request->id);
        $projectUser->delete();

        return redirect()->route('projectUser.read');
        
    }
}
