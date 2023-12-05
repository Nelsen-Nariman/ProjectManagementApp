@extends('layouts.app')


@section('title')
    Project Lists
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <nav style="margin-left: 20px; --bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('workers') }}">Worker List</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('worker.detail', $worker->id) }}">{{ $worker->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Assign project</li>
                </ol>
            </nav>

            <form action="{{ route('worker.assign',  ['user_id' => $worker->id]) }}" method="post">
                @csrf
                @foreach ($projects as $project)
                <div class="centering" style="display: flex; justify-content: center; margin-top: 1rem;">
                    <div class="card" style="width: 21rem;">
                        <div class="card-body">
                            <h5 id="card-title" class="card-title">{{ $project->name }}</h5>
                            <div class="card-brief-detail">
                                <p class="card-text"><i class="fas fa-map-marker-alt" style="padding-right: 7px; color: #8F8F8F"></i>  {{ $project->address }}</p>
                                <div class="progress" style="margin-top: 10px">
                                    <div class="progress-bar" role="progressbar" style="width: {{$project->progress}}%;" aria-valuenow="{{$project->progress}}" aria-valuemin="0" aria-valuemax="100">{{$project->progress}}%</div>
                                </div>
                                <input type="hidden" name="selected_projects">
                                <input type="checkbox" name="project_id[]" value="{{ $project->id }}" {{ is_array(session('selected_projects')) && in_array($project->id, session('selected_projects')) ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{ session('checked_projects_session') }}
                <div style="margin: 2rem 0">
                    {{ $projects->appends(['checked_projects_session' => session('checked_projects_session')])->links() }}
                </div>

                
                <button type="submit" style="background-color: blue; color:white" class="btn btn-outline-secondary mt-4">Add Selected Projects</button>
            </form>
        </div>
    </div>
@endsection

@section('scripting')
    <script>
    // Function to set session value
    function setSessionValue(key, value) {
        sessionStorage.setItem(key, value);
    }

    // Function to get session value by key
    function getSessionValue(key) {
        return sessionStorage.getItem(key);
    }

    // Checkboxes change event listener
    const checkboxes = document.querySelectorAll('input[name="project_id[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const projectId = this.value;
            let checkedProjects = (getSessionValue('checked_projects_session') || '').split(',').filter(Boolean); // Adjusted key for session
            if (this.checked) {
                if (!checkedProjects.includes(projectId)) {
                    checkedProjects.push(projectId);
                }
            } else {
                checkedProjects = checkedProjects.filter(id => id !== projectId);
            }
            setSessionValue('checked_projects_session', checkedProjects.join(',')); // Adjusted key for session
        });
    });

    // Restore checkbox state on page load
    document.addEventListener('DOMContentLoaded', function() {
        const checkedProjects = getSessionValue('checked_projects_session') || '';
        const checkedProjectsArray = checkedProjects.split(',');
        checkboxes.forEach(checkbox => {
            const projectId = checkbox.value;
            if (checkedProjectsArray.includes(projectId)) {
                checkbox.checked = true;
            }
        });
    });
    </script>
@endsection