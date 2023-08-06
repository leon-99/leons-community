@extends('layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}">
        Admin Dashboard
    </a>
@endsection

@section('title')
    <title>blog | {{ substr($article->title, 0, 20) }}</title>
@endsection


@section('content')
    <div class="container">
            <div class="card mb-2 border-0 shadow">
                <div class="card-body">
                    <div class="row d-flex justify-content-start">
                        <div class="col-3 col-sm-2 col-md-2 col-lg-1 text-center px-0">
                            <img src="{{ asset('storage/' . $article->user->profile) }}" alt=""
                                class="rounded-circle object-fit-cover" style="width: 40px; height: 40px">
                        </div>
                        <div class="col-9 col-sm-10 col-md-10 col-lg-11 ps-0">
                            <a href="{{ route('user.show', $article->user) }}" class="text-reset text-decoration-none"><b
                                    class="d-block">{{ $article->user->name }}</b></a>
                            <small>{{ $article->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <div class="card-subtitle mb-2 text-muted small">
                                <span>Category: <b>{{ $article->category->name }}</b></span>


                            </div>
                            <p class="card-text">
                                {{ $article->body }}
                            </p>
                        </div>
                        @if (isset($article->image))
                            <div class="col-md-6 d-flex justify-content-center align-items-start">
                                <img src="{{ asset('storage/' . $article->image) }}" class="img-thumbnail my-4 w-50">
                            </div>
                        @endif
                    </div>
                    <div class="my-4 d-flex">
                        <form action="{{ route('admin.article.destroy', $article->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm bg-rose-950 hover-bg-rose-800">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <ul class="list-group mt-3 shadow border-0">
                        <li class="list-group-item">
                            <b>Comments ({{ count($article->comments) }})</b>
                        </li>
                        @foreach ($article->comments->reverse() as $comment)
                            <li class="list-group-item">
                                <div class="row d-flex justify-content-start">
                                    <div
                                        class="col-3 col-sm-2 col-md-2 col-lg-1 text-center pe-0 d-flex justify-content-center align-items-start mt-2">
                                        <img src="{{ asset('storage/' . $comment->user->profile) }}" alt=""
                                            class="rounded-circle object-fit-cover" style="width: 30px; height: 30px">
                                    </div>
                                    <div class="col-9 col-sm-10 col-md-10 col-lg-11 ps-0">

                                        <a href="{{ route('user.show', $comment->user) }}"
                                            class="text-reset text-decoration-none"><b
                                                class="d-block">{{ $comment->user->name }}</b></a>
                                        <small>{{ $comment->created_at->diffForHumans() }}</small>
                                        @if ($comment->edited == 1)
                                            <small> | <span class="text-success">Edited</span></small>
                                        @endif
                                        <p class="mt-3">{{ $comment->content }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('admin.comment.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm bg-rose-950 hover-bg-rose-800 float-end mx-2"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
    </div>
@endsection
