<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {
        $workers = User::where("role", "like", "worker")->paginate(10)->withQueryString();

        $data = [
            'workers' => $workers
        ];

        return view('contents.worker-management.worker-list', $data);
    }

    public function search(Request $request)
    {
        $query = User::query();
        $query->where("name", "like", "%$request->search%");
        $query->orWhere("email", "like", "%$request->search%");
        $query->orWhere("address", "like", "%$request->search%");
        $query->where("role", "like", "worker");

        $preWorker = $query->paginate(10);
        $workers = $preWorker->appends($request->query());

        if ($workers->isEmpty()) {
            return redirect("workers")->with('errorSearch', 'There\'s no one as you mentioned before :(');
        } else {
            $data = [
                'workers' => $workers,
                'searchParam' => $request->search
            ];

            return view('contents.worker-management.worker-list', $data);
        }
    }

    public function show($user_id)
    {
        $worker = User::findOrFail($user_id);

        session()->forget("selected_projects");
        $selectedProjects = session('selected_projects', []);

        // Additional logic to fetch or process selected projects goes here
    
        // Save the selected projects array in the session
    

        $data = [
            'worker' => $worker,
            'selectedProjects' => $selectedProjects,
        ];

        return view('contents.worker-management.worker-detail', $data);
    }

    public function destroy(Request $request, $user_id): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = User::findOrFail($user_id);
        $user->delete();

        return Redirect::to('/workers');
    }
}
