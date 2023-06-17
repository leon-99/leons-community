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

        @if (session('article-updated'))
            <div class="alert alert-success">
                Article updated.
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
                @can('article-update', $article)
                    <a class="btn btn-outline-primary mx-2" href="{{ url("/articles/edit/$article->id") }}">
                        <i class="fa fa-pencil-square"></i>
                    </a>
                @endcan
                @can('article-delete', $article)
                    <a class="btn btn-outline-danger" href="{{ url("articles/delete/$article->id") }}">
                        <i class="fa fa-trash"></i>
                    </a>
                @endcan
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @guest
                    <div class="alert alert-secondary">
                        You must login to comment on this post.
                    </div>
                @endguest
                @auth
                    <form action="{{ url('/comments/add') }}" method="post" class="pt-2">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
                        <input type="submit" value="Add Comment" class="btn btn-outline-success">
                    </form>
                @endauth
                <ul class="list-group mt-3">
                    <li class="list-group-item active">
                        <b>Comments ({{ count($article->comments) }})</b>
                    </li>
                    @foreach ($article->comments->reverse() as $comment)
                        <li class="list-group-item">
                            <p style="overflow-wrap: break-word"><b class="text-success">{{ $comment->user->name }}</b> -
                                {{ $comment->content }}</p>
                            @can('comment-delete', $comment)
                                <a href="{{ url("/comments/delete/$comment->id") }}"
                                    class="btn btn-sm btn-outline-danger float-end mx-2"><i class="fa fa-trash"></i></a>
                            @endcan
                            @can('comment-update', $comment)
                                <a href="{{ url("/comments/edit/$comment->id") }}"
                                    class="btn btn-sm btn-outline-primary float-end">
                                    <i class="fa fa-pencil-square"></i>
                                </a>
                            @endcan

                            <div class="small mt-2">
                                {{ $comment->created_at->diffForHumans() }},

                                @if ($comment->edited == 1)
                                    <span class="text-success">Edited</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
