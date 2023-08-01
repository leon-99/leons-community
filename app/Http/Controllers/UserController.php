<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show(User $user)
    {
        if (auth()->user() and auth()->user()->id == $user->id) {
            return redirect('home');
        }
        return view('view-user', [
            'user' => $user
        ]);
    }
    public function edit(User $user)
    {
        return view('update-profile', [
            'user' => $user
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->name = $request->name;
        if ($request->hasFile('profile')) {
            // delete the old profile
            $oldProfile = $user->profile;
            if ($oldProfile != 'profile-pictures/default-profile.png') {
                Storage::delete('public/' . $oldProfile);
            }

            // to solve image conflict
            $imageName = 'profile-pictures/'.auth()->user()->id.'/'.time().'.'.$request->profile->extension();

            $request->profile->storeAs('public', $imageName);
            $user->profile = $imageName;
        }
        $user->save();
        return redirect()->route('home');
    }

    public function destroy(User $user)
    {
        if (Gate::denies('user-update', $user->id)) {
            return back()->with('user-delete-error', "account delete failed");
        }

        // delete the old profile
        $oldProfile = $user->profile;
        if ($oldProfile != 'profile-pictures/default-profile.png') {
            Storage::deleteDirectory('public/profile-pictures/'.auth()->user()->id);
        }

        Storage::deleteDirectory('public/article-images/'.auth()->user()->id);

        // logout the user
        auth()->logout();



        // delete the user
        $user->delete();

        return redirect('/');
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        if (!Hash::check($request->old_password, $user->password)) {
           return back()->withErrors(['failed' => 'old password does not match']);
        };

        $user->update(['password' =>  bcrypt($request->password)]);

        return back()->with('password-changed', 'password-changed');
    }
}
