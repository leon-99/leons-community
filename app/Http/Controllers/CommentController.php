<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        $comment = new Comment;
        $comment->content = request()->content;
        $comment->article_id = request()->article_id;
        $comment->user_id = auth()->user()->id;
        $comment->edited = 0;
        $comment->save();

        return back();
    }

    public function delete($id)
    {
        $comment = Comment::find($id);

        if (Gate::denies('comment-delete', $comment)) {
            return back()->with('comment-delete-error', 'Unauthorize');
        }

        $comment->delete();
        return back()->with('comment-delete-success', 'comment deleted');
    }


    public function edit ($id)
    {
        $comment = Comment::find($id);
        return view('articles/comment-edit', [
            "comment" => $comment
        ]);
    }
    public function update($id)
    {
        $comment = Comment::find($id);

        if (Gate::denies('comment-update', $comment)) {
            return back()->with('comment-update-error', 'Unauthorize');
        }

        $comment->content = request()->content;
        $comment->edited = '1';
        $comment->save();
        return redirect("/articles/detail/$comment->article_id")->with('comment-update-success', 'comment-updated');
    }
}
