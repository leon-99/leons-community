<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(CommentRequest $request)
    {
        Comment::create([
            'content' => $request->content,
            'article_id' => $request->article_id,
            'user_id' => auth()->user()->id
        ]);

        return back();
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        if (Gate::denies('comment-update', $comment)) {
            return back()->with('comment-update-error', 'Unauthorize');
        }

        $comment->update([
            'content' => $request->content,
            'edited' => 1
        ]);
        return redirect()->route('article.show', $comment->article->id)->with('comment-update-success', 'comment-updated');
    }

    public function destroy(Comment $comment)
    {
        if (Gate::denies('comment-delete', $comment)) {
            return back()->with('comment-delete-error', 'Unauthorize');
        }

        $comment->delete();
        return back()->with('comment-delete-success', 'comment deleted');
    }
}
