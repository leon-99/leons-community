@extends('layouts.app')

@section('title')
    <title>blog | {{ $user->name }}</title>
@endsection

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
                        <div class="mt-1">Profile</div>
                    </div>

                    <div class="card-body text-center d-flex">
                        <div class="col-6"><img src="{{ asset('storage/' . $user->profile) }}" alt=""
                                class="rounded-circle object-fit-cover" style="width: 70px; height: 70px">
                        </div>
                        <div class="col-6">
                            <h5 class="mt-3">{{ $user->name }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-3">
                <div class="card border-0 shadow">
                    <div class="card-header">{{ __('Your Posts') }}</div>
                    <div class="card-body">
                        @unless (false)
                            @foreach ($user->article as $article)
                                <div class="card mb-2 border-0 shadow">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $article->title }}</h5>
                                        <div class="card-subtitle mb-2 text-muted small">
                                            {{ $article->created_at->diffForHumans() }}
                                            by <b>{{ $article->user->name }}</b>
                                        </div>
                                        <p class="card-text">{{ substr($article->body, 0, 200) . ' . . .' }}</p>
                                        <a class="card-link btn btn-sm btn-outline-success"
                                            href="{{ url("/articles/detail/$article->id") }}">
                                            View Detail <i class="fa fa-info"></i>
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
