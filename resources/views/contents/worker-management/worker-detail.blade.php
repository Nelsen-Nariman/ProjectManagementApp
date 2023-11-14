@extends('layouts.app')


@section('title')
    Project Lists
@endsection


@section('styling')
    <link rel="stylesheet" href="{{ asset('css/workers.css') }}">
@endsection


@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <nav style="margin-left: 20px; --bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('workers') }}">Worker List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $worker->name }}</li>
                </ol>
            </nav>
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
                            <div class="col">: {{ $worker->email }}</div>
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
                            <div class="col">: {{ $worker->created_at->toDateString() }}</div>
                        </div>
                    </div>
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