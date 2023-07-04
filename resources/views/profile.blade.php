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
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body text-center d-flex">
                        <div class="col-6"><img src="{{asset('images/profile.png')}}" alt="" class="w-25"></div>
                        <div class="col-6">
                            <h5>{{ $name }}</h5>
                            <p>{{ $email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-3">
                <div class="card border-0 shadow">
                    <div class="card-header">{{ __('Your Posts') }}</div>

                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
