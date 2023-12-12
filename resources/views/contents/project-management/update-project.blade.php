@extends('layouts.app')


@section('title')
    Update Project
@endsection


@section('styling')
    
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

@section('content')




<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mt-4">
        <a href="{{ route('project.detail', $project->id) }}" style=" text-decoration: none !important;
        color: white !important;">
            <button class="btn btn-secondary">
                Back
            </button>
        </a>
    </div>

    <form action="{{ route('project.update', $project->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PATCH')
        <div class="background">
                <div class="mb-3">
                    <label for="projectName" class="form-label">Nama Project</label>
                    <input type="text" class="form-control @error('projectName') is-invalid @enderror" id="projectName" name="projectName" value="{{ old('projectName', $project->name )}}"></input>
                    @error('projectName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="projectDescription" class="form-label">Deskripsi</label>
                    <textarea type="text" class="form-control @error('projectDescription') is-invalid @enderror" id="projectDescription" name="projectDescription" value="{{ old('projectDescription') }}">{{ old('projectDescription' , $project->description)}}</textarea>
                    @error('projectDescription')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="projectAddress" class="form-label">Lokasi</label>
                    <input type="text" class="form-control @error('projectAddress') is-invalid @enderror" id="projectAddress" aria-describedby="nameHelp" name="projectAddress" value="{{ old('projectAddress', $project->address )}}"></input>
                    @error('projectAddress')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="projectDeadline" class="form-label">Deadline</label>
                    <input class="date form-control" type="text" value="{{ old('projectDeadline', $project->deadline )}}" name="projectDeadline"></input>
                    <script type="text/javascript">
                        $('.date').datepicker({  
                        format: 'dd-mm-yyyy'
                        });  
                    </script> 
                </div>



                <div class="mb-3">
                    <label for="projectPriority" class="form-label">Prioritas</label>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="projectPriority" id="projectPriority1" value="High" {{ $project->priority == 'High' ? 'checked' : '' }}></input>
                    <label class="form-check-label" for="projectPriority1">
                        High
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="projectPriority" id="projectPriority2" value="Mid" {{ $project->priority == 'Mid' ? 'checked' : '' }}></input>
                    <label class="form-check-label" for="projectPriority2">
                        Mid
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="projectPriority" id="projectPriority3" value="Low" {{ $project->priority == 'Low' ? 'checked' : '' }}></input>
                    <label class="form-check-label" for="projectPriority3">
                        Low
                    </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="projectProgress" class="form-label">Progress</label>
                    <input type="range" class="form-range" min="0" max="100" value="{{ old('projectProgress', $project->progress )}}" name="projectProgress">
                </div>


                <button type="submit" class="btn btn-outline-secondary mt-4">Update</button>

        </div>
    </form>
</div>
@endsection