@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('article-delete-success'))
            <div class="alert alert-success">
                An article deleted.
            </div>
        @endif
        <div class="row justify-content-center">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="col-md-4">
                <div class="card border-0 shadow">
                    <div class="card-header d-flex">
                        <div class="mt-1">Profile</div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex text-center border-bottom mb-5">
                            <div class="col-6"><img src="{{ asset('storage/' . $user->profile) }}" alt=""
                                    class="w-50 rounded-circle">
                            </div>
                            <div class="col-6">
                                <h5 class="mt-3">{{ $user->name }}</h5>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                       <div class="">
                        <a href="{{ route('user.edit', $user) }}" class="btn btn-outline-success w-100 my-1">Settings</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-outline-danger w-100 my-1" value="Logout">
                        </form>

                       </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow">
                    <div class="card-header">{{ __('Your Posts') }}</div>

                    <div class="card-body">
                        @unless ($articles->count() == 0)
                            @foreach ($articles as $article)
                                <div class="card mb-2 border-0 shadow">
                                    <div class="card-body d-flex">
                                        <div class="col-6">
                                            <h5 class="card-title">{{ $article->title }}</h5>
                                            <div class="card-subtitle mb-2 text-muted small">
                                               <span> {{ $article->created_at->diffForHumans() }}</span>
                                                by <b>{{ $article->user->name }}</b>
                                                <br>
                                                <b class="text-success">{{count($article->comments)}} comments</b>
                                            </div>
                                            <p class="card-text">{{ substr($article->body, 0, 200) . ' . . .' }}</p>
                                            <a class="card-link btn btn-sm btn-outline-success"
                                                href="{{ route('article.show', $article->id) }}">
                                                View Detail <i class="fa fa-info"></i>
                                            </a>

                                            <form action="{{ route('article.delete', $article->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="from-profile">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            </a>
                                        </div>
                                        <div class="col-6 d-flex justify-content-center align-items-start">
                                            <img src="{{ asset('storage/' . $article->image) }}" alt="" class="w-50 ">
                                        </div>

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
