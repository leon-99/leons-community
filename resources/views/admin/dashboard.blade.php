@extends('admin.layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}">
        Admin Dashboard
    </a>
@endsection

@section('title')
    <title>LC | Admin Panel</title>
@endsection

@section('content')
    <h5 class="mb-2">Users</h5>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">User ID</th>
                <th scope="col">Status</th>
                <th scope="col">Email</th>
                <th scope="col">Name</th>
                <th scope="col">Operations</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @if($user->email_verified_at != NULL)
                            <span class="text-success">Verified</span>
                        @else
                        <span class="text-danger">Not Verified</span>
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td><a href="{{ route('admin.user.show', $user) }}"
                            class="btn btn-sm bg-slate-950 hover-bg-slate-800">View user</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $users->links() }}
    </div>
    </div>
@endsection
