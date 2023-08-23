<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(CommentCreateRequest $request)
    {
        Comment::create([
            'content' => $request->content,
            'article_id' => $request->article_id,
            'user_id' => auth()->user()->id
        ]);

        return back();
    }

    public function update(CommentUpdateRequest $request, Comment $comment)
    {
        $comment->update([
            'content' => $request->content,
            'edited' => 1
        ]);
        return redirect()->route('article.show', $comment->article->id)->with('info', 'comment-updated');
    }

    public function destroy(Comment $comment)
    {
        if (Gate::denies('comment-delete', $comment)) {
            return back()->with('warning', 'Unauthorized');
        }

        $comment->delete();
        return back()->with('info', 'Comment deleted');
    }
}
