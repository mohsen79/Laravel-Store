<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Comment\Entities\Comment;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        $data = $request->validate([
            'comment' => 'required',
            'commentable_id' => 'required',
            'commentable_type' => 'required',
            'parent_id' => 'integer'
        ]);
        auth()->user()->comments()->create($data);
        return back();
    }
    public function index()
    {
        $comments = Comment::all()->where('approved', 0);
        return view('comment::index', compact('comments'));
    }

    public function approved()
    {
        $comments = Comment::all()->where('approved', 1);
        return view('comment::approved', compact('comments'));
    }
    public function update(Comment $comment)
    {
        $comment->update([
            'approved' => 1
        ]);
        return back();
    }
    public function destroy(Comment $comment)
    {
        $comment->child()->delete();
        $comment->delete();
        return back();
    }
}
