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
                                    <a class="card-link" href="{{ url("/articles/detail/$article->id") }}">
                                        View Detail &raquo;
                                    </a>

                                    @auth
                                        @if ($article->user_id == auth()->user()->id)
                                            <a class="text-danger mx-3" href="{{ url("/articles/delete/$article->id?from=profile") }}">
                                                Delete Post
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
