@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('password-changed'))
                <div class="alert alert-success">
                    Password updated successfully.
                </div>
            @endif
                <div class="card border-0 shadow">
                    <div class="card-header d-flex">
                        <div class="mt-1">Update Profile</div>
                        <form action="{{ route('user.update', $user) }}" method="POST" class="ms-auto"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                    </div>

                    <div class="card-body text-center d-flex justify-content-between">

                        <div class="col-6 me-1">
                            {{-- <img src="{{ asset('storage/' . $user->profile) }}" alt=""
                                class="w-25"> --}}
                            <label>Profile Picture</label>
                            <input type="file" class="form-control mt-2" name="profile">
                        </div>
                        <div class="col-6 ">
                            <div class="my-2">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row text-center mb-3">
                        <div class="col-12">
                            <button type="submit" class="profile-settings btn btn-outline-dark btn-sm">Save
                                <i class="fa fa-floppy-o"></i>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            {{-- password update --}}
            <div class="col-md-10 mt-5">
                <div class="card border-0 shadow">
                    <div class="card-header d-flex">
                        <div class="mt-1">Update Password</div>
                        <form action="{{ route('user.password.update', $user) }}" method="POST" class="ms-auto">
                            @csrf
                            @method('PUT')
                    </div>

                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">

                        <div class="col-6 me-1">

                            <label>Old password</label>
                            <input type="password" class="form-control mt-2" name="old_password">
                            @error('failed')
                                <small class="text-danger">old password does't match</small>
                            @enderror
                            @error('password')
                                <small class="text-danger">old password required</small>
                            @enderror
                        </div>
                        <div class="col-6 ">
                            <div class="my-2">
                                <label>New password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="col-6 ">
                            <div class="my-2">
                                <label>Confirm password</label>
                                <input type="password" class="form-control" name="password_confirmation">
                                @error('password')
                                    <small class="text-danger">password comfirmation does not match.</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="profile-settings btn btn-outline-dark btn-sm">Update Password
                                <i class="fa fa-cog"></i>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-10 mt-5">
                <div class="card border-danger shadow">
                    <div class="card-body text-center d-flex justify-content-between">
                        <div class="col-6 me-1">
                            <a href="" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteConfirm">Delete Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title text-danger" id="exampleModalLongTitle">Are you sure you want to delete your
                        account? <br> You will lose all of your data. This task cannot be undone.</p>
                </div>

                <div class="modal-footer">
                    <form action="{{ route('user.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button href="" type="submit" class="btn btn-danger">Confirm</button>
                    </form>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
