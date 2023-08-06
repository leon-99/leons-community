@extends('layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}">
        Admin Dashboard
    </a>
@endsection

@section('title')
    <title>Blog | Admin View User</title>
@endsection

@section('content')
    <div class="container">
        <h4 class="text-center my-3">Admin Panel</h4>
        <h5 class="mb-2">Users / user {{ $user->id }}</h5>

        <div class="my-3">
            <div class="d-flex py-3">
                <div class="col-4 text-center">
                    <img src="{{ asset('storage/' . $user->profile) }}" alt=""
                        class="rounded-circle object-fit-cover w-50">
                </div>
                <div class="col-4 d-flex flex-column justify-content-center">
                    <h5>{{ $user->name }}</h5>
                    <h5>{{ $user->email }}</h5>
                </div>
                <div class="col-4 d-flex">
                    <div class="col-6 d-flex align-items-center">
                        <a href="" data-bs-toggle="modal" data-bs-target="#deleteConfirm"
                            class="btn btn-sm bg-rose-950 hover-bg-rose-800">Delete User</a>
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <a href="" class="btn btn-sm bg-lime-950 hover-bg-lime-800">Some new feature</a>

                    </div>

                </div>
            </div>
        </div>

        <div class="posts">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Attachments</th>
                        <th scope="col">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ substr($article->title, 0, 100) . ' . . .' }}</td>
                            <td>1 image attached</td>
                            <td>
                                <a href="{{ route('admin.article.show', $article) }}"
                                    class="btn btn-sm bg-slate-950 hover-bg-slate-800">View Post</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{$articles->links() }}
            </div>
        </div>
    </div>

    <!-- Delete user Modal -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title text-danger" id="exampleModalLongTitle">Are you sure you want to delete
                        {{ $user->name }}'s
                        account?</p>
                </div>

                <div class="modal-footer">
                    <form action="{{ route('admin.user.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button href="" type="submit"
                            class="btn btn-sm bg-rose-950 hover-bg-rose-800">Confirm</button>
                    </form>
                    <button type="button" class="btn btn-sm bg-slate-950 hover-bg-slate-800"
                        data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
