@extends('layouts.app')
@section('title')
    <title>Blog | Home</title>
@endsection
@section('content')
    <div class="container">
        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        @if (session('article-delete-success'))
            <div class="alert alert-success">
                An article deleted.
            </div>
        @endif


        <div class="row d-md-none d-lg-none">
            <form class="pb-3 bt-2" action="{{ route('article.search') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <input type="text" name="phrase" class="form-control form-control-sm" placeholder="Search">
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-sm bg-slate-950 hover-bg-slate-800" value="Search">
                    </div>
                </div>
            </form>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-9 col-sm-12">
                @foreach ($articles as $article)
                    <div class="card mb-2 border-0 shadow">
                        <div class="card-body">
                            <div class="row d-flex justify-content-start">
                                <div class="col-3 col-sm-2 col-md-2 col-lg-1 text-center pe-0">
                                    <img src="{{ asset('storage/' . $article->user->profile) }}" alt=""
                                        class="rounded-circle object-fit-cover" style="width: 40px; height: 40px">
                                </div>
                                <div class="col-9 col-sm-10 col-md-10 col-lg-11 ps-0">
                                    <a href="{{ route('user.show', $article->user) }}"
                                        class="text-reset text-decoration-none"><b
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
                                        {{ substr($article->body, 0, 200) . ' . . .' }}
                                    </p>
                                </div>
                                @if (isset($article->image))
                                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('storage/' . $article->image) }}"
                                            class="img-thumbnail my-4 w-50">
                                    </div>
                                @endif
                            </div>
                            <span class="text-lime-800 d-block mt-4">{{ count($article->comments) }} comments</span>

                            <a class="card-link text-slate-950  " href="{{ route('article.show', $article->id) }}">
                                View Detail &raquo;
                            </a>
                        </div>
                    </div>
                @endforeach
                <div>
                    {{ $articles->links() }}
                </div>
            </div>
            <div class="col-md-3 d-none d-md-block d-lg-block card shadow border-0">

                <form class="my-3 bt-2" action="{{ route('article.search') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="text" name="phrase" class="form-control form-control-sm" placeholder="Search">
                        </div>
                        <div class="col">
                            <input type="submit" class="btn btn-sm bg-slate-950 hover-bg-slate-800" value="Search">
                        </div>
                    </div>
                </form>
                <hr class="my-0">
                <div class="badges my-3">
                    @foreach ($categories as $category)
                        <a href="{{ route('article.filter', $category) }}"
                            class="badge text-white bg-slate-950 text-decoration-none">{{ $category->name }}</a>
                    @endforeach
                    <hr>
                </div>
            </div>
        </div>





    </div>
    </div>
@endsection
