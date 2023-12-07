@extends('layouts.app')

@section('title')
    Add Surat Penting
@endsection

@section('styling')
    
@endsection

{{-- Body --}}
@section('content')


    <div class="mt-4">
        <a href="{{ route('file.read', ['project_id' => $project_id]) }}" style=" text-decoration: none !important;
        color: white !important;">
            <button class="btn btn-secondary">
                Back
            </button>
        </a>
    </div>

    <div class="subtitle mt-4">
        <h5 style="background-color: rgb(210, 208, 208); padding-inline: 1rem; padding-block: 0.5rem; border-radius: 3px;">Add File</h5> 
    </div>

    <form action="{{ route('file.create', ['project_id' => $project_id]) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="background">
                
                <div class="mb-3">
                    <label for="exampleInputName1" class="form-label">Name</label>
                    <input type="text" class="form-control @error('fileName') is-invalid @enderror" id="exampleInputName1" aria-describedby="nameHelp" name="fileName" value="{{ old('fileName') }}">
                    @error('fileName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control @error('fileDescription') is-invalid @enderror" id="exampleFormControlTextarea1" rows="12" name="fileDescription" value="{{ old('fileDescription') }}"></textarea>
                    @error('fileDescription')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">File</label>
                    <input class="form-control @error('fileDoc') is-invalid @enderror" type="file" id="formFile" name="fileDoc">
                    @error('fileDoc')
                    <div class="invalid-feedback">
                        {{ $message }} 
                    </div>
                @enderror
                </div>

                <button type="submit" class="btn btn-outline-secondary mt-4">Add</button>

        </div>
    </form>
    
@endsection