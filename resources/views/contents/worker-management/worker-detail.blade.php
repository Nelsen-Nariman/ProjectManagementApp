@extends('layouts.app')


@section('title')
    {{ $worker->name }}'s profile
@endsection


@section('styling')
    <link rel="stylesheet" href="{{ asset('css/workers.css') }}">
@endsection


@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div>
                <a href="{{ route('workers') }}" style=" text-decoration: none !important;
                color: white !important;">
                    <button class="btn btn-secondary">
                        Back
                    </button>
                </a>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Worker\'s Profile') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Here is your worker\'s profile detail') }}
                        </p>
                    </header>
                    <div class="profile-detail">
                        <div class="row detail-data">
                            <div class="col-4">Name</div>
                            <div class="col">: {{ $worker->name }}</div>
                        </div>
                        <div class="row detail-data">
                            <div class="col-4">Email</div>
                            <div class="col">
                                : {{ $worker->email }}
                                <div class="{{ ($worker->email_verified_at != null) ? 'text-success' : 'text-danger' }}">
                                    {{ ($worker->email_verified_at != null) ? '(Verified)' : '(Not Verified)' }}
                                </div>
                            </div>
                        </div>
                        <div class="row detail-data">
                            <div class="col-4">Address</div>
                            <div class="col">: {{ $worker->address }}</div>
                        </div>
                        <div class="row detail-data">
                            <div class="col-4">Gender</div>

                            @php
                                $gender = $worker->gender;
                                if ($gender == null) {
                                    $gender = "Not yet specified";
                                }
                            @endphp
                            <div class="col">: {{ $gender }}</div>
                        </div>
                        <div class="row detail-data">
                            <div class="col-4">Join Date</div>
                            <div class="col">
                                : {{ $worker->created_at->toDateString() }}                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Project list') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Project that this worker handles') }}
                        </p>
                    </header>
                    <ul style="list-style-type: disc; padding-left: 15px; padding-top:20px">
                    @foreach ($worker->projects as $project)
                        <li class="project-item" style="padding-bottom: 5px; display: flex; align-items: center;">
                            <span class="project-name" style="flex: 1; margin-right: 10px;">{{ $project->name }}</span>
                            <form action="{{ route('projectUser.delete',['user_id' => $worker->id, 'project_id' => $project->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button" style="color: grey; border: none; background: none; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this project?')">
                                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
                    </ul>
                    <a href="{{ route('worker.assignForm', ['user_id' => $worker->id]) }}" class="w-30 btn btn-primary detail-button">Add more project</a>
                    
                </div>
            </div>



            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Delete Account') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once this account is deleted, all of its resources and data will be permanently deleted. Please reconsider your action.') }}
                            </p>
                        </header>
                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        >{{ __('Delete Account') }}</x-danger-button>

                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('worker.destroy', $worker) }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Are you sure you want to delete this account?') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Please enter your password to confirm you would like to permanently delete this account.') }}
                                </p>

                                <div class="mt-6">
                                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                                    <x-text-input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="mt-1 block w-3/4"
                                        placeholder="{{ __('Password') }}"
                                    />

                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ml-3">
                                        {{ __('Delete Account') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripting')
    <script>
    function removeSessionValue(key) {
        return sessionStorage.removeItem(key);
    }

    document.addEventListener('DOMContentLoaded', function() {
        removeSessionValue('checked_projects_session');
    });
    </script>
@endsection