@extends('layouts.app')


@section('title')
    Project Lists
@endsection


@section('styling')
    <link rel="stylesheet" href="{{ asset('css/search-bar.css') }}">
@endsection


@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- Ini untuk search --}}
        <div class="parent-search justify-content-center align-items-center">
            <div class="search">
                <input type="text" id="search-input" class="form-control" placeholder="Which project is it?">
                <button id="search-button" class="btn btn-primary">Search</button>
            </div>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Which project is it?</h1>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        
                    <form action="{{ route('projects.search') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control bg-transparent"
                                    id="project-name" placeholder="Project's Name" name="name" value="{{ isset($searchParams['name']) ? $searchParams['name'] : '' }}">
                                <label class="text-primary" for="project-name">Project Name</label>
                            </div>

                            {{-- For current year --}}
                            @php
                                $currentYear = strftime("%Y", time());
                            @endphp

                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect" name="year" aria-label="Floating label select example">
                                    <option value="1" {{ isset($searchParams['year']) && $searchParams['year'] == 1 ? 'selected' : '' }}>Any year is okay!</option>
                                    @for ($year = 2022; $year <= $currentYear; $year++)
                                        <option value="{{ $year }}" {{ isset($searchParams['year']) && $searchParams['year'] == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                                <label class="text-primary" for="floatingSelect">Creation Year</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" id="project-status" name="status" aria-label="Project's status">
                                    <option value="1" {{ isset($searchParams['status']) && $searchParams['status'] == 1 ? 'selected' : '' }}>See all statuses!</option>
                                    <option value="on progress" {{ isset($searchParams['status']) && $searchParams['status'] == 'on progress' ? 'selected' : '' }}>On Progress</option>
                                    <option value="completed" {{ isset($searchParams['status']) && $searchParams['status'] == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <label class="text-primary" for="project-status">Current Status</label>
                            </div>
                        </div>

                        <div class="modal-footer border-0">
                            <button type="submit" class="w-100 btn btn-primary submit-search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if (session()->has("errorSearch"))
            <div class="alert alert-danger" id="error" role="alert">
                {{ session()->get("errorSearch") }}
            </div>
        @endif

        {{-- Di bawah ini untuk project --}}

        <div class="heading" style="display: flex; justify-content: center; gap: 2rem; margin-top: 3rem;">
            <div class="btn1">
                <a href="{{ route('add.project') }}" style="text-decoration: none !important;
                color: white !important;">
                    <button style="background-color: black" type="button" class="btn btn-secondary">
                            Add Project
                    </button>
                </a>
            </div>
        </div>

        <div class="d-grid gap-2 d-md-block" style="padding-top: 10px">
            <a href="{{ route('sorting', ['typeSorting' => 'byProgress']) }}" class="btn btn-primary" style="background-color: #D2B832; border: none">Progress</a>
            <a href="{{ route('sorting', ['typeSorting' => 'byName']) }}" class="btn btn-primary">A - Z</a>
        </div>

        @foreach ($projects as $project)
            <div class="card" style="margin-top: 20px">
                <div class="card-body">
                    <h5 class="card-title">{{ $project->name }}</h5>

                    <p class="card-text"><i class="fas fa-map-marker-alt" style="padding-right: 7px; color: #8F8F8F"></i>  {{ $project->address }}</p>
                    <div class="progress" style="margin-top: 10px">
                        <div class="progress-bar" role="progressbar" style="width: {{$project->progress}}%;" aria-valuenow="{{$project->progress}}" aria-valuemin="0" aria-valuemax="100">{{$project->progress}}%</div>
                    </div>
                    <div class="d-grid gap-2 d-md-block" style="padding-top: 10px">
                        <a href="{{ route('project.updateForm', $project->id) }}" class="btn btn-primary" style="background-color: #D2B832; border: none">Update</a>
                        <a href="{{ route('areas.index', ['project_id' => $project->id]) }}" class="btn btn-primary">Dokumentasi</a>
                        <a href="{{ route('file.read', ['project_id' => $project->id]) }}" class="btn btn-primary">Surat Penting</a>
                    </div>
                </div>
            </div>
        @endforeach

        <div style="margin: 2rem 0">
            {{ $projects->links() }}
        </div>
    </div>
@endsection


@section('scripting')
    <script>
        var alert = document.getElementById('error');

        setTimeout(function() {
            alert.style.display = 'none';
        }, 5000);

        document.getElementById('search-input').addEventListener('click', function () {
            const searchModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            searchModal.show();
        });
    </script>
@endsection