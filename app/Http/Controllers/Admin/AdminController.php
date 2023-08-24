<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;


class AdminController extends Controller
{
    public function index()
    {
        // exclude the current user
        $users = User::where('id', '!=',auth()->id())->latest()->paginate(10);

        return view('admin.dashboard', ['users' => $users]);
    }

    public function showUser(User $user)
    {
        $articles = Article::where('user_id', $user->id)->latest()->paginate(10);
        return view('admin.view-user', [
            'user' => $user,
            'articles' => $articles
        ]);
    }

    public function showArticle(Article $article)
    {
        return view('admin.view-article', [
            'article' => $article
        ]);
    }

    public function deleteUser(User $user)
    {
        if(Gate::denies('admin-operate')) {
            return back();
        };
        // delete the old profile
        $oldProfile = $user->profile;
        if ($oldProfile != 'profile-pictures/default-profile.png') {
            Storage::deleteDirectory('public/profile-pictures/' . $user->id);
        }

        Storage::deleteDirectory('public/article-images/' . $user->id);

        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted');
    }


    public function deleteArticle(Article $article)
    {
        if(Gate::denies('admin-operate')) {
            return back();
        };

        // delete the article image
        $image = 'public/' . $article->image;
        Storage::delete($image);

        // delete the article from database
        $article->delete();

        return redirect()->route('admin.user.show', $article->user_id)->with('success', 'User deleted');
    }

    public function deleteComment(Comment $comment)
    {
        if(Gate::denies('admin-operate')) {
            return back();
        };

        $comment->delete();
        return back();
    }

    public function toggleAdmin(User $user)
    {
        if(Gate::denies('admin-operate')) {
            return back();
        };

        // check if the user is verified
        if($user->email_verified_at == NULL) {
            return back()->with('warning', 'You can not give admin permission to non-verify users.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        if($user->is_admin) {
            return back()->with('info', "sucessfully made {$user->name}, admin.");
        }
        return back()->with('info', "sucessfully removed {$user->name} from admin list.");

    }
}
