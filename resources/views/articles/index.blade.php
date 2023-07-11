@extends('layouts.app')
@section('content')
    <div class="container">
        <div>
            {{ $articles->links() }}
        </div>

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


        @foreach ($articles as $article)
            <div class="card mb-2 border-0 shadow">
                <div class="card-body">
                    <div class="row d-flex justify-content-start">
                        <div class="col-md-1 text-center pe-0">
                            <img src="{{ asset('storage/' . $article->user->profile) }}" alt="" class="w-50 rounded-circle">
                        </div>
                        <div class="col-md-11 ps-0">
                            <a href="/user/view/{{$article->user_id}}" class="text-reset text-decoration-none"><b class="d-block">{{ $article->user->name }}</b></a>
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
                                <img src="{{ asset('storage/' . $article->image) }}" class="img-thumbnail my-4 w-50">
                            </div>
                        @endif
                    </div>
                    <span class="text-success d-block mt-4">{{ count($article->comments) }} comments</span>

                    <a class="card-link text-success" href="{{ route('article-detail', $article->id) }}">
                        View Detail &raquo;
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    </div>
@endsection
