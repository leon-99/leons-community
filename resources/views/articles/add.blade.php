@extends('layouts.app')
@section('content')
    <div class="container" style="max-width: 800px;">

        @if($errors->any())
            <div class="alert alert-warning">
                @foreach ($errors->all() as $err)
                    {{ $err }}
                @endforeach
            </div>
        @endif

        <form action="/articles/add" method="post">
            @csrf
            <div class="md-2">
                <lable>Title</lable>
                <input type="text" class="form-control" name="title">
            </div>

            <div class="md-2">
                <lable>Body</lable>
                <input type="text" class="form-control" name="body">
            </div>

            <div class="md-2">
                <lable>Category</lable>
                <select name="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-primary mt-3">Add Article</button>
        </form>
    </div>
@endsection
