@extends('layouts.app')

@section('title')
    Add a Documentation
@endsection

@section('styling')
    
@endsection

{{-- Body --}}
@section('content')

    <div class="mt-4">
        <a href="{{ route('documentation.read', ['area_id' => $area_id]) }}" style=" text-decoration: none !important;
        color: white !important;">
            <button class="btn btn-secondary">
                Back
            </button>
        </a>
    </div>

    <div class="subtitle mt-4">
        <h5 style="background-color: rgb(210, 208, 208); padding-inline: 1rem; padding-block: 0.5rem; border-radius: 3px;">Add Documentation</h5> 
    </div>

    <form action="{{ route('documentation.create', ['area_id' => $area_id]) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="background">

                <div class="mb-3">
                    <label for="exampleInputName1" class="form-label">Name</label>
                    <input type="text" class="form-control @error('documentationName') is-invalid @enderror" id="exampleInputName1" aria-describedby="nameHelp" name="documentationName" value="{{ old('documentationName') }}">
                    @error('documentationName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control @error('documentationDescription') is-invalid @enderror" id="exampleFormControlTextarea1" rows="12" name="documentationDescription" value="{{ old('documentationDescription') }}"></textarea>
                    @error('documentationDescription')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control @error('documentationImage') is-invalid @enderror" type="file" id="formFile" name="documentationImage">
                    @error('documentationImage')
                    <div class="invalid-feedback">
                        {{ $message }} 
                    </div>
                @enderror
                </div>

                <button type="submit" class="btn btn-outline-secondary mt-4">Add</button>

        </div>
    </form>
    
@endsection