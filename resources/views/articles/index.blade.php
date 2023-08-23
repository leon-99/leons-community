@extends('layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('index') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
@endsection
@section('title')
    <title>LC | Home</title>
@endsection
@section('content')
    <div class="mx-4">
        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
        {{-- show only on mobile devices --}}
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

        <div class="d-flex">
            <div class="d-none d-md-block d-lg-block card shadow border-0 position-fixed" style="width: 25%">
                <div class="d-flex text-center py-3">
                    <div class="col-6">
                        @if (auth()->user())
                            <img src="{{ asset('storage/' . auth()->user()->profile) }}" alt=""
                                class="rounded-circle object-fit-cover" style="width: 70px; height: 70px">
                        @else
                            <img src="{{ asset('storage/profile-pictures/default-profile.png') }}" alt=""
                                class="rounded-circle object-fit-cover" style="width: 70px; height: 70px">
                        @endif

                    </div>
                    <div class="col-6">
                        @if (auth()->user())
                            <a class="mt-4 h5 text-decoration-none d-block text-slate-950 hover-text-slate-800"
                                href="{{ route('user.show', auth()->user()) }}">{{ auth()->user()->name }}</a>
                        @else
                            <h5 class="mt-4">You are not logged in.</h5>
                        @endif
                    </div>
                </div>

                <hr class="my-0">

                <form class="my-3 mx-2" action="{{ route('article.search') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <input type="text" name="phrase" class="form-control form-control-sm" placeholder="Search">
                        </div>
                        <div class="col">
                            <input type="submit" class="btn btn-sm bg-lime-950 hover-bg-lime-800" value="Search">
                        </div>
                    </div>
                </form>
                <hr class="my-0">
                <div class="badges my-3 mx-2">
                    @foreach ($categories as $category)
                        <a href="{{ route('article.filter', $category) }}"
                            class="badge text-white bg-lime-950 hover-bg-lime-800 text-decoration-none">{{ $category->name }}</a>
                    @endforeach
                    <hr>
                </div>
                <div class="links text-center">
                    <p><b>Popular Articles</b></p>
                    <ul class="list-group">
                        @foreach ($popularArticles as $popArticle)
                            <li class="list-group-item">
                                <a href="{{ route('article.show', $popArticle->id) }}"
                                    class="text-decoration-none">{{ $popArticle->title }} | <span
                                        class="text-success">{{ count($popArticle->comments) }} comments</span></a>

                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="ms-auto main-bar">
                @if (isset($title))
                    <div class="alert alert-light">({{ $count }}) {{ $title }}</div>
                @endif
                @if (request()->getRequestUri() === '/articles/search')
                    <p class="text-center">Users</p>
                    @foreach ($users as $user)
                        <div class="card border-0 shadow px-2 py-3 my-2 d-flex flex-row align-items-center">
                            <div class="col-3 col-sm-2 col-md-2 col-lg-1 text-center pe-0">
                                <img src="{{ asset('storage/' . $user->profile) }}" alt=""
                                    class="rounded-circle object-fit-cover" style="width: 40px; height: 40px">
                            </div>
                            <div class="col-9 col-sm-10 col-md-10 col-lg-11 ps-0">
                                <a href="{{ route('user.show', $user) }}" class="text-reset text-decoration-none"><b
                                        class="d-block">{{ $user->name }}</b></a>
                            </div>
                        </div>
                    @endforeach
                    <hr>
                @endif
                @if ($articles->count() > 0 and request()->getRequestUri() != '/')
                    <p class="text-center">Articles</p>
                @endif
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

        </div>





    </div>
    </div>
@endsection
