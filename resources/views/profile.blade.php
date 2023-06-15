@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h5>{{ $name }}</h5>
                        <p>{{ $email }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">{{ __('Your Posts') }}</div>

                    <div class="card-body">
                        @foreach ($articles as $article)
                            <div class="card mb-2">
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

                                    @auth
                                        @if ($article->user_id == auth()->user()->id)
                                            <a class="text-danger mx-4 btn btn-sm btn-outline-danger"
                                                href="{{ url("/articles/delete/$article->id?from=profile") }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endif
                                    @endauth

                                        <a href="{{ url("/articles/edit/$article->id") }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-pencil-square"></i>
                                        </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
