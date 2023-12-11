@extends('layouts.app')


@section('title')
    Project Lists
@endsection


@section('styling')
    <link rel="stylesheet" href="{{ asset('css/search-bar.css') }}">
@endsection


@section('content')

{{-- Di bawah ini untuk project --}}
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mt-4">
        <a href="{{ route('projects') }}" style=" text-decoration: none !important;
        color: white !important;">
            <button class="btn btn-secondary">
                Back
            </button>
        </a>
    </div>
    <div class="card" style="margin-top: 20px">
        <div class="card-body">
            <h5 class="card-title" style="font-size: 20px"><b>{{ $project->name }}</b></h5>
            <p class="mt-1 text-sm text-gray-600" style="padding-bottom: 15px">{{ $project->description }}</p>
            <p class="card-text"><i class="fas fa-map-marker-alt" style="padding-right: 7px; color: #8F8F8F"></i>  {{ $project->address }}</p>
            <div class="progress" style="margin-top: 10px">
                <div class="progress-bar" role="progressbar" style="width: {{$project->progress}}%;" aria-valuenow="{{$project->progress}}" aria-valuemin="0" aria-valuemax="100">{{$project->progress}}%</div>
            </div>

            @if (Auth::user()->role == "admin")
            <div class="d-md-flex align-items-md-center" style="padding-top: 10px">
                <form action="{{ route('project.delete', $project->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="background-color:red!important;" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                </form>
            <a href="{{ route('project.updateForm', $project->id) }}" class="w-30 btn btn-warning detail-button" style="margin: 5px;">Update</a>

            </div>
            @endif
        </div>
    </div>

    <div class="card" style="margin-top: 20px">
        <div class="card-body">
            <h5 class="card-title" style="font-size: 20px"><b>Resource Hub</b></h5>
            <p class="mt-1 text-sm text-gray-600" style="padding-bottom: 15px">Contains area documentations and important files regarding this project</p>
            <div class="d-md-flex align-items-md-center" style="padding-top: 10px">
                <a href="{{ route('areas.index', ['project_id' => $project->id]) }}" class="w-30 btn btn-primary detail-button">Area</a>
                <a href="{{ route('file.read', ['project_id' => $project->id]) }}" class="w-30 btn btn-primary detail-button" style="margin: 5px;">Important file</a>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 20px">
        <div class="card-body">
            <h5 class="card-title" style="font-size: 20px"><b>Worker</b></h5>
            <p class="mt-1 text-sm text-gray-600" style="padding-bottom: 15px">Workers involved in this project</p>
            <ul style="list-style-type: disc; padding-left: 15px;">
                @foreach ($project->users as $user)
                    <li class="project-item" style="padding-bottom: 5px; display: flex; align-items: center;">
                        <span class="project-name" style="flex: 1; margin-right: 10px;">{{ $user->name }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
@endsection