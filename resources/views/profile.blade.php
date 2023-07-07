@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-header d-flex">
                        <div class="mt-1">{{ __('Dashboard') }}</div>
                        <div class="ms-auto">
                            <a href="/user/edit/{{ $user->id }}"
                                class="profile-settings btn btn-outline-dark btn-sm">Update Profile <i
                                    class="fa fa-cog"></i></a>
                        </div>
                    </div>

                    <div class="card-body text-center d-flex">
                        <div class="col-6"><img src="{{ asset('storage/' . $user->profile) }}" alt=""
                                class="w-25 rounded-circle">
                        </div>
                        <div class="col-6">
                            <h5 class="mt-3">{{ $user->name }}</h5>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-3">
                <div class="card border-0 shadow">
                    <div class="card-header">{{ __('Your Posts') }}</div>

                    <div class="card-body">
                        @unless ($articles->count() == 0)
                            @foreach ($articles as $article)
                                <div class="card mb-2 border-0 shadow">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $article->title }}</h5>
                                        <div class="card-subtitle mb-2 text-muted small">
                                            {{ $article->created_at->diffForHumans() }}
                                            by <b>{{ $article->user->name }}</b>
                                        </div>
                                        <p class="card-text">{{ $article->body }}</p>
                                        <a class="card-link btn btn-sm btn-outline-success"
                                            href="{{ url("/articles/detail/$article->id") }}">
                                            View Detail <i class="fa fa-info"></i>
                                        </a>
                                        <a href="{{ url("/articles/edit/$article->id") }}"
                                            class="btn btn-sm btn-outline-success mx-2">
                                            <i class="fa fa-pencil-square"></i>
                                        </a>
                                        <a class="text-danger btn btn-sm btn-outline-danger"
                                            href="{{ url("/articles/delete/$article->id?from=profile") }}">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="card mb-2 border-0 shadow">
                                <div class="card-body">
                                    <p class="card-title">No posts found</p>
                                </div>
                            </div>
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
