@extends('template.layout')

@section('title')
    updateForm
@endsection

@section('styling')
    
@endsection

{{-- Body --}}
@section('content')

    <div class="back-btn" style="padding-left: 16rem; margin-top: 3rem;">
        <a href="{{ route('documentation.read') }}" style=" text-decoration: none !important;
        color: white !important;">
        <button class="btn btn-secondary">
            Back
        </button>
        </a>
    </div>

    <div class="subtitle" style="padding-inline: 16rem; margin-top: 1rem">
        <h5 style="background-color: rgb(210, 208, 208); padding-inline: 1rem; padding-block: 0.5rem; border-radius: 3px;">Update Documentation</h5> 
    </div>

    <form action="{{ route('documentation.updating', $documentation->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PATCH')
        <div class="background" style="padding-inline: 16rem; padding-bottom: 2rem;">
            <div class="border" style="padding-inline: 1rem; padding-block: 0.5rem; border: 2px solid; border-radius: 3px;">
                
                <div class="mb-3">
                    <label for="exampleInputName1" class="form-label">Name</label>
                    <input type="text" class="form-control @error('documentationName') is-invalid @enderror" id="exampleInputName1" aria-describedby="nameHelp" name="documentationName" value="{{old('documentationName', $documentation->name)}}">
                    @error('documentationName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                    <textarea class="form-control @error('documentationDescription') is-invalid @enderror" id="exampleFormControlTextarea1" rows="12" name="documentationDescription">{{old('documentationDescription', $documentation->description)}}</textarea>
                    @error('documentationDescription')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control @error('documentationImage') is-invalid @enderror" type="file" id="formFile" name="documentationImage" value="{{old('documentationImage', $documentation->image)}}">
                    @error('documentationImage')
                    <div class="invalid-feedback">
                        {{ $message }} 
                    </div>
                @enderror
                </div>

                <button type="submit" class="btn btn-outline-secondary mt-4">Update</button>

            </div>
        </div>
    </form>
    
@endsection