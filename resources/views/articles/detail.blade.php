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

        <div class="card mb-2 border-0 shadow">
            <div class="card-body">
                <div class="row d-flex justify-content-start">
                    <div class="col-md-1 text-center pe-0">
                        <img src="{{ asset('storage/' . $article->user->profile) }}" alt=""
                            class="w-50 rounded-circle">
                    </div>
                    <div class="col-md-11 ps-0">
                        <a href="/user/view/{{ $article->user_id }}" class="text-reset text-decoration-none"><b
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
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('storage/' . $article->image) }}" class="img-thumbnail my-4 w-50">
                        </div>
                    @endif
                </div>
                <div class="my-4">
                    @can('article-update', $article)
                        <a class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#articleEdit">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                    @endcan
                    @can('article-delete', $article)
                        <a class="btn btn-danger" href="{{ route('article-delete', $article->id) }}">
                            <i class="fa fa-trash"></i>
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @guest
                    <div class="alert alert-secondary shadow border-0">
                        You must login to comment on this post.
                    </div>
                @endguest
                @auth
                    <form action="{{ route('comment-add') }}" method="post" class="pt-2">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
                        <input type="submit" value="Add Comment" class="btn btn-success">
                    </form>
                @endauth
                <ul class="list-group mt-3 shadow border-0">
                    <li class="list-group-item">
                        <b>Comments ({{ count($article->comments) }})</b>
                    </li>
                    @foreach ($article->comments->reverse() as $comment)
                        <li class="list-group-item">
                            <div class="row d-flex justify-content-start">
                                <div class="col-md-1 text-center pe-0 d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('storage/' . $comment->user->profile) }}" alt=""
                                        class="rounded-circle" style="width: 40%;">
                                </div>
                                <div class="col-md-11 ps-0">

                                    <a href="/user/view/{{ $comment->user_id }}" class="text-reset text-decoration-none"><b
                                            class="d-block">{{ $comment->user->name }}</b></a>
                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                    @if ($comment->edited == 1)
                                        <small> | <span class="text-success">Edited</span></small>
                                    @endif

                                </div>
                            </div>
                            <p class="mt-3">{{ $comment->content }}</p>
                            @can('comment-delete', $comment)
                                <a href="{{ route('comment-delete', $comment->id) }}"
                                    class="btn btn-sm btn-danger float-end mx-2"><i class="fa fa-trash"></i></a>
                            @endcan
                            @can('comment-update', $comment)
                                <a class="btn btn-sm btn-success float-end" data-bs-toggle="modal" data-bs-target="#commentEdit{{$comment->id}}">
                                    <i class="fa fa-pencil-square"></i>
                                </a>
                                <!-- comment update modal -->
                                <div class="modal fade" id="commentEdit{{$comment->id}}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <p class="modal-title text-dark" id="exampleModalLongTitle">Update your comment
                                                </p>
                                            </div>

                                            <div class="modal-footer">
                                                <form action="{{ url("/comments/edit/$comment->id") }}" method="post"
                                                    class="pt-2 w-100">
                                                    @csrf
                                                    <input type="hidden" name="article_id" value="{{ $comment->article_id }}">
                                                    <input type="hidden" name="user_id" value="{{ $comment->user_id }}">
                                                    <textarea name="content" class="form-control mb-2">{{ $comment->content }}</textarea>
                                                    <input type="submit" value="Update Comment" class="btn btn-secondary">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- article update modal -->
    <div class="modal fade" id="articleEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title text-dark" id="exampleModalLongTitle">Update your article</p>
                </div>

                <div class="modal-footer">
                    <form action="{{ route('article-update', $article->id) }}" method="post" class="pt-2 w-100"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->id }}">
                        <input type="hidden" name="user_id" value="{{ $article->user_id }}">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" value="{{ $article->title }}" name="title" class="form-control"
                                id="title">
                        </div>
                        <div class="form-group mt-3">
                            <label for="body">Content</label>
                            <textarea name="body" class="form-control mb-2" id="body">{{ $article->body }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Image</label>
                            <input class="form-control" type="file" name="image">
                        </div>
                        <div class="md-2">
                            <lable>Category</lable>
                            <select name="category_id" class="form-control">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <input type="submit" value="Update Post" class="btn btn-success">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
