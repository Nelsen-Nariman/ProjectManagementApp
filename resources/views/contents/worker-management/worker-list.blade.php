@extends('layouts.app')


@section('title')
    Worker Lists
@endsection


@section('styling')
    <link rel="stylesheet" href="{{ asset('css/workers.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search-bar.css') }}">
@endsection


@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="parent-search justify-content-center align-items-center">
                <form action="{{ route('workers.search') }}">
                    <div class="search">
                        <i class="fa fa-search"></i>
                        <input type="text" id="search-input" name="search" class="form-control" placeholder="Who are you searching for?" value="{{ isset($searchParam) ? $searchParam : '' }}">
                    </div>
                </form>
            </div>

            @if (session()->has("errorSearch"))
                <div class="alert alert-danger" id="error" role="alert">
                    {{ session()->get("errorSearch") }}
                </div>
            @endif
            @foreach ($workers as $worker)
                <div class="centering" style="display: flex; justify-content: center; margin-top: 1rem;">
                    <div class="card" style="width: 21rem;">
                        <div class="card-body">
                            @php
                                $name = $worker->name;

                                if (strlen($worker->name) > 35) {
                                    $name = substr($name, 0, 35) . "...";
                                }
                            @endphp
                            <h5 id="card-title" class="card-title">{{ $name }}</h5>
                            <div class="card-brief-detail">
                                <img src="/images/mail.png" width="23px">
                                @php
                                    $mail = $worker->email;

                                    if (strlen($worker->email) > 35) {
                                        $mail = substr($mail, 0, 35) . "...";
                                    }
                                @endphp
                                <p class="card-text">{{ $mail }}</p>
                            </div>
                            <div class="card-brief-detail">
                                <img src="/images/location.png" width="23px">
                                @php
                                    $address = $worker->address;

                                    if (strlen($worker->address) > 35) {
                                        $address = substr($address, 0, 35) . "...";
                                    }
                                @endphp
                                <p class="card-text">{{ $address }}</p>
                            </div>
                            <a href="{{ route('worker.detail', $worker->id) }}" class="w-100 btn btn-primary detail-button">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div style="margin: 2rem 0 0 0">
                {{$workers->links()}}
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
    </script>
@endsection