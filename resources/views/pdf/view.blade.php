@extends('template.layout')

@section('title')
    PDF View
@endsection

@section('styling')
    
@endsection

{{-- Body --}}
@section('content')


{{-- <div class="heading" style="display: flex; justify-content: center; gap: 21.5rem; margin-top: 3rem;">
        <div class="btn1">
            <a href="{{ route('documentation.addForm') }}" style="text-decoration: none !important;
            color: white !important;">
                <button type="button" class="btn btn-secondary">
                        Add Documentation
                </button>
            </a>
        </div>
</div> --}}


@foreach ($documentations as $documentation)
<div class="centering" style="display: flex; justify-content: center; margin-top: 1rem;">
    <div class="card mb-3" style="width: 740px;">
        <div class="row g-0">
          <div class="col-md-3">
            @if(file_exists(public_path().'\storage/'.$documentation->image))
                <img src="{{ asset('storage/'.$documentation->image) }}" class="card-img-top" alt="documentation name's image" style="height: 180px; object-fit: cover">
            @else
                <img src="{{ $documentation->image }}" class="img-fluid rounded-start" alt="..." style="height: 180px; object-fit: contain">
            @endif

          </div>
          <div class="col-md-9">
            <div class="card-body">
                <div class="layouting" style="display: flex; justify-content: space-between;">
                    <h5 class="card-title">{{ $documentation->name }}</h5>
                    {{-- <div class="modified" style="display: flex; justify-content: space-evenly; gap: 1rem; padding-bottom: 20px">
                        <a href="{{ route('documentation.update', $documentation->id) }}" style="text-decoration: none !important;
                            color: black !important;">
                            <img src="/images/edit.png" width="25px">
                        </a>
                        <form action="{{ route('documentation.delete', $documentation->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button style="border: none; background-color: white;">
                                <img src="/images/delete.png" width="25px">
                            </button>  
                        </form>
                    </div> --}}
                </div>
                <p class="card-text">{{ $documentation->description }}</p>
            </div>
          </div>
        </div>
    </div>
</div>
@endforeach

<div style="margin: 2rem 0">
    {{$documentations->links()}}
</div>
    
@endsection