@extends('layouts.app')

@section('nav-title')
    <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}">
        Admin Dashboard
    </a>
@endsection

@section('title')
    <title>Blog | Admin Panel</title>
@endsection

@section('content')
    <div class="container">

        <h5 class="mb-2">Users</h5>

        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">User ID</th>
                <th scope="col">email</th>
                <th scope="col">Name</th>
                <th scope="col">Operations</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td><a href="{{ route('admin.user.show', $user) }}" class="btn btn-sm bg-slate-950 hover-bg-slate-800">View user</a></td>
                  </tr>
                @endforeach
            </tbody>
          </table>

          <div>
            {{ $users->links() }}
        </div>
    </div>
@endsection
