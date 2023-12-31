@extends('layouts.app')


@section('title')
    Project Lists
@endsection


@section('styling')
    <link rel="stylesheet" href="{{ asset('css/search-bar.css') }}">
@endsection


@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Ini untuk search --}}
            <div class="parent-search justify-content-center align-items-center">
                <div class="search">
                    <i class="fa fa-search"></i>
                    @php
                        $placeValue = "Which project is it?";

                        if (isset($searchParams) == true) {
                            $placeValue = "Searched for ";

                            if ($searchParams['name'] != null) {
                                $placeValue = $placeValue . $searchParams['name'] . " keyword, ";
                            }

                            if ($searchParams['year'] != 1) {
                                $placeValue = $placeValue . $searchParams['year'] . ", ";
                            } else {
                                $placeValue = $placeValue . "any year, ";
                            }

                            if ($searchParams['priority'] != 1) {
                                $placeValue = $placeValue . strtolower($searchParams['priority']) . " priority, ";
                            } else {
                                $placeValue = $placeValue . "all priorities, ";
                            }

                            if ($searchParams['status'] != 1) {
                                $placeValue = $placeValue . $searchParams['status'] . " status";
                            } else {
                                $placeValue = $placeValue . "all statuses";
                            }
                            
                        }
                    @endphp
                    <input type="text" id="search-input" class="form-control" placeholder="{{ $placeValue }}">
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
                                    <select class="form-select" id="project-priority" name="priority" aria-label="Project's priority">
                                        <option value="1" {{ isset($searchParams['priority']) && $searchParams['priority'] == 1 ? 'selected' : '' }}>See all priorities!</option>
                                        <option value="High" {{ isset($searchParams['priority']) && $searchParams['priority'] == 'High' ? 'selected' : '' }}>High</option>
                                        <option value="Mid" {{ isset($searchParams['priority']) && $searchParams['priority'] == 'Mid' ? 'selected' : '' }}>Mid</option>
                                        <option value="Low" {{ isset($searchParams['priority']) && $searchParams['priority'] == 'Low' ? 'selected' : '' }}>Low</option>
                                    </select>
                                    <label class="text-primary" for="project-priority">Priority</label>
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

            @if (Auth::user()->role == "admin")
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
            @endif

            <div class="d-grid gap-2 d-md-block d-flex" style="padding-top: 20px; padding-left: 15px; margin-bottom: -20px">
                <a href="{{ route('sorting', ['typeSorting' => 'byProgress']) }}" class="btn btn-secondary" style="background-color: {{ $typeSorting === 'byProgress' ? '#8DA5EA' : '#fff' }}; color: {{ $typeSorting === 'byProgress' ? '#fff' : '#8F8F8F' }}; border: 1; border-color: #8F8F8F; border-radius: 20px;">Progress</a>
                <a href="{{ route('sorting', ['typeSorting' => 'byName']) }}" class="btn btn-secondary" style="background-color: {{ $typeSorting === 'byName' ? '#8DA5EA' : '#fff' }}; color: {{ $typeSorting === 'byName' ? '#fff' : '#8F8F8F' }}; border-color: #8F8F8F; border-radius: 20px;">A - Z</a>
            </div>

            @foreach ($projects as $project)
            <div class="centering" style="display: flex; justify-content: center; margin-top: 1rem;">
                <div class="card" style="margin-top: 20px; width: 21rem;">
                    <div class="card-body">
                        <h5 id="card-title" class="card-title"><b>{{ $project->name }}</b></h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt" style="padding-right: 7px; color: #8F8F8F"></i>  {{ $project->address }}</p>
                        <div class="progress" style="margin-top: 10px">
                            <div class="progress-bar" role="progressbar" style="width: {{$project->progress}}%; background-color: #8DA5EA;" aria-valuenow="{{$project->progress}}" aria-valuemin="0" aria-valuemax="100">{{$project->progress}}%</div>
                        </div>
                    </div>
                    <div class="card-header" style="background-color: #Fff; padding-bottom: 15px">
                        <div class="d-flex justify-content-between align-items-center">
                            @if ($project->priority == 'High')
                                <span class="priority-value" style="background-color: #FFD3D3; color: #000">{{ $project->priority }}</span>
                            @endif
                            @if ($project->priority == 'Mid')
                                <span class="priority-value" style="background-color: #FFEED3; color: #000">{{ $project->priority }}</span>
                            @endif
                            @if ($project->priority == 'Low')
                                <span class="priority-value" style="background-color: #D7F5DF; color: #000">{{ $project->priority }}</span>
                            @endif
                            <button onclick="window.location='{{ route('project.detail', $project->id) }}'" class="btn btn-primary" style="background-color: #8DA5EA; border: none; border-radius: 20px">
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach

            <div style="margin: 2rem 0 0 0">
                {{ $projects->links() }}
            </div>
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