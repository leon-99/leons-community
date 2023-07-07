<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function edit($id)
    {
        $user = User::find($id);
        return view('update-profile', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        if($request->hasFile('profile')) {
            $user->profile = request()->file('profile')->store('profile-pictures', 'public');
        }
        $user->save();
        return redirect()->route('home');
    }
}
