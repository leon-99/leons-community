@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="sticky-top">
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
                <div class="card-body row">
                    <div class="col-md-6">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <div class="card-subtitle mb-2 text-muted small">
                            <span>Category: <b>{{ $article->category->name }}</b></span><br>
                            {{ $article->created_at->diffForHumans() }}

                            by <b>{{ $article->user->name }}</b><br>
                            <span class="text-success">{{ count($article->comments) }} comments</span>
                        </div>
                        <p class="card-text" style="white-space: pre-wrap;">{{ substr($article->body, 0, 200) . ' . . .' }}
                        </p>
                    </div>
                    @if (isset($article->image))
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('storage/' . $article->image) }}" class="img-thumbnail my-4 w-50">
                        </div>
                    @endif
                    <a class="card-link text-success" href="{{ url("/articles/detail/$article->id") }}">
                        View Detail &raquo;
                    </a>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection
