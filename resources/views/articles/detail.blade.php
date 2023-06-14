@extends('layouts.app')
@section('content')
    <div class="container">
        @if (session('comment-update-success'))
            <div class="alert alert-success">
                Comment updated.
            </div>
        @endif

        @if (session('comment-delete-error'))
            <div class="alert alert-warning">
                Not Authorized to delete the comment.
            </div>
        @endif

        @if (session('comment-delete-success'))
            <div class="alert alert-success">
                Comment deleted.
            </div>
        @endif

        @if (session('artcile-delete-success'))
            <div class="alert alert-success">
                Article deleted.
            </div>
        @endif

        @if (session('article-delete-error'))
            <div class="alert alert-warning">
                Not Authorized to delete the aticle.
            </div>
        @endif


        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}
                </h5>
                <span class="badge badge-pill text-monospace text-light bg-dark mb-3">Category:
                    {{ $article->category->name }}</span>
                <div class="card-subtitle mb-2 text-muted small">
                    by <b>{{ $article->user->name }}</b>
                    {{ $article->created_at->diffForHumans() }}
                </div>
                <p class="card-text">{{ $article->body }}</p>
                @auth
                    @if ($article->user_id == auth()->user()->id)
                        <a class="btn btn-danger" href="{{ url("/articles/delete/$article->id") }}">
                            Delete
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <ul class="list-group">
                    <li class="list-group-item active">
                        <b>Comments ({{ count($article->comments) }})</b>
                    </li>
                    @foreach ($article->comments as $comment)
                        <li class="list-group-item">
                            <p style="overflow-wrap: break-word">{{ $comment->content }}</p>
                            @if ($comment->user_id == Auth::id())
                                <a href="{{ url("/comments/delete/$comment->id") }}"
                                    class="btn btn-sm btn-danger float-end mx-2">Delete</a>
                            @endif
                            @if ($comment->user_id == Auth::id())
                                <a href="{{ url("/comments/edit/$comment->id") }}"
                                    class="btn btn-sm btn-primary float-end">Edit</a>
                            @endif

                            <div class="small mt-2">
                                By <b>{{ $comment->user->name }}</b>,
                                {{ $comment->created_at->diffForHumans() }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @auth
            <form action="{{ url('/comments/add') }}" method="post" class="pt-2">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
                <input type="submit" value="Add Comment" class="btn btn-secondary">
            </form>
        @endauth
    </div>
@endsection
