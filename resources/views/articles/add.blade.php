@extends('layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('index') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
@endsection

@section('title')
    <title>LC | Create Article</title>
@endsection

@section('content')
    <div class="container" style="max-width: 800px;">
        <form method="post" enctype="multipart/form-data" action="{{route('article.store')}}">
            @csrf
            <div class="mb-2">
                <lable class="form-label">Title</lable>
                <input type="text" class="form-control" name="title">
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-2">
                <lable class="form-label">Body</lable>
                <textarea name="body" cols="30" rows="10" class="form-control"></textarea>
                @error('body')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" name="image">
                @error('image')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <lable>Category</lable>
                <select name="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-sm bg-lime-950 hover-bg-lime-800">Add Article</button>
        </form>
    </div>
@endsection
