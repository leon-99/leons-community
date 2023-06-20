@extends('layouts.app')
@section('content')
    @auth
        <div class="container">
            <form action="{{ url("/articles/edit/$article->id") }}" method="post" class="pt-2" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <input type="hidden" name="user_id" value="{{ $article->user_id }}">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" value="{{ $article->title }}" name="title" class="form-control" id="title">
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
                </div>
            </form>
        </div>
    @endauth
@endsection
