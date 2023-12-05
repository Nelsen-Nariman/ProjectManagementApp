<?php

namespace App\Http\Controllers;

use App\Models\ProjectUser;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;


class ProjectUserController extends Controller
{
    public function index($user_id, Request $request)
    {
        $user = User::findOrFail($user_id);

        // Fetch projects that the user does not have
        // $projects = Project::whereNotIn('id', $user->projects()->pluck('projects.id'));
        $projectIdsFromSession = $request->session()->get('checked_projects', []);

        // Fetch projects that the user does not have
        $projects = Project::whereNotIn('id', $user->projects()->pluck('projects.id'))
            ->paginate(10);

        // $projects = $projects->paginate(10)->withQueryString();

        $data = [
            'projects' => $projects,
            'worker' => $user,
            'projectIdsFromSession' => $projectIdsFromSession,
        ];

        return view('contents.worker-management.worker-project.worker-project-assign', $data);
    }

    public function store(Request $request)
{
    // Store the selected project IDs in the session
    
    $selectedProjects = $request->input('project_id', []);
    $request->session()->put('selected_projects', $selectedProjects);

    // Further processing or redirection after form submission
}

    public function updateCheckedProjectsSession(Request $request)
    {
        $checkedProjects = $request->input('selected_projects');
        session(['selected_projects' => $checkedProjects]);
    }

    public function create(Request $request ,$user_id)
    {
        // $selectedProjects = $request->input('project_id', []);
        $selectedProjects = session("selected_projects");
    
        // Update the session with the selected projects
        session(['selected_projects' => $selectedProjects]);
        
        $projectIds = $request->input('project_id');

        // Loop through each project_id and create a user project
        foreach ($projectIds as $projectId) {
            $userProject = new ProjectUser();
            $userProject->user_id = $user_id;
            $userProject->project_id = $projectId;
            $userProject->save();
        }

        return redirect()->route('worker.detail', $user_id);
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

    public function delete($user_id, $project_id)
    {
        $user = User::findOrFail($user_id);

        // Find the project belonging to the user
        $user->projects()->detach($project_id);

        return redirect()->route('worker.detail', $user_id);
        
    }
}
