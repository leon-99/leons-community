@extends('admin.layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}">
        Admin Dashboard
    </a>
@endsection

@section('title')
    <title>LC | Admin View User</title>
@endsection

@section('content')

        @if(session('info'))
        <div class="alert alert-light">
            {{session('info')}}
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning">
            {{session('warning')}}
        </div>
        @endif

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
                    <form action="{{route('admin.user.toggle.admin', $user)}}" method="POST">
                        @csrf
                       @if($user->is_admin)
                       <input type="submit" class="btn btn-sm bg-rose-950 hover-bg-rose-800" value="Remove Admin">
                       @else
                       <input type="submit" class="btn btn-sm bg-lime-950 hover-bg-lime-800" value="Make Admin">
                       @endif
                    </form>
                </div>

                {{-- @if ($user->is_admin)
                    <div class="col-6 d-flex align-items-center">
                        <form action="route('admin.user.toggle.admin')">
                            @csrf
                            <input type="submit" href="" class="btn btn-sm bg-lime-950 hover-bg-lime-800">Make Admin
                        </form>
                    </div>
                @else
                    <div class="col-6 d-flex align-items-center">
                        <a href="" class="btn btn-sm bg-lime-950 hover-bg-lime-800">Make Admin</a>
                    </div>
                @endif --}}

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
            {{ $articles->links() }}
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
    </div>
    </div>
@endsection
