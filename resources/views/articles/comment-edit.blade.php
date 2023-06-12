@extends('layouts.app')
@section('content')
    @auth
        <div class="container">
            <form action="{{ url("/comments/edit/$comment->id") }}" method="post" class="pt-2">
                @csrf
                <input type="hidden" name="article_id" value="{{ $comment->article_id }}">
                <input type="hidden" name="user_id" value="{{ $comment->user_id }}">
                <textarea name="content" class="form-control mb-2" >{{$comment->content}}</textarea>
                <input type="submit" value="Edit Comment" class="btn btn-secondary">
            </form>
        </div>
    @endauth
@endsection
