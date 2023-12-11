
@extends('layouts.app')


@section('title')
    Area Lists
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
        <a href="{{ route('project.detail', $project_id) }}" style=" text-decoration: none !important;
        color: white !important;">
            <button class="btn btn-secondary">
                Back
            </button>
        </a>
    </div>


    @if (Auth::user()->role == "admin")
    <div class="heading" style="display: flex; justify-content: center; gap: 2rem; margin-top: 3rem;">
            <div class="btn1">
                <a href="{{ route('add.area', ['project_id' => $project_id]) }}" style="text-decoration: none !important;
                color: white !important;">
                    <button style="background-color: black" type="button" class="btn btn-secondary">
                            Add Area
                    </button>
                </a>
            </div>
        </div>
    @endif

    @foreach ($areas as $area)
            <div class="card" style="margin-top: 20px">
                <h2 class="card-header">{{ $area->name }}</h2>
                <div class="card-body">
                    <p class="card-text">{{ $area->description }}</p>
                    <div class="d-md-flex align-items-md-center" style="padding-top: 10px">
                        @if (Auth::user()->role == "admin")
                        <a href="{{ route('area.updateForm', $area->id) }}" class="btn btn-warning">Update</a>
                        <form action="{{ route('area.delete', $area->id) }}" method="POST" style="display: inline; margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="background-color:red!important; border-color:red; margin: 0 5px" onclick="return confirm('Are you sure you want to delete this area?')">Delete</button>
                        </form>
                        @endif
                        <a href="{{ route('documentation.read', ['area_id' => $area->id]) }}" class="btn btn-primary">Dokumentasi</a>
                    </div>
                </div>
            </div>
        @endforeach


</div>

@endsection