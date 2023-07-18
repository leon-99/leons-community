<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;


class UserController extends Controller
{

    public function show($id) {
        $user = User::find($id);
        if(auth()->user() and auth()->user()->id == $id) {
            return redirect('home');
        }
        return view('view-user', [
            'user' => $user
        ]);
    }
    public function edit($id)
    {
        $user = User::find($id);
        return view('update-profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {

        if (Gate::denies('user-update', $id)) {
            return back()->with('user-update-error', "user update failed");
        }

        $user = User::find($id);
        $user->name = $request->name;
        if($request->hasFile('profile')) {
            $user->profile = request()->file('profile')->store('profile-pictures', 'public');
        }
        $user->save();
        return redirect()->route('home');
    }
    public function delete($id) {
        if (Gate::denies('user-update', $id)) {
            return back()->with('user-delete-error', "account delete failed");
        }
        $user = User::find($id);
        auth()->logout();
        $user->delete();
        return redirect('/');
    }
}
