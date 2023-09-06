@extends('layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('index') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
@endsection

@section('title')
    <title>LC | {{ substr($article->title, 0, 20) }}</title>
@endsection


@section('content')
    <div class="container">

        @if (session('info'))
            <div class="alert alert-success">
               {{session('info')}}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{session('warning')}}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

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
                    @can('article-update', $article)
                        <a class="btn btn-sm bg-slate-950 hover-bg-slate-800 mx-2" data-bs-toggle="modal"
                            data-bs-target="#articleEdit">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                    @endcan
                    @can('article-delete', $article)
                        <form action="{{ route('article.delete', $article->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm bg-rose-950 hover-bg-rose-800">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
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
                    @if (auth()->user()->email_verified_at != null)
                        <form action="{{ route('comments.store') }}" method="post" class="pt-2">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
                            <input type="submit" value="Add Comment" class="btn btn-sm bg-lime-950 hover-bg-lime-800">
                        </form>
                    @else
                    <div class="alert alert-secondary shadow border-0">
                        You must verify your email to comment on this post.
                    </div>
                    @endif
                @endauth


                <ul class="list-group mt-3 shadow border-0">
                    <li class="list-group-item">
                        <b>Comments ({{ count($comments) }})</b>
                    </li>
                    @foreach ($comments->reverse() as $comment)
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
                                            class="d-block">{{ $comment->user->name }}  @if($comment->user->id == auth()->id()) (You) @endif</b></a>
                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                    @if ($comment->edited == 1)
                                        <small> | <span class="text-success">Edited</span></small>
                                    @endif
                                    <p class="mt-3">{{ $comment->content }}</p>
                                </div>
                            </div>
                            @can('comment-delete', $comment)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm bg-rose-950 hover-bg-rose-800 float-end mx-2"><i
                                            class="fa fa-trash"></i></button>
                                </form>
                            @endcan
                            @can('comment-update', $comment)
                                <a class="btn btn-sm bg-slate-950 hover-bg-slate-800 float-end" data-bs-toggle="modal"
                                    data-bs-target="#commentEdit{{ $comment->id }}">
                                    <i class="fa fa-pencil-square"></i>
                                </a>
                                <!-- comment update modal -->
                                <div class="modal fade" id="commentEdit{{ $comment->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <p class="modal-title text-dark" id="exampleModalLongTitle">Update your
                                                    comment
                                                </p>
                                            </div>

                                            <div class="modal-footer">
                                                <form action="{{ route('comments.update', $comment->id) }}" method="POST"
                                                    class="pt-2 w-100">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                                    <input type="hidden" name="user_id" value="{{ $comment->user_id }}">
                                                    <textarea name="content" class="form-control mb-2">{{ $comment->content }}</textarea>
                                                    <input type="submit" value="Update Comment"
                                                        class="btn btn-sm bg-lime-950 hover-bg-lime-800">
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
                    <form action="{{ route('article.update', $article->id) }}" method="POST" class="pt-2 w-100"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                            <input type="submit" value="Update Post" class="btn btn-sm bg-lime-950 hover-bg-lime-800">
                            <button type="button" class="btn btn-sm bg-slate-950 hover-bg-slate-800"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
