@extends('layouts.app')


@section('title')
    Project Lists
@endsection


@section('styling')
    <link rel="stylesheet" href="{{ asset('css/search-bar.css') }}">
@endsection


@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="parent-search justify-content-center align-items-center">
            <div class="search">
                <input type="text" id="search-input" class="form-control" placeholder="Which project is it?">
                <button id="search-button" class="btn btn-primary">Search</button>
            </div>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="">
                        @csrf
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Which project is it?</h1>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="number"
                                    class="form-control text-warning bg-transparent @error('rating') is-invalid @enderror"
                                    id="rating" placeholder="1 to 10" name="rating" min="1" max="10" value="{{ old('rating') }}">
                                <label class="text-primary" for="rating">Your rating</label>
                                @error('rating')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <textarea name="description" class="form-control text-warning bg-transparent @error('description') is-invalid @enderror" placeholder="Tell us more about the movie" id="floatingTextarea">{{ old('description') }}</textarea>
                                <label for="description" class="text-primary">Comment</label>

                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer border-0">
                            <button type="submit" class="w-100 btn btn-warning">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                {{ __("Ini Project List!") }}
            </div>
        </div>
    </div>
@endsection

@section('scripting')
    <script>
        document.getElementById('search-input').addEventListener('click', function () {
            const searchModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            searchModal.show();
        });
    </script>
@endsection