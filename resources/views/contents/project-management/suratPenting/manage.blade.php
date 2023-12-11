@extends('layouts.app')

@section('title')
    Surat Penting
@endsection

@section('styling')
    
@endsection

{{-- Body --}}
@section('content')

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="mt-4">
        <a href="{{ route('project.detail', $project_id) }}" style=" text-decoration: none !important;
        color: white !important;">
            <button class="btn btn-secondary">
                Back
            </button>
        </a>
    </div>
</div>

<div class="heading" style="display: flex; justify-content: center; gap: 21.5rem; margin-top: 3rem;">
        <div class="btn1">
            <a href="{{ route('file.addForm', ['project_id' => $project_id]) }}" style="text-decoration: none !important;
            color: white !important;">
                <button style="background-color: black" type="button" class="btn btn-secondary">
                        Add File
                </button>
            </a>
        </div>
</div>


@foreach ($files as $file)
<div class="centering" style="display: flex; justify-content: center; margin-top: 1rem;">
    <div class="card mb-3" style="width: 740px;">
        <div class="row g-0">
          <div class="col-md-12">
            <div class="card-body">
                <div class="layouting" style="display: flex; justify-content: space-between;">
                    <h5 class="card-title">{{ $file->name }}</h5>
                    <div class="modified" style="display: flex; justify-content: space-evenly; gap: 1rem; padding-bottom: 20px">

                        <div class="download-btn" style="padding-right: 20px">
                            @if(file_exists(public_path().'\storage/'.$file->doc))
                                <a href="{{ asset('storage/'.$file->doc) }}">
                                    <button style="background-color: green" class="btn btn-success btn-sm" type="button">
                                        Download
                                    </button>
                                </a>
                            @else
                                <a href="{{ $file->doc }}">
                                    <button style="background-color: green" class="btn btn-success btn-sm" type="button">
                                        Download
                                    </button>
                                </a>
                            @endif
                        </div>

                        <div class="update-btn">
                            @if(auth()->user()->role === "worker")
                                @if($file->project->progress != 100 )
                                    <a href="{{ route('file.update', $file->id) }}" style="text-decoration: none !important;
                                        color: black !important;">
                                        <img src="/images/edit.png" width="25px">
                                    </a>
                                @endif

                            @else
                                <a href="{{ route('file.update', $file->id) }}" style="text-decoration: none !important;
                                    color: black !important;">
                                    <img src="/images/edit.png" width="25px">
                                </a>
                            @endif
                        </div>

                        <div class="delete-btn">
                            @if(auth()->user()->role === "worker")
                                @if($file->project->progress != 100 )
                                    <form action="{{ route('file.delete', ['id' => $file->id, 'area_id' => $file->project_id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button style="border: none; background-color: white;">
                                            <img src="/images/delete.png" width="25px">
                                        </button>  
                                    </form>
                                @endif
                            @else
                                <form action="{{ route('file.delete', ['id' => $file->id, 'area_id' => $file->project_id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="border: none; background-color: white;">
                                        <img src="/images/delete.png" width="25px">
                                    </button>  
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <p class="card-text">{{ $file->description }}</p>
            </div>
          </div>
        </div>
    </div>
</div>
@endforeach

<div style="margin: 2rem 0 0 0">
    {{$files->links()}}
</div>
    
@endsection