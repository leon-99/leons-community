<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

    public function update(Request $request, User $user)
    {

        if (Gate::denies('user-update', $user->id)) {
            return back()->with('user-update-error', "user update failed");
        }

        $user->name = $request->name;
        if ($request->hasFile('profile')) {
            $user->profile = request()->file('profile')->store('profile-pictures', 'public');
        }
        $user->save();
        return redirect()->route('home');
    }
    public function destroy(User $user)
    {
        if (Gate::denies('user-update', $user->id)) {
            return back()->with('user-delete-error', "account delete failed");
        }
        auth()->logout();
        $user->delete();
        return redirect('/');
    }
}
