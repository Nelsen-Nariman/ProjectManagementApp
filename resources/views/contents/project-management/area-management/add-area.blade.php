@extends('layouts.app')


@section('title')
    Add an Area
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
        <a href="{{ route('areas.index', ['project_id' => $project_id]) }}" style=" text-decoration: none !important;
        color: white !important;">
            <button class="btn btn-secondary">
                Back
            </button>
        </a>
    </div>

    <form action="{{ route('area.create', ['project_id' => $project_id])}}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="background">

                <div class="mb-3">
                    <label for="areaName" class="form-label">Nama Area</label>
                    <input type="text" class="form-control @error('areaName') is-invalid @enderror" id="areaName" name="areaName" value="{{ old('areaName') }}"></input>
                    @error('areaName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="areaDescription" class="form-label">Deskripsi</label>
                    <textarea type="text" class="form-control @error('areaDescription') is-invalid @enderror" id="areaDescription" name="areaDescription" value="{{ old('areaDescription') }}"></textarea>
                    @error('areaDescription')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-outline-secondary mt-4">Add</button>
        </div>
    </form>
</div>
@endsection